<?php

namespace Differ\Differ;

use function Functional\sort;
use function Differ\Parser\parse;
use function Differ\Formatter\showFormatted;

function compare(array $file1, array $file2)
{
    $file1Keys = array_keys($file1);
    $file2Keys = array_keys($file2);
    $keys = array_unique(array_merge($file1Keys, $file2Keys));
    $sortedKeys = sort($keys, fn($x, $y) => strcmp($x, $y));
    $result = array_map(function ($key) use ($file1, $file2) {
        if (!array_key_exists($key, $file1)) {
            return ['key' => $key, 'condition' => 'added', 'value' => $file2[$key]];
        } elseif (!array_key_exists($key, $file2)) {
            return ['key' => $key, 'condition' => 'removed', 'value' => $file1[$key]];
        } elseif (is_array($file1[$key]) && is_array($file2[$key])) {
            return ['key' => $key, 'condition' => 'array', 'children' => compare($file1[$key], $file2[$key])];
        } elseif ($file1[$key] !== $file2[$key]) {
            return ['key' => $key, 'condition' => 'changed','oldValue' => $file1[$key], 'newValue' => $file2[$key]];
        } else {
            return ['key' => $key, 'condition' => 'unchanged', 'value' => $file1[$key]];
        }
    }, $sortedKeys);
    return $result;
}


function genDiff(string $file1, string $file2, string $format = 'stylish')
{
    $file1Array = parse($file1);
    $file2Array = parse($file2);
    $difference = compare($file1Array, $file2Array);
    return showFormatted($difference, $format);
}
