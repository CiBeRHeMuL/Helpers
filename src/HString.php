<?php

namespace AndrewGos\Helpers;

use Random\Engine;
use Random\Randomizer;

class HString
{
    /**
     * Generate random string from letters and maybe digits
     *
     * @param int $length
     * @param bool $includeDigits
     * @param Engine|null $engine random engine to be used for string generation
     *
     * @return string
     */
    public static function randomString(int $length, bool $includeDigits = true, ?Engine $engine = null): string
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $includeDigits && $characters .= '0123456789';

        $randomizer = new Randomizer($engine);

        return $randomizer->getBytesFromString($characters, $length);
    }

    /**
     * Generate random numeric string
     *
     * @param int $length
     * @param Engine|null $engine random engine to be used for string generation
     *
     * @return string
     */
    public static function randomNumericString(int $length, ?Engine $engine = null): string
    {
        $characters = '0123456789';
        $randomizer = new Randomizer($engine);

        return $randomizer->getBytesFromString($characters, $length);
    }

    /**
     * Convert size in bytes to human-readable string representation
     *
     * @param float $bytes
     * @param string $locale locale to format bytes number. Using only if the `intl` extension is installed
     *
     * @return string
     */
    public static function asBytes(float $bytes, string $locale = 'en_EN', bool $useIntl = true): string
    {
        $steps = [
            'petabyte' => 1 << 50,
            'terabyte' => 1 << 40,
            'gigabyte' => 1 << 30,
            'megabyte' => 1 << 20,
            'kilobyte' => 1 << 10,
            'byte' => 1,
        ];

        $resultStep = 'byte';
        $resultDiv = $steps[$resultStep];
        $absoluteBytes = abs($bytes);
        foreach ($steps as $suffix => $step) {
            if ($absoluteBytes >= $step) {
                $resultStep = $suffix;
                $resultDiv = $step;
                break;
            }
        }

        if (extension_loaded('intl') && $useIntl) {
            return msgfmt_format_message(
                $locale,
                "{0, number, :: .00 measure-unit/digital-$resultStep unit-width-narrow}",
                [$bytes / $resultDiv],
            );
        } else {
            $suffixMap = [
                'petabyte' => 'PB',
                'terabyte' => 'TB',
                'gigabyte' => 'GB',
                'megabyte' => 'MB',
                'kilobyte' => 'kB',
                'byte' => 'B',
            ];

            return sprintf(
                '%.2f %s',
                $bytes / $resultDiv,
                $suffixMap[$resultStep],
            );
        }
    }

    /**
     * Truncates a string to a specified length with optional ellipsis
     *
     * @param string $inputString The input string to be truncated
     * @param int $maxLength The maximum length of the truncated string
     * @param string $ellipsis Ellipsis if the line is truncated
     * @param string $encoding The charset to use, defaults to UTF-8
     *
     * @return string The truncated string
     */
    public static function truncate(
        string $inputString,
        int $maxLength,
        string $ellipsis = '...',
        string $encoding = 'UTF-8',
    ): string {
        if (mb_strlen($inputString, $encoding) <= $maxLength) {
            return $inputString;
        }

        $truncatedString = mb_substr($inputString, 0, $maxLength, $encoding);
        $truncatedString .= $ellipsis;

        return $truncatedString;
    }

    /**
     * @param string $rus
     *
     * @return string
     */
    public static function rusToEng(string $rus): string
    {
        $map = [
            'А' => 'A',
            'Б' => 'B',
            'В' => 'V',
            'Г' => 'G',
            'Д' => 'D',
            'Е' => 'E',
            'Ё' => 'E',
            'Ж' => 'Zh',
            'З' => 'Z',
            'И' => 'I',
            'Й' => 'Y',
            'К' => 'K',
            'Л' => 'L',
            'М' => 'M',
            'Н' => 'N',
            'О' => 'O',
            'П' => 'P',
            'Р' => 'R',
            'С' => 'S',
            'Т' => 'T',
            'У' => 'U',
            'Ф' => 'F',
            'Х' => 'Kh',
            'Ц' => 'Ts',
            'Ч' => 'Ch',
            'Ш' => 'Sh',
            'Щ' => 'Shch',
            'Ъ' => '',
            'Ы' => 'Y',
            'Ь' => '',
            'Э' => 'E',
            'Ю' => 'Yu',
            'Я' => 'Ya',
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'e',
            'ж' => 'zh',
            'з' => 'z',
            'и' => 'i',
            'й' => 'y',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'kh',
            'ц' => 'ts',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'shch',
            'ъ' => '',
            'ы' => 'y',
            'ь' => '',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya',
        ];
        return str_replace(array_keys($map), array_values($map), $rus);
    }

    /**
     * Changes keyboard layout from English to Russian using Mac layouts
     *
     * @param string $str
     *
     * @return string
     */
    public static function changeEngKeyboardLayoutToRus(string $str): string
    {
        // These arrays contain only pairs of symbols that are different in different layouts
        $eng = ['`', 'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', '[', ']', '\\', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', ';', '\'', 'z', 'x', 'c', 'v', 'b', 'n', 'm', ',', '.', '~', '@', '#', '$', '%', '^', '&', '*', 'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P', '{', '}', '|', 'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', ':', '"', 'Z', 'X', 'C', 'V', 'B', 'N', 'M', '<', '>'];
        $rus = [']', 'й', 'ц', 'у', 'к', 'е', 'н', 'г', 'ш', 'щ', 'з', 'х', 'ъ', 'ё', 'ф', 'ы', 'в', 'а', 'п', 'р', 'о', 'л', 'д', 'ж', 'э', 'я', 'ч', 'с', 'м', 'и', 'т', 'ь', 'б', 'ю', '[', '"', '№', '%', ':', ',', '.', ';', 'Й', 'Ц', 'У', 'К', 'Е', 'Н', 'Г', 'Ш', 'Щ', 'З', 'Х', 'Ъ', 'Ё', 'Ф', 'Ы', 'В', 'А', 'П', 'Р', 'О', 'Л', 'Д', 'Ж', 'Э', 'Я', 'Ч', 'С', 'М', 'И', 'Т', 'Ь', 'Б', 'Ю'];

        return strtr($str, array_combine($eng, $rus));
    }

    /**
     * Changes keyboard layout from Russian to English using Mac layouts
     *
     * @param string $str
     *
     * @return string
     */
    public static function changeRusKeyboardLayoutToEng(string $str): string
    {
        // These arrays contain only pairs of symbols that are different in different layouts
        $eng = ['`', 'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', '[', ']', '\\', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', ';', '\'', 'z', 'x', 'c', 'v', 'b', 'n', 'm', ',', '.', '~', '@', '#', '$', '%', '^', '&', '*', 'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P', '{', '}', '|', 'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', ':', '"', 'Z', 'X', 'C', 'V', 'B', 'N', 'M', '<', '>'];
        $rus = [']', 'й', 'ц', 'у', 'к', 'е', 'н', 'г', 'ш', 'щ', 'з', 'х', 'ъ', 'ё', 'ф', 'ы', 'в', 'а', 'п', 'р', 'о', 'л', 'д', 'ж', 'э', 'я', 'ч', 'с', 'м', 'и', 'т', 'ь', 'б', 'ю', '[', '"', '№', '%', ':', ',', '.', ';', 'Й', 'Ц', 'У', 'К', 'Е', 'Н', 'Г', 'Ш', 'Щ', 'З', 'Х', 'Ъ', 'Ё', 'Ф', 'Ы', 'В', 'А', 'П', 'Р', 'О', 'Л', 'Д', 'Ж', 'Э', 'Я', 'Ч', 'С', 'М', 'И', 'Т', 'Ь', 'Б', 'Ю'];

        return strtr($str, array_combine($rus, $eng));
    }

    public static function stringifyValue(mixed $value): string
    {
        return match (true) {
            is_null($value) => self::stringifyNull($value),
            is_bool($value) => self::stringifyBool($value),
            is_int($value) => self::stringifyInt($value),
            is_float($value) => self::stringifyFloat($value),
            is_string($value) => self::stringifyString($value),
            is_array($value) => self::stringifyArray($value),
            is_object($value) => self::stringifyObject($value),
            default => (string) $value,
        };
    }

    public static function stringifyArray(array $value): string
    {
        return sprintf(
            '[%s]',
            implode(
                ', ',
                array_map(
                    fn(int|string $k, mixed $v): string => "$k => " . self::stringifyValue($v),
                    array_keys($value),
                    array_values($value),
                ),
            ),
        );
    }

    public static function stringifyString(string $value): string
    {
        return '"' . addslashes($value) . '"';
    }

    public static function stringifyInt(int $value): string
    {
        return sprintf('%d', $value);
    }

    public static function stringifyFloat(float $value): string
    {
        return sprintf('%g', $value);
    }

    public static function stringifyBool(bool $value): string
    {
        return $value ? 'true' : 'false';
    }

    public static function stringifyNull(null $value): string
    {
        return 'null';
    }

    public static function stringifyObject(object $value): string
    {
        return 'object(' . $value::class . ')';
    }
}
