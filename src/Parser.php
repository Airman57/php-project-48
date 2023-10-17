<?php

namespace Differ\Parser;

use Symfony\Component\Yaml\Yaml;

function jsonToArray(string $pathToFile)
{
    $jsonString = file_get_contents($pathToFile);
    $jsonArray = json_decode((string) $jsonString, true);
    return $jsonArray;
}

function yamlToArray(string $pathToFile)
{
    $yamlArray = Yaml::parseFile($pathToFile);
    return $yamlArray;
}

function parse(string $pathToFile)
{
    $extension = pathinfo($pathToFile, PATHINFO_EXTENSION);
    $resultArray = match ($extension) {
        'json' => jsonToArray($pathToFile),
        'yaml' => yamlToArray($pathToFile),
        'yml' => yamlToArray($pathToFile),
    };
    return $resultArray;
}
