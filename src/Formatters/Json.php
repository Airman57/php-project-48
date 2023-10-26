<?php

namespace Differ\Formatters\Json;

function showJson(array $comparison)
{
    return json_encode($comparison, JSON_PRETTY_PRINT);
}
