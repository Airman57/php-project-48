<?php

namespace Differ\Formatter;

use function Differ\Formatters\Stylish\showStylish;
use function Differ\Formatters\Plain\showPlain;
use function Differ\Formatters\Json\showJson;

function makeFormatted(array $comparison, string $formatName)
{
    return match ($formatName) {
        'stylish' => showStylish($comparison),
        'plain' => showPlain($comparison),
        'json' => showJson($comparison),
        default => throw new \Exception("Unknown format"),
    };
}
