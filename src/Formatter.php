<?php

namespace Differ\Formatters;

function makeFormatted(array $comparison, string $formatName)
{
    return match ($formatName) {
        'stylish' => Stylish\formatOutput($comparison),
        'plain' => Plain\formatOutput($comparison),
        'json' => Json\formatOutput($comparison),
        default => throw new \Exception("Unknown format"),
    };
}
