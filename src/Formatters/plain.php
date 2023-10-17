<?php

namespace Differ\Formatters\Plain;

use function Functional\flatten;

function formatValue(mixed $value)
{
    if(is_array($value)) {
        return '[complex value]';
    } elseif (is_null($value)) {
        return 'null';
    } elseif (is_bool($value)) {
        return $value ? 'true' : 'false';
    } else {
    return "'$value'";
    }
}

function toPlain($comparison, $keysPath = "")
{
      $result = array_map(function($node) use ($keysPath) {
      $path = $keysPath.$node['key'];
        switch ($node['condition']) {
            case 'changed':
                $oldValue = formatValue($node['oldValue']);
                $newValue = formatValue($node['newValue']);
                return "Property '$path' was updated. From $oldValue to $newValue";
            case 'added':
                $value = formatValue($node['value']);
                return "Property '$path' was added with value: $value";
            case 'array':
                $path = $keysPath . $node['key'] . '.';
                return toPlain($node['children'], $path);
            case 'removed':
                $value = formatValue($node['value']);
                return "Property '$path' was removed";
            case 'unchanged':
                return [];
            }
    },$comparison);
    return $result;
}

function showPlain($comparison)
  {
    $comparisonAsPlain = flatten(toPlain($comparison));
    return implode ("\n", $comparisonAsPlain);
  }
