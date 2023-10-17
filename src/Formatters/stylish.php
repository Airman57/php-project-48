<?php

namespace Differ\Formatters\Stylish;

function valueToString(mixed $value)
{
    if (is_null($value)) {
        return 'null';
    } elseif (is_bool($value)) {
        return $value ? 'true' : 'false';
    } else {
        return $value;
    }
}

function toString(array $comparison)
{
    $result = array_map(function($value) {
        if (!is_array($value)) {
            return valueToString($value);
        }
        else {
            return toString($value);
        }
    }, $comparison);
    return $result;
}

function formatValue(mixed $value, $depth = 1)
{
  if (!is_array($value)) {
    return $value;
  }
  $gap = str_repeat('    ', $depth);
  $result = array_map(function($key, $node) use ($depth, $gap) {
    $newValue = formatValue($node, $depth + 1);
     return $gap . "    " . "$key: $newValue";    
  }, array_keys($value), $value);

   return "{\n" . implode("\n", $result) . "\n" . $gap . "}";  
}

function toStylish(array $comparison, $depth = 0)
{
    $newcomparison = toString($comparison);
    $gap = str_repeat('    ', $depth);
    $result = array_map(function($node) use ($depth, $gap) {
      if($node['condition'] === 'changed') {
        $newValue = formatValue($node['newValue'], $depth + 1);
        $oldValue = formatValue($node['oldValue'], $depth + 1);
        return $gap . "  - " . $node['key'] . ": " . $oldValue . "\n" .
               $gap . "  + " . $node['key'] . ": " . $newValue;
      }
      elseif($node['condition'] === 'added') {
        $value = formatValue($node['value'], $depth + 1);      
        return $gap . "  + " . $node['key'] . ": " . $value;
      }
      elseif ($node['condition'] === 'array') {
        $array = toStylish($node['children'], $depth + 1);
        return $gap . "    " . $node['key'] . ": {\n$array\n$gap    }";
      }
      elseif ($node['condition'] === 'removed') {
        $value = formatValue($node['value'], $depth + 1);
        return $gap . "  - " . $node['key'] . ": " . $value;
      }
      elseif ($node['condition'] === 'unchanged') {
        $value = formatValue($node['value'], $depth + 1);
        return $gap . "    " . $node['key'] . ": " . $value;
      }
    },$newcomparison);
    return implode("\n", $result);
}

function showStylish(array $comparison)
{
    return "{\n" . toStylish($comparison) . "\n}";
}