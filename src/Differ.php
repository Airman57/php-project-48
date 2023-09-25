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

function compare($file1, $file2)
{
    $arrayFile1 = arrayBoolsToString(parse($file1));
    $arrayFile2 = arrayBoolsToString(parse($file2)); 
    $file1Keys = array_keys($arrayFile1);
    $file2Keys = array_keys($arrayFile2);
    $keys = array_unique(array_merge($file1Keys, $file2Keys));
    sort($keys);
    $result = [];
    //var_dump($keys);
    foreach ($keys as $key) {
      if(!array_key_exists($key, $arrayFile1)) {
        $result[] = "+" . " {$key}: " . "{$arrayFile2[$key]}\n";
      }
      elseif(!array_key_exists($key, $arrayFile2)) {
        $result[] = "-" . " {$key}: " . "{$arrayFile1[$key]}";
      }
      elseif($arrayFile1[$key] === $arrayFile2[$key]) {
        $result[] = " " . " {$key}: " . "{$arrayFile1[$key]}";
      }
      elseif($arrayFile1[$key] !== $arrayFile2[$key]) {
        $result[] = "-" . " {$key}: " . "{$arrayFile1[$key]}\n"
                  . "+" . " {$key}: " . "{$arrayFile2[$key]}";
      }
      
    }
  $result = implode("\n", $result);
  return   "{\n" . $result ."}\n";
}

function genDiff($file1, $file2)
{
    return compare($file1, $file2);
}