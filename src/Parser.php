<?php

namespace Differ\Parser;

use Exception;

use Symfony\Component\Yaml\Yaml;

function parse(string $pathToFile, string $extension)
{
    switch ($extension) {
        case 'json':
            return json_decode($pathToFile, true);
        case 'yaml':
        case 'yml':
            return Yaml::parse($pathToFile);
        default:
            throw new Exception('wrong extension, try json or yaml');
    }
}
