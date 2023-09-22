<?php 

namespace Differ\Differ;

function readFile(string $pathToFile)
{
    $fileInfo = file_get_contents($pathToFile);
    return $fileInfo;
}

function getDecodeJson(string $pathToFile)
{
    $jsonString = readfile($pathToFile);
    $jsonArray = json_decode($jsonString, true);
    return $jsonArray;
}

function boolToString($boolValue)
{
  return $boolValue ? 'true' : 'false';
}

function compare($file1, $file2)
{
    $arrayFile1 = getDecodeJson($file1);
    $arrayFile2 = getDecodeJson($file2);
  foreach ($arrayFile2 as $key=>$values) {
    if(is_bool($values)) {
    $values = boolToString($values);
    $arrayFile2[$key] = $values;
    }
  }
  foreach ($arrayFile1 as $key=>$values) {
    if(is_bool($values)) {
    $values = boolToString($values);
    $arrayFile1[$key] = $values;
    }
  }
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
  return $result;   
}

function genDiff($file1, $file2)
{
    return compare($file1, $file2);
}