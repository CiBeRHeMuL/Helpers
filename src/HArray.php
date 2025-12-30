<?php

namespace AndrewGos\Helpers;

use Traversable;

class HArray
{
    /**
     * Index array by key or callable
     * @template T
     * @template Key of string|int
     *
     * @param iterable<T> $array
     * @param Key|(callable(T): Key) $key if callable, then must have signature: callable(array-element-type): string|int
     *
     * @return array<Key, T>
     */
    public static function index(iterable $array, string|int|callable $key): array
    {
        $key = is_callable($key) ? $key : fn($el) => $el[$key] ?? null;

        $result = [];
        foreach ($array as $i => $el) {
            $result[$key($el)] = $el;
        }
        return $result;
    }

    /**
     * Group array elements by key or keys if key is array
     * @template T
     * @template Key of string|int
     *
     * @param iterable<T>|array<Key, T>|T[] $array
     * @param Key|callable|(Key|callable)[] $key
     * @param bool $preserveKeys
     *
     * @return ($key is array ? array : array<Key, T[]>)
     */
    public static function group(iterable $array, string|int|callable|array $key, bool $preserveKeys = true): array
    {
        $keyToCallable = fn($k) => is_callable($k) ? $k : fn($el) => $el[$k] ?? null;

        $key = is_array($key) && is_callable($key) ? [$key] : (array) $key;

        $result = [];
        foreach ($array as $i => $el) {
            $currentResultEl = &$result;
            foreach ($key as $k) {
                $k = $keyToCallable($k)($el);
                $currentResultEl[$k] ??= [];
                $currentResultEl = &$currentResultEl[$k];
            }
            if ($preserveKeys) {
                $currentResultEl[$i] = $el;
            } else {
                $currentResultEl[] = $el;
            }
        }
        return $result;
    }

    /**
     * Group array elements by key or keys if key is array
     * @template T
     * @template Key of string|int
     *
     * @param iterable<T>|array<Key, T>|T[] $array
     * @param Key|callable|(Key|callable)[] $key
     * @param Key|callable $index if callable, then must have signature: callable(element-type): key-type
     *
     * @return ($key is array ? array : array<Key, T[]>|array)
     */
    public static function groupIndexing(iterable $array, string|int|callable|array $key, string|int|callable $index): array
    {
        $keyToCallable = fn($k) => is_callable($k) ? $k : fn($el) => $el[$k] ?? null;

        $key = is_array($key) && is_callable($key) ? [$key] : (array) $key;

        $index = is_callable($index)
            ? $index
            : fn($el) => $el[$index] ?? null;

        $result = [];
        foreach ($array as $i => $el) {
            $currentResultEl = &$result;
            foreach ($key as $k) {
                $k = $keyToCallable($k)($el);
                $currentResultEl[$k] ??= [];
                $currentResultEl = &$currentResultEl[$k];
            }
            $currentResultEl[$index($el)] = $el;
        }
        return $result;
    }

    /**
     * Groups an array by key(s),
     * if necessary, indexes the elements by index \$index and,
     * if necessary, it projects elements using the \$projection function.
     *
     * If it is necessary to reindex the keys of the elements, then \$preserveKeys must be set to false.
     * If \$preserveKeys is false, then \$index is forcibly set to null to avoid unnecessary calculations.
     *
     * If some elements may not contain the \$index key value, then you can pass the default value \$defaultIndex
     *
     * Usage Examples:
     * 1. Grouping by key:
     * <code>
     * $array = ['one' => 1, 'two' => 2, 'three' => 3];
     * $array = HArray::groupExtended(
     *      $array,
     *      fn($el) => $el % 2 === 0 ? 'even' : 'odd',
     * );
     * // $array = ['odd' => ['one' => 1, 'three' => 3], 'even' => ['two' => 2]]
     * </code>
     * 2. Grouping by key and indexing of items:
     * <code>
     * $array = ['one' => 1, 'two' => 2, 'three' => 3];
     * $array = HArray::groupExtended(
     *      $array,
     *      fn($el) => $el % 2 === 0 ? 'even' : 'odd',
     *      fn($el) => "value_$el",
     * );
     * // $array = ['odd' => ['value_1' => 1, 'value_3' => 3], 'even' => ['value_2' => 2]]
     * </code>
     * 3. Grouping by key and indexing elements with projection:
     * <code>
     * $array = ['one' => 1, 'two' => 2, 'three' => 3];
     * $array = HArray::groupExtended(
     *      $array,
     *      fn($el) => $el % 2 === 0 ? 'even' : 'odd',
     *      fn($el) => "value_$el",
     *      fn($el) => $el * 2,
     * );
     * // $array = ['odd' => ['value_1' => 2, 'value_3' => 6], 'even' => ['value_2' => 4]]
     * </code>
     * 4. Grouping by key with resetting the keys of nested arrays:
     * <code>
     * $array = ['one' => 1, 'two' => 2, 'three' => 3];
     * $array = HArray::groupExtended($array, fn($el) => $el % 2 === 0 ? 'even' : 'odd', preserveKeys: false);
     * // $array = ['odd' = [1, 3], 'even' => [2]]
     * </code>
     * 5. Grouping by passing the key to the grouping function:
     * <code>
     * $array = ['one' => 1, 'two' => 2, 'three' => 3];
     * $array = HArray::groupExtended(
     *      $array,
     *      fn($el, $k) => $k,
     * );
     * // $array = ['one' => ['one' => 1], 'two' => ['two' => 2], 'three' => ['three' => 3]]
     * </code>
     * 6. Grouping by the key of a nested array:
     * <code>
     * $array = ['one' => ['id' => 1, 'value' => 1], 'two' => ['id' => 2, 'value' => 2], 'three' => ['id' => 3, 'value' => 3]];
     * $array = HArray::groupExtended(
     *      $array,
     *      'value',
     * );
     * // $array = [
     * //     '1' => ['one' => ['id' => 1, 'value' => 1]],
     * //     '2' => ['two' => ['id' => 2, 'value' => 2]],
     * //     '3' => ['three' => ['id' => 3, 'value' => 3]],
     * // ];
     * </code>
     * 7. Grouping by the key of a nested array using the default index:
     * <code>
     * $array = ['one' => ['id' => 1, 'value' => 4], 'two' => ['id' => 2, 'value' => 5], 'three' => ['id' => 3]];
     * $array = HArray::groupExtended(
     *      $array,
     *      'value',
     *      'id',
     * );
     * // $array = ['4' => ['one' => ['id' => 1, 'value' => 4]], '5' => ['two' => ['id' => 2, 'value' => 5]], '3' => ['three' => ['id' => 3]]]
     * </code>
     *
     * @template T
     * @template TKey of int|string
     * @template TResKey of int|string
     * @template TProj
     * @template TKeyFunc of callable(T, TKey=): TResKey
     *
     * @param iterable<T>|array<TKey, T>|T[] $array
     * @param TKey|TKeyFunc|(TKey|TKeyFunc)[] $key
     * @param TKey|(callable(T, TKey=): (int|string))|null $index
     * @param (callable(T, TKey=): TProj)|null $projection
     * @param bool $preserveKeys
     * @param int|string|null $defaultIndex
     *
     * @return array
     */
    public static function groupExtended(
        iterable $array,
        int|string|callable|array $key,
        int|string|callable|null $index = null,
        ?callable $projection = null,
        bool $preserveKeys = true,
        int|string|null $defaultIndex = null,
    ): array {
        $keyToCallable = fn($k) => is_callable($k) ? $k : fn($el) => $el[$k] ?? null;

        $key = is_array($key) && is_callable($key) ? [$key] : (array) $key;

        if ($preserveKeys) {
            if ($index !== null) {
                $index = is_callable($index)
                    ? $index
                    : fn($el) => $el[$index] ?? $defaultIndex;
            }
        } else {
            $index = null;
        }

        $projection ??= fn($el) => $el;

        $result = [];
        foreach ($array as $i => $el) {
            $currentResultEl = &$result;
            foreach ($key as $k) {
                $k = $keyToCallable($k)($el);
                $currentResultEl[$k] ??= [];
                $currentResultEl = &$currentResultEl[$k];
            }
            if ($preserveKeys) {
                if ($index === null) {
                    $currentResultEl[$i] = $projection($el);
                } else {
                    $currentResultEl[$index($el)] = $projection($el);
                }
            } else {
                $currentResultEl[] = $projection($el);
            }
        }
        return $result;
    }

    /**
     * Indexing with projection
     *
     * @template T
     * @template Key of string|int
     * @template Proj
     *
     * @param iterable<T> $array
     * @param Key|callable(T): Key $key
     * @param callable(T): Proj $projection
     *
     * @return array<Key, Proj>
     */
    public static function indexExtended(
        iterable $array,
        string|int|callable $key,
        callable $projection,
    ): array {
        if ($array instanceof Traversable) {
            $array = iterator_to_array($array);
        }

        $key = is_callable($key)
            ? $key
            : fn($el) => $el[$key] ?? null;

        $result = [];
        foreach ($array as $i => $el) {
            $result[$key($el)] = $projection($el);
        }
        return $result;
    }

    /**
     * @param array $array
     * @param callable|null $callable
     * @param int $mode
     *
     * @return array
     */
    public static function filterRecursive(array $array, ?callable $callable = null, int $mode = 0): array
    {
        $filterFunc = function (array $value) use (&$filterFunc, &$callable, &$mode) {
            $value = array_filter($value, $callable, $mode);
            array_walk(
                $value,
                function (&$val) use (&$filterFunc, &$callable, &$mode) {
                    if (is_array($val)) {
                        $val = $filterFunc($val);
                    }
                },
            );
            return $value;
        };
        return $filterFunc($array);
    }
}
