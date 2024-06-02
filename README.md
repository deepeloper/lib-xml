# XML library allowing to parse XML as array converting node values/attributes types using XSD.
[![Packagist version](https://img.shields.io/packagist/v/deepeloper/lib-xml)](https://packagist.org/packages/deepeloper/lib-xml)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/deepeloper/lib-xml.svg)](http://php.net/)
[![GitHub license](https://img.shields.io/github/license/deepeloper/lib-xml.svg)](https://github.com/deepeloper/lib-xml/blob/main/LICENSE)
[![GitHub issues](https://img.shields.io/github/issues-raw/deepeloper/lib-xml.svg)](https://github.com/deepeloper/lib-xml/issues)
[![Packagist](https://img.shields.io/packagist/dt/deepeloper/lib-xml.svg)](https://packagist.org/packages/deepeloper/lib-xml)
![](https://github.com/deepeloper/lib-xml/actions/workflows/ci-coverage.yml/badge.svg?event=push)
![](https://github.com/deepeloper/lib-xml/actions/workflows/ci.yml/badge.svg?event=push)

[![Donation](https://img.shields.io/badge/Donation-Visa,%20MasterCard,%20Maestro,%20UnionPay,%20YooMoney,%20МИР-red)](https://yoomoney.ru/to/41001351141494)

## Compatibility
[![PHP 5.4](https://img.shields.io/badge/PHP->=5.4-%237A86B8)]()

## Installation
`composer require deepeloper/lib-xml`

## Usage

```php
use deepeloper\Lib\XML\Converter;

require_once "/path/to/vendor/autoload.php";

$converter = new Converter();

// @see https://www.php.net/manual/en/function.xml-parse-into-struct.php#66487
// Little bit modified.
$xml = $converter->xmlToArray(
    file_get_contents("/path/to/xml")
);

// lib-xml<3.0.0, PHP<8.1:
$xml = $converter->parse(
    file_get_contents("/path/to/xml"),
    file_get_contents("/path/to/xsd"),
    [
        // Optional, used to move attributes from '/attributes' key to the element. 
        Converter::COLLAPSE_ATTRIBUTES => true,
        // Optional, used to move children from '/children' key to the element as arrays named as child name. 
        Converter::COLLAPSE_CHILDREN => true,
        // Optional, used to convert arrays from previous option as 'name' => "value". 
        Converter::COLLAPSE_ARRAYS => [
            // Optional, used to exclude collapsing for list of the elements. 
            'exclusions' => [
                "node/subnode/...",
                // ...,
            ],
        ],
    ]
);

// lib-xml>=3.0.0, PHP>=8.1:
$xml = $converter->parse(
    file_get_contents("/path/to/xml"),
    [
        file_get_contents("/path/to/xsd1"),
        file_get_contents("/path/to/xsd2"),
        // ...    
    ],
    [
        Converter::COLLAPSE_ATTRIBUTES => true,
        Converter::COLLAPSE_CHILDREN => true,
        Converter::COLLAPSE_ARRAYS => [
            'exclusions' => [
                "node/subnode/...",
                // ...,
            ],
        ],
    ]
);
```

