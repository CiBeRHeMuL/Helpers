<?php

namespace AndrewGos\Helpers\Tests;

use AndrewGos\Helpers\HString;
use AndrewGos\Helpers\Tests\DataProvider\HString\AsBytesDataProvider;
use AndrewGos\Helpers\Tests\DataProvider\HString\KeyboardLayoutDataProvider;
use AndrewGos\Helpers\Tests\DataProvider\HString\RandomNumericStringDataProvider;
use AndrewGos\Helpers\Tests\DataProvider\HString\RandomStringDataProvider;
use AndrewGos\Helpers\Tests\DataProvider\HString\RusToEngDataProvider;
use AndrewGos\Helpers\Tests\DataProvider\HString\StringifyDataProvider;
use AndrewGos\Helpers\Tests\DataProvider\HString\TruncateDataProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;
use Random\Engine;

class HStringTest extends TestCase
{
    #[DataProviderExternal(RandomStringDataProvider::class, 'dataProvider')]
    public function testRandomString(
        int $length,
        bool $includeDigits,
        ?Engine $engine,
        string $expectedRegex,
    ): void {
        $result = HString::randomString($length, $includeDigits, $engine);

        $this->assertMatchesRegularExpression($expectedRegex, $result);
    }

    #[DataProviderExternal(RandomNumericStringDataProvider::class, 'dataProvider')]
    public function testRandomNumericString(
        int $length,
        ?Engine $engine,
        string $expectedRegex,
    ): void {
        $result = HString::randomNumericString($length, $engine);

        $this->assertMatchesRegularExpression($expectedRegex, $result);
    }

    #[DataProviderExternal(AsBytesDataProvider::class, 'dataProvider')]
    public function testAsBytes(
        float $input,
        string $locale,
        bool $useIntl,
        string $expected,
    ): void {
        $result = HString::asBytes(
            $input,
            $locale,
            $useIntl,
        );

        $this->assertSame($expected, $result);
    }

    #[DataProviderExternal(TruncateDataProvider::class, 'dataProvider')]
    public function testTruncate(
        string $inputString,
        int $maxLength,
        string $ellipsis,
        string $encoding,
        string $expected,
    ): void {
        $result = HString::truncate(
            $inputString,
            $maxLength,
            $ellipsis,
            $encoding,
        );

        $this->assertSame($expected, $result);
    }

    #[DataProviderExternal(RusToEngDataProvider::class, 'dataProvider')]
    public function testRusToEng(string $input, string $expected): void
    {
        $this->assertSame($expected, HString::rusToEng($input));
    }

    #[DataProviderExternal(KeyboardLayoutDataProvider::class, 'dataProvider')]
    public function testChangeEngKeyboardLayoutToRus(string $eng, string $rus): void
    {
        $this->assertSame($rus, HString::changeEngKeyboardLayoutToRus($eng));
    }

    #[DataProviderExternal(KeyboardLayoutDataProvider::class, 'dataProvider')]
    public function testChangeRusKeyboardLayoutToEng(string $eng, string $rus): void
    {
        $this->assertSame($eng, HString::changeRusKeyboardLayoutToEng($rus));
    }

    #[DataProviderExternal(StringifyDataProvider::class, 'dataProvider')]
    public function testStringifyValue(mixed $value, string $expected, bool $isRegex = false): void
    {
        $result = HString::stringifyValue($value);
        if ($isRegex) {
            $this->assertMatchesRegularExpression($expected, $result);
        } else {
            $this->assertSame($expected, $result);
        }
    }
}
