<?php

namespace AndrewGos\Helpers;

use AndrewGos\Helpers\Enum\FilterModeEnum;
use Closure;

class HArray
{
    /**
     * @see self::indexExtended()
     *
     * @template T
     * @template TKey of int|string
     * @template TResKey of int|string
     * @template TKeyFunc of Closure(T, TKey=): TResKey
     *
     * @param iterable<T> $array
     * @param TKey|TKeyFunc $key
     *
     * @return array<TResKey, T>
     */
    public static function index(iterable $array, string|int|Closure $key): array
    {
        return self::indexExtended(
            array: $array,
            key: $key,
        );
    }

    /**
     * @see self::groupExtended()
     *
     * @template T
     * @template TKey of int|string
     * @template TResKey of int|string
     * @template TKeyFunc of Closure(T, TKey=): TResKey
     *
     * @param iterable<T>|array<TKey, T>|T[] $array
     * @param TKey|TKeyFunc|(TKey|TKeyFunc)[] $key
     * @param bool $preserveKeys
     *
     * @return array
     */
    public static function group(
        iterable $array,
        string|int|Closure|array $key,
        bool $preserveKeys = false,
    ): array {
        return self::groupExtended(
            array: $array,
            key: $key,
            preserveKeys: $preserveKeys,
        );
    }

    /**
     * @see self::groupExtended()
     *
     * @template T
     * @template TKey of int|string
     * @template TResKey of int|string
     * @template TProj
     * @template TKeyFunc of Closure(T, TKey=): TResKey
     * @template TProjFunc of Closure(T, TKey=): TProj
     *
     * @param iterable<T>|array<TKey, T>|T[] $array
     * @param TKey|TKeyFunc|(TKey|TKeyFunc)[] $key
     * @param TKey|TKeyFunc $index
     * @param TResKey|TKeyFunc|null $defaultIndex
     *
     * @return array
     */
    public static function groupIndexing(
        iterable $array,
        string|int|Closure|array $key,
        string|int|Closure $index,
        string|int|Closure|null $defaultIndex = null,
    ): array {
        return self::groupExtended(
            array: $array,
            key: $key,
            index: $index,
            defaultIndex: $defaultIndex,
        );
    }

    /**
     * Groups an array by key(s),
     * if necessary, indexes the elements by index \$index and,
     * if necessary, it projects elements using the \$projection function.
     *
     * If it is necessary to reindex the keys of the elements, then \$preserveKeys MUST be set to false.
     * If \$preserveKeys is true, then \$index is forcibly set to null to avoid unnecessary calculations.
     *
     * If some elements may not contain the \$index key value, then you can pass the default value \$defaultIndex
     *
     * Usage Examples:
     * 1. Group:
     * <code>
     * $array = ['one' => 1, 'two' => 2, 'three' => 3];
     * $array = HArray::groupExtended(
     *     $array,
     *     fn($el) => $el % 2 === 0 ? 'even' : 'odd',
     * );
     * // $array = [
     * //     'odd' => [
     * //         1,
     * //         3,
     * //     ],
     * //     'even' => [
     * //         2,
     * //     ],
     * // ];
     * </code>
     *
     * 2. Group and index items:
     * <code>
     * $array = ['one' => 1, 'two' => 2, 'three' => 3];
     * $array = HArray::groupExtended(
     *     $array,
     *     fn($el) => $el % 2 === 0 ? 'even' : 'odd',
     *     fn($el) => "value_$el",
     * );
     * // $array = [
     * //     'odd' => [
     * //         'value_1' => 1,
     * //         'value_3' => 3,
     * //     ],
     * //     'even' => [
     * //         'value_2' => 2,
     * //     ],
     * // ];
     * </code>
     *
     * 3. Group and index elements with projection:
     * <code>
     * $array = ['one' => 1, 'two' => 2, 'three' => 3];
     * $array = HArray::groupExtended(
     *     $array,
     *     fn($el) => $el % 2 === 0 ? 'even' : 'odd',
     *     fn($el) => "value_$el",
     *     fn($el) => $el * 2,
     * );
     * // $array = [
     * //     'odd' => [
     * //         'value_1' => 2,
     * //         'value_3' => 6,
     * //     ],
     * //     'even' => [
     * //         'value_2' => 4,
     * //     ],
     * // ];
     * </code>
     *
     * 4. Group and preserve keys:
     * <code>
     * $array = ['one' => 1, 'two' => 2, 'three' => 3];
     * $array = HArray::groupExtended(
     *     $array,
     *     fn($el) => $el % 2 === 0 ? 'even' : 'odd',
     *     preserveKeys: true,
     * );
     * // $array = [
     * //     'odd' => [
     * //         'one' => 1,
     * //         'three' => 3,
     * //     ],
     * //     'even' => [
     * //         'two' => 2,
     * //     ],
     * // ];
     * </code>
     *
     * 5. Group by passing the key to the grouping function:
     * <code>
     * $array = ['one' => 1, 'two' => 2, 'three' => 3];
     * $array = HArray::groupExtended(
     *     $array,
     *     fn($el, $k) => $k,
     * );
     * // $array = [
     * //     'one' => [
     * //         'one' => 1,
     * //     ],
     * //     'two' => [
     * //         'two' => 2,
     * //     ],
     * //     'three' => [
     * //         'three' => 3,
     * //     ],
     * // ];
     * </code>
     *
     * 6. Group using the key of a nested array:
     * <code>
     * $array = [
     *     'one' => ['id' => 1, 'value' => 1],
     *     'two' => ['id' => 2, 'value' => 2],
     *     'three' => ['id' => 3, 'value' => 3],
     * ];
     * $array = HArray::groupExtended(
     *     $array,
     *     'value',
     * );
     * // $array = [
     * //     '1' => [['id' => 1, 'value' => 1]],
     * //     '2' => [['id' => 2, 'value' => 2]],
     * //     '3' => [['id' => 3, 'value' => 3]],
     * // ];
     * </code>
     *
     * 7. Group by the key of a nested array using the default index:
     * <code>
     * $array = [
     *     'one' => ['id' => 1, 'value' => 4],
     *     'two' => ['id' => 2, 'value' => 5],
     *     'three' => ['id' => 3],
     * ];
     * $array = HArray::groupExtended(
     *     $array,
     *     'id',
     *     index: 'value',
     *     defaultIndex: 3,
     * );
     * // $array = [
     * //     '1' => [
     * //         '4' => ['id' => 1, 'value' => 4],
     * //     ],
     * //     '2' => [
     * //         '5' => ['id' => 2, 'value' => 5],
     * //     ],
     * //     '3' => [
     * //         '3' => ['id' => 3],
     * //     ],
     * // ];
     *
     * 8. Group by the key of a nested array using the default index as function:
     * <code>
     * $array = [
     *     'one' => ['id' => 1, 'value' => 4],
     *     'two' => ['id' => 2, 'value' => 5],
     *     'three' => ['id' => 3],
     * ];
     * $array = HArray::groupExtended(
     *     $array,
     *     'id',
     *     index: 'value',
     *     defaultIndex: fn($el, $key) => $el['id'] * 2,
     * );
     * // $array = [
     * //     '1' => [
     * //         '4' => ['id' => 1, 'value' => 4],
     * //     ],
     * //     '2' => [
     * //         '5' => ['id' => 2, 'value' => 5],
     * //     ],
     * //     '3' => [
     * //         '6' => ['id' => 3],
     * //     ],
     * // ];
     * </code>
     *
     * @template T
     * @template TKey of int|string
     * @template TResKey of int|string
     * @template TProj
     * @template TKeyFunc of Closure(T, TKey=): TResKey
     * @template TProjFunc of Closure(T, TKey=): TProj
     *
     * @param iterable<T>|array<TKey, T>|T[] $array
     * @param TKey|TKeyFunc|(TKey|TKeyFunc)[] $key
     * @param TKey|TKeyFunc|null $index
     * @param TProjFunc|null $projection
     * @param bool $preserveKeys
     * @param TResKey|TKeyFunc|null $defaultIndex
     *
     * @return array
     */
    public static function groupExtended(
        iterable $array,
        int|string|Closure|array $key,
        int|string|Closure|null $index = null,
        ?Closure $projection = null,
        bool $preserveKeys = false,
        int|string|Closure|null $defaultIndex = null,
    ): array {
        $keyToCallable = fn($k) => $k instanceof Closure ? $k : fn($el) => $el[$k] ?? null;

        $key = (array) $key;

        if ($preserveKeys) {
            $index = null;
            $defaultIndex = null;
        }

        if ($index !== null) {
            $defaultIndex = $defaultIndex instanceof Closure
                ? $defaultIndex
                : fn($el) => $defaultIndex;

            $index = $index instanceof Closure
                ? $index
                : fn($el, $k) => array_key_exists($index, $el) ? $el[$index] : $defaultIndex($el, $k);
        }

        $projection ??= fn($el) => $el;

        $result = [];
        foreach ($array as $i => $el) {
            $currentResultEl = &$result;
            foreach ($key as $k) {
                $k = $keyToCallable($k)($el, $i);
                $currentResultEl[$k] ??= [];
                $currentResultEl = &$currentResultEl[$k];
            }
            if ($preserveKeys) {
                $currentResultEl[$i] = $projection($el, $i);
            } elseif ($index !== null) {
                $currentResultEl[$index($el, $i)] = $projection($el, $i);
            } else {
                $currentResultEl[] = $projection($el, $i);
            }
        }
        return $result;
    }

    /**
     * @template T
     * @template TKey of int|string
     * @template TResKey of int|string
     * @template TProj
     * @template TKeyFunc of Closure(T, TKey=): TResKey
     * @template TProjFunc of Closure(T, TKey=): TProj
     *
     * @param iterable<T> $array
     * @param TKey|TKeyFunc $key
     * @param TProjFunc|null $projection
     * @param TResKey|TKeyFunc|null $defaultIndex
     *
     * @return ($projection is null ? array<TResKey, T> : array<TResKey, TProj>)
     */
    public static function indexExtended(
        iterable $array,
        string|int|Closure $key,
        ?Closure $projection = null,
        int|string|Closure|null $defaultIndex = null,
    ): array {
        $defaultIndex = $defaultIndex instanceof Closure
            ? $defaultIndex
            : fn($el) => $defaultIndex;

        $key = $key instanceof Closure
            ? $key
            : fn($el, $k) => array_key_exists($key, $el) ? $el[$key] : $defaultIndex($el, $k);

        $projection ??= fn($el) => $el;

        $result = [];
        foreach ($array as $i => $el) {
            $result[$key($el, $i)] = $projection($el, $i);
        }
        return $result;
    }

    /**
     * @param array $array
     * @param Closure|null $callable
     * @param FilterModeEnum $mode
     * @param bool $preserveKeys
     *
     * @return array
     */
    public static function filterRecursive(
        array $array,
        ?Closure $callable = null,
        FilterModeEnum $mode = FilterModeEnum::UseValue,
        bool $preserveKeys = false,
    ): array {
        if ($callable === null) {
            $callable = fn($e) => $e !== null;
            $mode = FilterModeEnum::UseValue;
        }

        $result = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $filteredValue = self::filterRecursive($value, $callable, $mode, $preserveKeys);
                if (!empty($filteredValue)) {
                    if ($preserveKeys) {
                        $result[$key] = $filteredValue;
                    } else {
                        $result[] = $filteredValue;
                    }
                }
            } else {
                $accepted = match ($mode) {
                    FilterModeEnum::UseValue => $callable($value),
                    FilterModeEnum::UseKey => $callable($key),
                    FilterModeEnum::UseKeyValue => $callable($key, $value),
                };

                if ($accepted) {
                    if ($preserveKeys) {
                        $result[$key] = $value;
                    } else {
                        $result[] = $value;
                    }
                }
            }
        }
        return $result;
    }
}
