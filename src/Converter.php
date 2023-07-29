<?php

/**
 * XML library allowing to parse XML as array converting node values/attributes types using XSD.
 *
 * @author [deepeloper](https://github.com/deepeloper)
 * @license [MIT](https://opensource.org/licenses/mit-license.php)
 */

namespace deepeloper\Lib\XML;

use DOMDocument;
use deepeloper\Lib\XML\Exception\XMLException;

class Converter
{
    public const COLLAPSE_ATTRIBUTES = "COLLAPSE_ATTRIBUTES";

    public const COLLAPSE_CHILDREN = "COLLAPSE_CHILDREN";

    public const COLLAPSE_ARRAYS = "COLLAPSE_ARRAYS";

    /**
     * @var array
     */
    protected $complexTypes;

    /**
     * @var array
     */
    protected $elementToType;

    protected $duplicateElementsHavingSameComplexType;

    /**
     * @var array
     */
    protected $elementsAttributes;

    /**
     * Parses XML to array without type conversion.
     *
     * @param string $xml
     * @return array
     * @see https://www.php.net/manual/en/function.xml-parse-into-struct.php#66487
     */
    public function xmlToArray($xml)
    {
        $parser = xml_parser_create();
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, false);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, true);
        xml_parse_into_struct($parser, $xml, $nodes);
        $code = xml_get_error_code($parser);
        if (0 !== $code) {
            throw new XMLException(xml_error_string($code) . " [$code]");
        }
        xml_parser_free($parser);
        $entities = [
            'tag' => "/name",
            'attributes' => "/attributes",
            'value' => "/value",
        ];
        $elements = []; // the currently filling [child] node struct array
        $stack = [];
        foreach ($nodes as $node) {
            $index = sizeof($elements);
            $push = "open" === $node['type'];
            if ("complete" === $node['type'] || $push) {
                $elements[$index] = [];
                foreach ($entities as $source => $target) {
                    if (isset($node[$source])) {
                        $elements[$index][$target] = $node[$source];
                    }
                }
                // push
                if ($push) {
                    $elements[$index]['/children'] = [];
                    $stack[sizeof($stack)] = &$elements;
                    $elements = &$elements[$index]['/children'];
                }
            }
            // pop
            if ("close" === $node['type']) {
                $elements = &$stack[sizeof($stack) - 1];
                unset($stack[sizeof($stack) - 1]);
            }
        }
        return $elements[0]; // the single top-level element
    }

    /**
     * Parses XML file with type conversion.
     *
     * @param string $xml
     * @param string $xsd
     * @param array $options
     * @return array
     */
    public function parse($xml, $xsd, array $options = [])
    {
        $xml = $this->xmlToArray($xml);
        $this->parseXSD($xsd);
        $this->convertTypes($xml);

        if (!empty($options[self::COLLAPSE_ATTRIBUTES])) {
            $this->collapseAttributes($xml);
        }
        if (!empty($options[self::COLLAPSE_CHILDREN])) {
            $this->collapseChildren($xml);
        }
        if (isset($options[self::COLLAPSE_ARRAYS])) {
            $this->collapseArrays(
                $xml,
                is_array($options[self::COLLAPSE_ARRAYS]) &&
                isset($options[self::COLLAPSE_ARRAYS]['exclusions'])
                    ? $options[self::COLLAPSE_ARRAYS]['exclusions']
                    : [],
                $xml['/name']
            );
        }

        return $xml;
    }

    /**
     * @param string $xsd
     * @return void
     */
    protected function parseXSD($xsd)
    {
        $doc = new DOMDocument();
        if (!@$doc->loadXML($xsd)) {
            throw new XMLException("Cannot parse XSD");
        }
        $xsd = $doc->saveXML();
        $xsd = str_replace($doc->lastChild->prefix . ":", "", $xsd);
        $xsd = $this->xmlToArray($xsd);

        $this->complexTypes = [];
        $this->elementToType = [];
        $this->duplicateElementsHavingSameComplexType = [];
        $this->elementsAttributes = [];

        $this->collectComplexTypes($xsd['/children']);
        $this->parseXSDNodes($xsd['/children']);
        $this->duplicateComplexTypes();

        ksort($this->elementToType);
        ksort($this->elementsAttributes);
    }

    protected function collectComplexTypes(array $nodes)
    {
        foreach ($nodes as $node) {
            if ("complexType" === $node['/name']) {
                $this->complexTypes[$node['/attributes']['name']] = true;
            }
        }
    }

    /**
     * @return void
     */
    protected function parseXSDNodes(array $nodes, array $path = [], $complexType = null)
    {
        foreach ($nodes as $node) {
            switch ($node['/name']) {
                case "element":
                    if (null === $complexType) {
                        $type = $node['/attributes']['type'];
                        $currentPath = $path;
                        $currentPath[] = $node['/attributes']['name'];
                        $element = implode("/", $currentPath);
                        $duplicateElement = array_search($type, $this->elementToType);
                        $this->elementToType[$element] = $type;
                        if (isset($this->complexTypes[$type])) {
                            if (false !== $duplicateElement && $element !== $duplicateElement) {
                                $this->duplicateElementsHavingSameComplexType[$element] = $duplicateElement;
                            }
                            $this->parseXSDNodes($nodes, $currentPath, $type);
                        }
                    }
                    break;

                case "complexType":
                    if (isset($node['/children'])) {
                        $children = $node['/children'];
                        $first = array_shift($children);
                        $element = array_search($node['/attributes']['name'], $this->elementToType);
                        $currentPath = explode(
                            "/",
                            $element
                        );
                        if (isset($first['/children'])) {
                            $this->parseXSDNodes($first['/children'], $currentPath);
                        }
                        if (sizeof($children) > 0) {
                            $this->parseXSDNodes($children, $currentPath);
                        }
                    }
                    break;

                case "attribute":
                    $attributes = $node['/attributes'];
                    $attributeName = $attributes['name'];
                    unset($attributes['name']);
                    $this->elementsAttributes[implode("/", $path)][$attributeName] = $attributes;
                    break;
            }
        }
    }

    protected function duplicateComplexTypes()
    {
        foreach ($this->duplicateElementsHavingSameComplexType as $destination => $source) {
            $source .= "/";
            $destination .= "/";
            $elements = array_filter($this->elementToType, function ($key) use ($source) {
                return 0 === strpos($key, $source);
            }, ARRAY_FILTER_USE_KEY);
            foreach ($elements as $element) {
                $this->elementToType[str_replace($source, $destination, $element)] = $this->elementToType[$element];
            }
        }
    }

    protected function convertTypes(array &$node, array $path = [])
    {
        $path[] = $node['/name'];
        $element = implode("/", $path);
        if (isset($node['/attributes'])) {
            foreach ($node['/attributes'] as $attributeName => $attributeValue) {
                if (isset($this->elementsAttributes[$element][$attributeName])) {
                    $this->setType(
                        $node['/attributes'][$attributeName],
                        $this->elementsAttributes[$element][$attributeName]['type']
                    );
                }
            }
            if (isset($this->elementsAttributes[$element])) {
                foreach ($this->elementsAttributes[$element] as $attributeName => $attribute) {
                    if (isset($attribute['default']) && !isset($node['/attributes'][$attributeName])) {
                        $node['/attributes'][$attributeName] = $attribute['default'];
                        $this->setType(
                            $node['/attributes'][$attributeName],
                            $attribute['type']
                        );
                    }
                }
            }
        }
        if (isset($node['/children'])) {
            foreach (array_keys($node['/children']) as $index) {
                $this->convertTypes($node['/children'][$index], $path);
            }
        }
        if (isset($node['/value']) && isset($this->elementToType[$element])) {
            $this->setType(
                $node['/value'],
                $this->elementToType[$element]
            );
        }
    }

    /**
     * @param mixed $variable
     * @param string $type
     * @return void
     */
    protected function setType(&$variable, $type)
    {
        switch ($type) {
            case "string":
                break;

            case "boolean":
                $variable = "true" === strtolower($variable);
                break;

            case "unsignedInt":
                settype($variable, "int");
                $variable = abs($variable);
                break;

            default:
                settype($variable, $type);
        }
    }

    protected function collapseAttributes(array &$node)
    {
        if (isset($node['/attributes'])) {
            $node = array_merge($node, $node['/attributes']);
            unset($node['/attributes']);
        }
        if (isset($node['/children'])) {
            foreach (array_keys($node['/children']) as $index) {
                $this->collapseAttributes($node['/children'][$index]);
            }
        }
    }

    protected function collapseChildren(array &$node)
    {
        if (isset($node['/value'])) {
            $node = $node['/value'];
            return;
        }
        if (!isset($node['/children'])) {
            return;
        }
        $children = &$node['/children'];
        foreach (array_keys($children) as $index) {
            $child = &$children[$index];
            if (is_array($child)) {
                $name = $child['/name'];
                unset($child['/name']);
                $this->collapseChildren($child);
                $node[$name][] = $child;
            }
            unset($child);
        }
        unset($children, $node['/children']);
    }

    protected function collapseArrays(array &$node, array $exclusions, $element)
    {
        foreach (array_keys($node) as $index) {
            $child = &$node[$index];
            if (is_array($child)) {
                $nextElement = is_int($index) ? $element : "$element/$index";
                $this->collapseArrays($child, $exclusions, $nextElement);
                if (in_array($nextElement, $exclusions)) {
                    continue;
                }
                if (1 === sizeof($child)) {
                    // @todo Use array_key_first() since PHP >= 7.3.0.
                    reset($child);
                    if (0 === key($child)) {
                        $child = $child[0];
                    }
                }
            }
        }
    }
}
