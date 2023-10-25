<?php

namespace Differ\Parser;

use Symfony\Component\Yaml\Yaml;

function parse(string $pathToFile, string $extension)
{
    switch ($extension) {
        case 'json':
            return json_decode($fileContent, true);
        case 'yaml':
        case 'yml':
            return Yaml::parse($fileContent);
        default:
            throw new Exception('wrong extension, try json or yaml');
    }
}
