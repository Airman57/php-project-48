<?php

namespace Differ\Differ;

use function Functional\sort;
use function Differ\Parser\parse;
use function Differ\Formatters\makeFormatted;

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

function convertToArray(string $pathToFile)
{
    $extension = pathinfo($pathToFile, PATHINFO_EXTENSION);
    $string = file_get_contents($pathToFile);
    if ($string === false) {
        throw new \Exception("Unknown readfile error");
    }
    $array = parse($string, $extension);
    return $array;
}


function genDiff(string $file1, string $file2, string $format = 'stylish')
{
    $file1Array = convertToArray($file1);
    $file2Array = convertToArray($file2);
    $difference = compare($file1Array, $file2Array);
    return makeFormatted($difference, $format);
}
