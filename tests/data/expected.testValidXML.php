<?php

/**
 * XML library unit tests.
 *
 * @author [deepeloper](https://github.com/deepeloper)
 * @license [MIT](https://opensource.org/licenses/mit-license.php)
 */

declare(strict_types=1);

return [
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
