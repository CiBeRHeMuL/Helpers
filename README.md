# Andrew-Gos/Helpers

[![CI](https://github.com/CiBeRHeMuL/Helpers/actions/workflows/ci.yaml/badge.svg)](https://github.com/CiBeRHeMuL/Helpers)
[![Latest Stable Version](https://poser.pugx.org/andrew-gos/helpers/version.svg)](https://packagist.org/packages/andrew-gos/helpers)
[![Latest Unstable Version](https://poser.pugx.org/andrew-gos/helpers/v/unstable.svg)](https://packagist.org/packages/andrew-gos/helpers)
[![PHP Version Require](https://poser.pugx.org/andrew-gos/helpers/require/php)](https://packagist.org/packages/andrew-gos/helpers)
[![License](https://poser.pugx.org/andrew-gos/helpers/license.svg)](https://packagist.org/packages/andrew-gos/helpers)
[![Downloads](https://poser.pugx.org/andrew-gos/helpers/d/total.svg)](https://packagist.org/packages/andrew-gos/helpers)
[![codecov](https://codecov.io/github/CiBeRHeMuL/Helpers/graph/badge.svg)](https://codecov.io/github/CiBeRHeMuL/Helpers)

A collection of high-performance, strictly typed helper classes for arrays and strings in modern PHP applications.

This library provides powerful tools for complex data transformations, including multi-level grouping, recursive filtering, and advanced string manipulation.

## 🚀 Key Features
* **Strict Typing & Closures:** Uses `Closure` for callbacks to ensure type safety and avoid ambiguity.
* **Advanced Array Grouping:** Group and index data on multiple levels with projection support.
* **Recursive Filtering:** Cleanly filter nested arrays while preserving or resetting keys.
* **Human-Readable Data:** Convert bytes to strings and complex values to readable debug formats.
* **Multilingual Support:** Russian-to-English transliteration and keyboard layout correction.
* **Modern PHP:** Specifically built for PHP 8.4+ taking advantage of the latest language features.

## 🛠️ Installation
The project requires PHP 8.4 or higher.

Install the library via [Composer](https://getcomposer.org/):

```bash
composer require andrew-gos/helpers
```

## 🏁 Quick Start

### Array Helpers (`HArray`)

#### Example 1: Multi-level Grouping and Indexing
```php
use AndrewGos\Helpers\HArray;

$data = [
    ['city' => 'New York', 'role' => 'admin', 'name' => 'Alice'],
    ['city' => 'New York', 'role' => 'user', 'name' => 'Bob'],
    ['city' => 'London', 'role' => 'admin', 'name' => 'Charlie'],
];

// Group by city, then by role, and index elements by name
$result = HArray::groupExtended(
    array: $data,
    key: ['city', 'role'],
    index: 'name'
);

/* Output:
[
    'New York' => [
        'admin' => ['Alice' => [...]],
        'user'  => ['Bob' => [...]],
    ],
    'London' => [
        'admin' => ['Charlie' => [...]],
    ]
]
*/
```

#### Example 2: Recursive Filtering
```php
use AndrewGos\Helpers\HArray;

$input = [1, [2, null, [3]], null];

// Recursively remove null values and "prune" empty branches
$filtered = HArray::filterRecursive($input, fn($v) => $v !== null);
// Output: [1, [2, [3]]]
```

### String Helpers (`HString`)

#### Example 3: Transliteration and Layout Correction
```php
use AndrewGos\Helpers\HString;

echo HString::rusToEng('Привет мир'); // Output: Privet mir
echo HString::changeEngKeyboardLayoutToRus('ghbdtn'); // Output: привет
```

#### Example 4: Value Stringification (for logging/debugging)
```php
use AndrewGos\Helpers\HString;

$data = ['id' => 1, 'active' => true, 'tags' => ['php', '8.4']];
echo HString::stringifyValue($data); 
// Output: [id => 1, active => true, tags => [0 => "php", 1 => "8.4"]]
```

## 🧩 Extension Suggestions
* **ext-intl**: Highly recommended for `HString::asBytes()`. It enables the ICU MessageFormatter for localized digital units (e.g., "1.25 MB" vs "1,25 МБ").

## 🧪 Testing
To run the test suite, ensure development dependencies are installed:

```bash
composer install
```
Then run PHPUnit:
```bash
vendor/bin/phpunit
```

## 🤝 Contributing
Contributions are welcome! Please feel free to submit a pull request or open an issue on [GitHub](https://github.com/CiBeRHeMuL/Helpers).

## 📜 License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
