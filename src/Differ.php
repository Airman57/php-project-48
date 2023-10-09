<?php 

namespace Differ\Differ;

use function Differ\Parser\parse;

function boolToString($boolValue)
{
  return $boolValue ? 'true' : 'false';
}

function arrayBoolsToString(array $array)
{
  foreach($array as $key=>$values) {
    if(is_bool($values)) {
    $values = boolToString($values);
    $array[$key] = $values;
    }
  }
  return $array;
}

function compare(array $file1, array $file2)
{
    $file1Keys = array_keys($file1);
    $file2Keys = array_keys($file2);
    $keys = array_unique(array_merge($file1Keys, $file2Keys));
    sort($keys);
    $result = [];
    //var_dump($keys);
    foreach ($keys as $key) {
      if(!array_key_exists($key, $file1)) {
        $result[] = "+" . " {$key}: " . "{$file2[$key]}\n";
      }
      elseif(!array_key_exists($key, $file2)) {
        $result[] = "-" . " {$key}: " . "{$file1[$key]}";
      }
      elseif($file1[$key] === $file2[$key]) {
        $result[] = " " . " {$key}: " . "{$file1[$key]}";
      }
      elseif($file1[$key] !== $file2[$key]) {
        $result[] = "-" . " {$key}: " . "{$file1[$key]}\n"
                  . "+" . " {$key}: " . "{$file2[$key]}";
      }
      
    }
  $result = implode("\n", $result);
  return   "{\n" . $result ."}\n";
}

function genDiff(string $file1, string $file2)
{
  $file1Array = parse($file1);
  $file2Array = parse($file2);  
  return compare($file1Array, $file2Array);
}

//php match