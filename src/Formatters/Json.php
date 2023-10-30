<?php

namespace Differ\Formatters\Json;

function formatOutput(array $comparison)
{
    return json_encode($comparison, JSON_PRETTY_PRINT);
}
