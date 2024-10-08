# Helpers library

**Version 1.0.0**

## Description

This library provides functionality of several helpers.
Classes in this library can process arrays

## Contacts

If you encounter a bug or have an idea, please write to [Gostev71@outlook.com](Gostev71@outlook.com) and type `Helpers Bug` or `Helpers Idea` in the email header.

## Installation

To install the library, use Composer:

```sh
composer require andrew-gos/helpers
```

## Simple example

To group array type:
```php
use AndrewGos\Helpers\Helper\HArray;

$array = [['id' => 1, 'value' => 'asdf'], ['id' => 1, 'value' => 'asdf1'], ['id' => 2, 'value' => 'asdf']];
$grouped = HArray::group($array, 'id');
// $grouped = [1 => [['id' => 1, 'value' => 'asdf'], ['id' => 1, 'value' => 'asdf1']], 2 => [['id' => 2, 'value' => 'asdf']]]
```
