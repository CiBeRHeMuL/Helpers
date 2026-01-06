<?php

namespace AndrewGos\Helpers\Tests;

use AndrewGos\Helpers\Enum\FilterModeEnum;
use AndrewGos\Helpers\HArray;
use AndrewGos\Helpers\Tests\DataProvider\HArray\FilterRecursiveDataProvider;
use AndrewGos\Helpers\Tests\DataProvider\HArray\GroupDataProvider;
use AndrewGos\Helpers\Tests\DataProvider\HArray\GroupExtendedDataProvider;
use AndrewGos\Helpers\Tests\DataProvider\HArray\GroupIndexingDataProvider;
use AndrewGos\Helpers\Tests\DataProvider\HArray\IndexDataProvider;
use AndrewGos\Helpers\Tests\DataProvider\HArray\IndexExtendedDataProvider;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;

#[CoversClass(HArray::class)]
class HArrayTest extends TestCase
{
    #[DataProviderExternal(IndexDataProvider::class, 'dataProvider')]
    public function testIndex(iterable $input, Closure|int|string $key, array $expected): void
    {
        $result = HArray::index(
            $input,
            $key,
        );

        $this->assertEquals($expected, $result);
    }

    #[DataProviderExternal(IndexExtendedDataProvider::class, 'dataProvider')]
    public function testIndexExtended(
        iterable $input,
        Closure|int|string $key,
        ?Closure $projection,
        Closure|int|string|null $defaultIndex,
        array $expected,
    ): void {
        $result = HArray::indexExtended(
            $input,
            $key,
            $projection,
            $defaultIndex,
        );

        $this->assertEquals($expected, $result);
    }

    #[DataProviderExternal(GroupDataProvider::class, 'dataProvider')]
    public function testGroup(
        iterable $input,
        Closure|int|string|array $key,
        bool $preserveKeys,
        array $expected,
    ): void {
        $result = HArray::group(
            $input,
            $key,
            $preserveKeys,
        );

        $this->assertEquals($expected, $result);
    }

    #[DataProviderExternal(GroupIndexingDataProvider::class, 'dataProvider')]
    public function testGroupIndexing(
        iterable $input,
        string|int|Closure|array $key,
        string|int|Closure $index,
        int|string|Closure|null $defaultIndex,
        array $expected,
    ): void {
        $result = HArray::groupIndexing(
            $input,
            $key,
            $index,
            $defaultIndex,
        );

        $this->assertEquals($expected, $result);
    }

    #[DataProviderExternal(GroupExtendedDataProvider::class, 'dataProvider')]
    public function testGroupExtended(
        iterable $input,
        int|string|Closure|array $key,
        int|string|Closure|null $index,
        ?Closure $projection,
        bool $preserveKeys,
        int|string|Closure|null $defaultIndex,
        array $expected,
    ): void {
        $result = HArray::groupExtended(
            $input,
            $key,
            $index,
            $projection,
            $preserveKeys,
            $defaultIndex,
        );

        $this->assertEquals($expected, $result);
    }

    #[DataProviderExternal(FilterRecursiveDataProvider::class, 'dataProvider')]
    public function testFilterRecursive(
        array $input,
        ?Closure $callable,
        FilterModeEnum $mode,
        bool $preserveKeys,
        array $expected,
    ): void {
        $result = HArray::filterRecursive(
            $input,
            $callable,
            $mode,
            $preserveKeys,
        );

        $this->assertEquals($expected, $result);
    }
}
