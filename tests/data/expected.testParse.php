<?php

/**
 * XML library unit tests.
 *
 * @author [deepeloper](https://github.com/deepeloper)
 * @license [MIT](https://opensource.org/licenses/mit-license.php)
 */

declare(strict_types=1);

return [
    '/name' => 'debeetle',
    'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
    'xsi:noNamespaceSchemaLocation' => 'debeetle.xsd',
    'launch' => true,
    'config' => [
        [
            'name' => 'common',
            'use' => true,
            'developerMode' => false,
            'disableCaching' => false,
            'shortAlias' => '\\deepeloper\\Debeetle\\d',
            'cookie' => [
                'name' => 'debeetle',
                'path' => '/',
                'expires' => 0,
            ],
            'path' => [
                'assets' => 'D:/repos/deepeloper/debeetle/assets',
                'script' => '/debeetle.php',
                'root' => 'D:/repos/deepeloper/debeetle/public',
            ],
            'bench' => [
                'serverTime' => [
                    'format' => 'Y-m-d H:i:s O (T)',
                ],
                'pageTotalTime' => [
                    'format' => '%.03f',
                    'warning' => 0.7,
                    'critical' => 1,
                    'exclude' => 'scriptInit,debeetle',
                ],
                'memoryUsage' => [
                    'format' => '%.02f',
                    'warning' => 10,
                    'critical' => 15,
                    'divider' => 1048576,
                    'unit' => 'MB',
                    'exclude' => 'scriptInit,debeetle',
                ],
                'peakMemoryUsage' => [
                    'format' => '%.02f',
                    'warning' => 30,
                    'critical' => 60,
                    'divider' => 1048576,
                    'unit' => 'MB',
                    'exclude' => 'scriptInit,debeetle',
                ],
                'includedFiles' => [
                    'warning' => 100,
                    'critical' => 120,
                    'exclude' => 'debeetle',
                ],
            ],
            'defaults' => [
                'language' => 'en',
                'disabledPanelOpacity' => 0.7,
                'maxPanelHeight' => 80,
                'skin' => 'Default',
                'theme' => 'Default',
                'opacity' => [
                    'properties' => [
                        'type' => 'number',
                        'min' => 0.3,
                        'max' => 1,
                        'step' => 0.05,
                        'parse' => 'float',
                        'value' => 0.95,
                    ],
                    'selector' => '~$d.frame',
                ],
                'zoom' => [
                    'properties' => [
                        'type' => 'number',
                        'min' => 0.5,
                        'max' => 3,
                        'step' => 0.05,
                        'parse' => 'float',
                        'value' => 1,
                    ],
                    'selector' => [
                        0 => 'div.bar',
                        1 => '#dPanel',
                    ],
                ],
                'options' => [
                    'write' => [
                        'encoding' => 'windows-1251',
                        'htmlEntities' => false,
                        'nl2br' => false,
                    ],
                ],
            ],
            'history' => [
                'use' => true,
                'records' => 20,
                'onRedirectionPassBy' => 'session',
            ],
            'skin' => [
                [
                    'id' => 'deepeloper~Default',
                    'class' => 'deepeloper\\Debeetle\\Skin\\Default\\Controller',
                    'name' => [
                        'en' => 'Default',
                        'ru' => 'Умолчанец',
                    ],
                    'assets' => [
                        'locale' => 'locale.php',
                        'template' => 'skin.html',
                        'js' => 'addon.js.php',
                        'lessJs' => 'skin.less.js.php',
                        'less' => 'skin.less',
                    ],
                    'theme' => [
                        [
                            'id' => 'deepeloper~Default~Default',
                            'class' => 'deepeloper\\Debeetle\\Skin\\Default\\Theme\\Default\\Controller',
                            'name' => [
                                'en' => 'Default',
                                'ru' => 'Промолченец',
                            ],
                            'assets' => [
                                'lessJs' => 'theme.less.js.php',
                                'less' => 'theme.less',
                            ],
                        ],
                        [
                            'id' => 'deepeloper~Default~Other',
                            'class' => 'deepeloper\\Debeetle\\Skin\\Default\\Theme\\Other\\Controller',
                            'name' => [
                                'en' => 'Other',
                                'ru' => 'Лишенец',
                            ],
                            'assets' => [
                                'lessJs' => 'theme.less.js.php',
                                'less' => 'theme.less',
                            ],
                        ],
                    ],
                ],
                [
                    'id' => 'deepeloper~Custom',
                    'class' => 'deepeloper\\Debeetle\\Skin\\Custom\\Controller',
                    'name' => [
                        'en' => 'Custom',
                        'ru' => 'Хитровыкроенец',
                    ],
                    'assets' => [
                        'locale' => 'locale.php',
                        'template' => 'skin.html',
                        'js' => 'addon.js.php',
                        'lessJs' => 'skin.less.js.php',
                        'less' => 'skin.less',
                    ],
                    'theme' => [
                        'id' => 'deepeloper~Custom~Default',
                        'class' => 'deepeloper\\Debeetle\\Skin\\Custom\\Theme\\Default\\Controller',
                        'name' => [
                            'en' => 'Default',
                            'ru' => 'Молчаливец',
                        ],
                        'assets' => [
                            'lessJs' => 'theme.less.js.php',
                            'less' => 'theme.less',
                        ],
                    ],
                ],
            ],
            'plugin' =>
                [
                    [
                        'id' => 'deepeloper~PHPInfo',
                        'class' => 'deepeloper\\Debeetle\\Plugin\\PHPInfo\\Controller',
                        'assets' => [
                            'locale' => 'locale.php',
                            'js' => 'addon.js.php',
                        ],
                    ],
                    [
                        'id' => 'deepeloper~TraceAndDump',
                        'class' => 'deepeloper\\Debeetle\\Plugin\\TraceAndDump\\Controller',
                        'assets' => [
                            'locale' => 'locale.php',
                            'js' => 'addon.js.php',
                            'less' => 'styles.less',
                        ],
                        'method' => [
                            [
                                'name' => 'dump',
                                'maxStringLength' => '200',
                                'maxNesting' => '0',
                                'maxCount' => '0',
                                'expand' => 'true',
                                'expandEntities' => 'true',
                            ],
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
        [
            'name' => 'ichteaunder.local',
            'use' => true,
            'developerMode' => true,
            'disableCaching' => false,
            'limit' => [
                [
                    'source' => 'SERVER',
                    'key' => 'HTTP_HOST',
                    'value' => 'deepeloper.loc',
                ],
                [
                    'source' => 'SERVER',
                    'key' => 'REMOTE_ADDR',
                    'value' => '127.0.0.1',
                ],
            ],
        ],
    ],
];
