<?php

/**
 * XML library unit tests.
 *
 * @author [deepeloper](https://github.com/deepeloper)
 * @license [MIT](https://opensource.org/licenses/mit-license.php)
 */

declare(strict_types=1);

namespace deepeloper\Lib\XML;

use deepeloper\Lib\XML\Exception\XMLException;
use PHPUnit\Framework\TestCase;

/**
 * Tools class unit tests.
 */
class ConverterTest extends TestCase
{
    /**
     * Tests empty XML.
     *
     * @cover deepeloper\Lib\XML::xmlToArray()
     * @cover deepeloper\Lib\XML\Exception\XMLException
     */
    public function testEmptyXML(): void
    {
        $this->expectException(XMLException::class);
        $this->expectExceptionMessage("Invalid document end [5]");

        $converter = new Converter();
        $converter->xmlToArray("");
    }

    /**
     * Tests invalid XML.
     *
     * @cover deepeloper\Lib\XML::xmlToArray()
     * @cover deepeloper\Lib\XML\Exception\XMLException
     */
    public function testInvalidXML(): void
    {
        $this->expectException(XMLException::class);
        $this->expectExceptionMessage("Invalid document end [5]");

        $converter = new Converter();
        $converter->xmlToArray("Invalid XML");
    }

    /**
     * Tests valid XML.
     *
     * @return void
     * @cover deepeloper\Lib\XML::xmlToArray()
     */
    public function testValidXML(): void
    {
        $converter = new Converter();
        $xml = file_get_contents(__DIR__ . "/data/phpunit.xml");

        $expected = require_once __DIR__ . "/data/expected.testValidXML.php";
        self::assertEquals($expected, $converter->xmlToArray($xml));
    }

    /**
     * Tests invalid XSD.
     *
     * @cover deepeloper\Lib\XML::parse()
     * @cover deepeloper\Lib\XML\Exception\XMLException
     */
    public function testInvalidXSD(): void
    {
        $this->expectException(XMLException::class);
        $this->expectExceptionMessage("Cannot parse XSD");

        $converter = new Converter();
        $xml = file_get_contents(__DIR__ . "/data/phpunit.xml");
        $converter->parse($xml, ["Invalid XSD"]);
    }

    /**
     * Tests parsing.
     *
     * @cover deepeloper\Lib\XML::parse()
     */
    public function testParse(): void
    {
        $converter = new Converter();
        $xml = file_get_contents(__DIR__ . "/data/debeetle.xml");
        $xsd = file_get_contents(__DIR__ . "/data/debeetle.xsd");
        $expected = require_once __DIR__ . "/data/expected.testParse.php";
        $actual = $converter->parse(
            $xml,
            [$xsd],
            [
                Converter::COLLAPSE_ATTRIBUTES => true,
                Converter::COLLAPSE_CHILDREN => true,
                Converter::COLLAPSE_ARRAYS => [
                    'exclusions' => [
                        "debeetle/config",
                        "debeetle/config/limit",
                    ],
                ],
            ]
        );

        self::assertEquals($expected, $actual);
    }
}
