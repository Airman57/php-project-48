<?php

namespace Differ\Parser;

use Exception;
use Symfony\Component\Yaml\Yaml;

function parse(string $fileAsString, string $extension)
{
    switch ($extension) {
        case 'json':
            return json_decode($fileAsString, true);
        case 'yaml':
        case 'yml':
            return Yaml::parse($fileAsString);
        default:
            throw new Exception('wrong extension, try json or yaml');
    }
}
