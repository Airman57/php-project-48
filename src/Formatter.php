<?php

namespace Differ\Formatter;

use function Differ\Formatters\Stylish\showStylish;
use function Differ\Formatters\Plain\showPlain;
use function Differ\Formatters\Json\showJson;

function showFormatted(array $comparison, $formatName)
{
    $result = match ($formatName) {
        'stylish' => showStylish($comparison),
        'plain' => showPlain($comparison),
        'json' => showJson($comparison),
    };
    return $result;
}