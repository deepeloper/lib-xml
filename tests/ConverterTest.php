<?php

/**
 * XML library unit tests.
 *
 * @author [deepeloper](https://github.com/deepeloper)
 * @license [MIT](https://opensource.org/licenses/mit-license.php)
 */

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
     * @return void
     * @cover deepeloper\Lib\XML::xmlToArray()
     * @cover deepeloper\Lib\XML\Exception\XMLException
     */
    public function testEmptyXML()
    {
        $this->expectException(XMLException::class);
        $this->expectExceptionMessage("Invalid document end [5]");

        $converter = new Converter();
        $converter->xmlToArray("");
    }

    /**
     * Tests invalid XML.
     *
     * @return void
     * @cover deepeloper\Lib\XML::xmlToArray()
     * @cover deepeloper\Lib\XML\Exception\XMLException
     */
    public function testInvalidXML()
    {
        $this->expectException(XMLException::class);
        $this->expectExceptionMessage("Not well-formed (invalid token) [4]");

        $converter = new Converter();
        $converter->xmlToArray("Invalid XML");
    }

    /**
     * Tests valid XML.
     *
     * @return void
     * @cover deepeloper\Lib\XML::xmlToArray()
     */
    public function testValidXML()
    {
        $converter = new Converter();
        $xml = file_get_contents("./tests/data/phpunit.xml");
        $expected = [
            '/name' => 'phpunit',
            '/attributes' => [
                'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema',
                'xsi:noNamespaceSchemaLocation' => 'phpunit.xsd',
                'bootstrap' => 'tests/bootstrap.php',
                'cacheDirectory' => '.phpunit.cache',
                'beStrictAboutOutputDuringTests' => 'true',
                'failOnRisky' => 'true',
                'failOnWarning' => 'true',
                'colors' => 'true',
            ],
            '/children' => [
                [
                    '/name' => 'testsuites',
                    '/children' => [
                        [
                            '/name' => 'testsuite',
                            '/attributes' => [
                                'name' => 'unit',
                            ],
                            '/children' => [
                                [
                                    '/name' => 'directory',
                                    '/value' => 'tests/unit',
                                ],
                            ],
                        ],
                        [
                            '/name' => 'testsuite',
                            '/attributes' =>
                                [
                                    'name' => 'end-to-end',
                                ],
                            '/children' => [
                                [
                                    '/name' => 'directory',
                                    '/attributes' =>
                                        [
                                            'suffix' => '.phpt',
                                        ],
                                    '/value' => 'tests/end-to-end/cli',
                                ],
                                [
                                    '/name' => 'directory',
                                    '/attributes' =>
                                        [
                                            'suffix' => '.phpt',
                                        ],
                                    '/value' => 'tests/end-to-end/code-coverage',
                                ],
                                [
                                    '/name' => 'directory',
                                    '/attributes' =>
                                        [
                                            'suffix' => '.phpt',
                                        ],
                                    '/value' => 'tests/end-to-end/event',
                                ],
                                [
                                    '/name' => 'directory',
                                    '/attributes' =>
                                        [
                                            'suffix' => '.phpt',
                                        ],
                                    '/value' => 'tests/end-to-end/execution-order',
                                ],
                                [
                                    '/name' => 'directory',
                                    '/attributes' =>
                                        [
                                            'suffix' => '.phpt',
                                        ],
                                    '/value' => 'tests/end-to-end/extension',
                                ],
                                [
                                    '/name' => 'directory',
                                    '/attributes' =>
                                        [
                                            'suffix' => '.phpt',
                                        ],
                                    '/value' => 'tests/end-to-end/generic',
                                ],
                                [
                                    '/name' => 'directory',
                                    '/attributes' =>
                                        [
                                            'suffix' => '.phpt',
                                        ],
                                    '/value' => 'tests/end-to-end/logging',
                                ],
                                [
                                    '/name' => 'directory',
                                    '/attributes' =>
                                        [
                                            'suffix' => '.phpt',
                                        ],
                                    '/value' => 'tests/end-to-end/migration',
                                ],
                                [
                                    '/name' => 'directory',
                                    '/attributes' =>
                                        [
                                            'suffix' => '.phpt',
                                        ],
                                    '/value' => 'tests/end-to-end/mock-objects',
                                ],
                                [
                                    '/name' => 'directory',
                                    '/attributes' =>
                                        [
                                            'suffix' => '.phpt',
                                        ],
                                    '/value' => 'tests/end-to-end/phpt',
                                ],
                                [
                                    '/name' => 'directory',
                                    '/attributes' =>
                                        [
                                            'suffix' => '.phpt',
                                        ],
                                    '/value' => 'tests/end-to-end/regression',
                                ],
                                [
                                    '/name' => 'directory',
                                    '/attributes' =>
                                        [
                                            'suffix' => '.phpt',
                                        ],
                                    '/value' => 'tests/end-to-end/testdox',
                                ],
                                [
                                    '/name' => 'exclude',
                                    '/value' => 'tests/end-to-end/event/_files',
                                ],
                                [
                                    '/name' => 'exclude',
                                    '/value' => 'tests/end-to-end/execution-order/_files',
                                ],
                                [
                                    '/name' => 'exclude',
                                    '/value' => 'tests/end-to-end/logging/_files',
                                ],
                                [
                                    '/name' => 'exclude',
                                    '/value' => 'tests/end-to-end/migration/_files',
                                ],
                                [
                                    '/name' => 'exclude',
                                    '/value' => 'tests/end-to-end/testdox/_files',
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    '/name' => 'source',
                    '/children' => [
                        [
                            '/name' => 'include',
                            '/children' => [
                                [
                                    '/name' => 'directory',
                                    '/value' => 'src',
                                ],
                            ],
                        ],
                        [
                            '/name' => 'exclude',
                            '/children' => [
                                [
                                    '/name' => 'file',
                                    '/value' => 'src/Framework/Assert/Functions.php',
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    '/name' => 'php',
                    '/children' => [
                        [
                            '/name' => 'ini',
                            '/attributes' => [
                                'name' => 'precision',
                                'value' => '14',
                            ],
                        ],
                        [
                            '/name' => 'ini',
                            '/attributes' => [
                                'name' => 'serialize_precision',
                                'value' => '14',
                            ],
                        ],
                        [
                            '/name' => 'const',
                            '/attributes' => [
                                'name' => 'PHPUNIT_TESTSUITE',
                                'value' => 'true',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        self::assertEquals($expected, $converter->xmlToArray($xml));
    }

    /**
     * Tests invalid XSD.
     *
     * @return void
     * @cover deepeloper\Lib\XML::parse()
     * @cover deepeloper\Lib\XML\Exception\XMLException
     */
    public function testInvalidXSD()
    {
        $this->setExpectedException(
            "deepeloper\Lib\XML\Exception\XMLException",
            "Cannot parse XSD"
        );

        $converter = new Converter();
        $xml = file_get_contents("./tests/data/phpunit.xml");
        $converter->parse($xml, "Invalid XSD");
    }

    /**
     * Tests parsing.
     *
     * @return void
     * @cover deepeloper\Lib\XML::parse()
     */
    public function testParse()
    {
        $converter = new Converter();
        $xml = file_get_contents("./tests/data/debeetle.xml");
        $xsd = file_get_contents("./tests/data/debeetle.xsd");
        $expected = [
            '/name' => 'debeetle',
            'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:noNamespaceSchemaLocation' => 'debeetle.xsd',
            'launch' => true,
            'config' =>
                [
                    0 =>
                        [
                            'name' => 'common',
                            'use' => true,
                            'developerMode' => false,
                            'disableCaching' => false,
                            'shortAlias' => '\\deepeloper\\Debeetle\\d',
                            'cookie' =>
                                [
                                    'name' => 'debeetle',
                                    'path' => '/',
                                    'expires' => 0,
                                ],
                            'path' =>
                                [
                                    'assets' => 'D:/repos/deepeloper/debeetle/assets',
                                    'script' => '/debeetle.php',
                                    'root' => 'D:/repos/deepeloper/debeetle/public',
                                ],
                            'bench' =>
                                [
                                    'serverTime' =>
                                        [
                                            'format' => 'Y-m-d H:i:s O (T)',
                                        ],
                                    'pageTotalTime' =>
                                        [
                                            'format' => '%.03f',
                                            'warning' => 0.6999999999999999555910790149937383830547332763671875,
                                            'critical' => 1,
                                            'exclude' => 'scriptInit,debeetle',
                                        ],
                                    'memoryUsage' =>
                                        [
                                            'format' => '%.02f',
                                            'warning' => 10,
                                            'critical' => 15,
                                            'divider' => 1048576,
                                            'unit' => 'MB',
                                            'exclude' => 'scriptInit,debeetle',
                                        ],
                                    'peakMemoryUsage' =>
                                        [
                                            'format' => '%.02f',
                                            'warning' => 30,
                                            'critical' => 60,
                                            'divider' => 1048576,
                                            'unit' => 'MB',
                                            'exclude' => 'scriptInit,debeetle',
                                        ],
                                    'includedFiles' =>
                                        [
                                            'warning' => 100,
                                            'critical' => 120,
                                            'exclude' => 'debeetle',
                                        ],
                                ],
                            'defaults' =>
                                [
                                    'language' => 'en',
                                    'disabledPanelOpacity' => 0.7,
                                    'maxPanelHeight' => 80,
                                    'skin' => 'Default',
                                    'theme' => 'Default',
                                    'opacity' =>
                                        [
                                            'properties' =>
                                                [
                                                    'type' => 'number',
                                                    'min' => 0.3,
                                                    'max' => 1,
                                                    'step' => 0.05,
                                                    'parse' => 'float',
                                                    'value' => 0.95,
                                                ],
                                            'selector' => '~$d.frame',
                                        ],
                                    'zoom' =>
                                        [
                                            'properties' =>
                                                [
                                                    'type' => 'number',
                                                    'min' => 0.5,
                                                    'max' => 3,
                                                    'step' => 0.05,
                                                    'parse' => 'float',
                                                    'value' => 1,
                                                ],
                                            'selector' =>
                                                [
                                                    0 => 'div.bar',
                                                    1 => '#dPanel',
                                                ],
                                        ],
                                    'options' =>
                                        [
                                            'write' =>
                                                [
                                                    'encoding' => 'windows-1251',
                                                    'htmlEntities' => false,
                                                    'nl2br' => false,
                                                ],
                                        ],
                                ],
                            'history' =>
                                [
                                    'use' => true,
                                    'records' => 20,
                                    'onRedirectionPassBy' => 'session',
                                ],
                            'skin' =>
                                [
                                    0 =>
                                        [
                                            'id' => 'deepeloper~Default',
                                            'class' => 'deepeloper\\Debeetle\\Skin\\Default\\Controller',
                                            'name' =>
                                                [
                                                    'en' => 'Default',
                                                    'ru' => 'Умолчанец',
                                                ],
                                            'assets' =>
                                                [
                                                    'locale' => 'locale.php',
                                                    'template' => 'skin.html',
                                                    'js' => 'addon.js.php',
                                                    'lessJs' => 'skin.less.js.php',
                                                    'less' => 'skin.less',
                                                ],
                                            'theme' =>
                                                [
                                                    0 =>
                                                        [
                                                            'id' => 'deepeloper~Default~Default',
                                                            'class' => 'deepeloper\\Debeetle\\Skin\\Default\\Theme\\Default\\Controller',
                                                            'name' =>
                                                                [
                                                                    'en' => 'Default',
                                                                    'ru' => 'Промолченец',
                                                                ],
                                                            'assets' =>
                                                                [
                                                                    'lessJs' => 'theme.less.js.php',
                                                                    'less' => 'theme.less',
                                                                ],
                                                        ],
                                                    1 =>
                                                        [
                                                            'id' => 'deepeloper~Default~Other',
                                                            'class' => 'deepeloper\\Debeetle\\Skin\\Default\\Theme\\Other\\Controller',
                                                            'name' =>
                                                                [
                                                                    'en' => 'Other',
                                                                    'ru' => 'Лишенец',
                                                                ],
                                                            'assets' =>
                                                                [
                                                                    'lessJs' => 'theme.less.js.php',
                                                                    'less' => 'theme.less',
                                                                ],
                                                        ],
                                                ],
                                        ],
                                    1 =>
                                        [
                                            'id' => 'deepeloper~Custom',
                                            'class' => 'deepeloper\\Debeetle\\Skin\\Custom\\Controller',
                                            'name' =>
                                                [
                                                    'en' => 'Custom',
                                                    'ru' => 'Хитровыкроенец',
                                                ],
                                            'assets' =>
                                                [
                                                    'locale' => 'locale.php',
                                                    'template' => 'skin.html',
                                                    'js' => 'addon.js.php',
                                                    'lessJs' => 'skin.less.js.php',
                                                    'less' => 'skin.less',
                                                ],
                                            'theme' =>
                                                [
                                                    'id' => 'deepeloper~Custom~Default',
                                                    'class' => 'deepeloper\\Debeetle\\Skin\\Custom\\Theme\\Default\\Controller',
                                                    'name' =>
                                                        [
                                                            'en' => 'Default',
                                                            'ru' => 'Молчаливец',
                                                        ],
                                                    'assets' =>
                                                        [
                                                            'lessJs' => 'theme.less.js.php',
                                                            'less' => 'theme.less',
                                                        ],
                                                ],
                                        ],
                                ],
                            'plugin' =>
                                [
                                    0 =>
                                        [
                                            'id' => 'deepeloper~PHPInfo',
                                            'class' => 'deepeloper\\Debeetle\\Plugin\\PHPInfo\\Controller',
                                            'assets' =>
                                                [
                                                    'locale' => 'locale.php',
                                                    'js' => 'addon.js.php',
                                                ],
                                        ],
                                    1 =>
                                        [
                                            'id' => 'deepeloper~TraceAndDump',
                                            'class' => 'deepeloper\\Debeetle\\Plugin\\TraceAndDump\\Controller',
                                            'assets' =>
                                                [
                                                    'locale' => 'locale.php',
                                                    'js' => 'addon.js.php',
                                                    'less' => 'styles.less',
                                                ],
                                            'method' =>
                                                [
                                                    0 =>
                                                        [
                                                            'name' => 'dump',
                                                            'maxStringLength' => '200',
                                                            'maxNesting' => '0',
                                                            'maxCount' => '0',
                                                            'expand' => 'true',
                                                            'expandEntities' => 'true',
                                                        ],
                                                    1 =>
                                                        [
                                                            'name' => 'trace',
                                                            'expand' => 'true',
                                                            'displayArgs' => 'true',
                                                            'expandArgs' => 'true',
                                                        ],
                                                ],
                                        ],
                                ],
                        ],
                    1 =>
                        [
                            'name' => 'ichteaunder.local',
                            'use' => true,
                            'developerMode' => true,
                            'disableCaching' => false,
                            'limit' =>
                                [
                                    0 =>
                                        [
                                            'source' => 'SERVER',
                                            'key' => 'HTTP_HOST',
                                            'value' => 'deepeloper.loc',
                                        ],
                                    1 =>
                                        [
                                            'source' => 'SERVER',
                                            'key' => 'REMOTE_ADDR',
                                            'value' => '127.0.0.1',
                                        ],
                                ],
                        ],
                ],
        ];
        $actual = $converter->parse(
            $xml,
            $xsd,
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
