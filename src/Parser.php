<?php 

namespace Differ\Parser;

use Symfony\Component\Yaml\Yaml;

function jsonToArray(string $pathToFile)
{
    $jsonString = file_get_contents($pathToFile);
    $jsonArray = json_decode($jsonString, true);
    return $jsonArray;
}

function yamlToArray(string $pathToFile)
{
    $yamlArray = Yaml::parseFile($pathToFile);
    return $yamlArray;
}

function parse(string $pathToFile)
{
    if(str_contains($pathToFile, 'json')) {
        return jsonToArray($pathToFile);
    }
    elseif(str_contains($pathToFile, 'yml') || str_contains($pathToFile, 'yaml')) {
        return yamlToArray($pathToFile);
    }
}