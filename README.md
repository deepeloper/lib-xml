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
Run `composer require deepeloper/lib-xml`.

## Usage

```php
use deepeloper\Lib\XML\Converter;

require_once "/path/to/vendor/autoload.php";

$xml = $converter->parse(
    file_get_contents("/path/to/xml"),
    file_get_contents("/path/to/xsd"),
    [
        
        Converter::COLLAPSE_ATTRIBUTES => true,
        Converter::COLLAPSE_CHILDREN => true,
        Converter::COLLAPSE_ARRAYS => [
            'exclusions' => [
                "node1/node2/...",
                // ...,
            ],
        ],
    ]
);
```
