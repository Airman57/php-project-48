<?php

namespace Differ\Formatters\Json;

function showJson(array $diff)
{
    return json_encode($diff, JSON_PRETTY_PRINT);
}
