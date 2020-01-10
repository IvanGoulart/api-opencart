<?php

// Gerar Serial ( uniqId )
function uniqueId($lenght)
{
    $uniqId = null;
    for ($i = 0; $i < 10; $i++) {
        $uniqId .= str_replace('.', '', uniqid(rand(), true));
    }
    return substr($uniqId, 0, $lenght);
}

function getMemoryUsage()
{
    return [
        'memoryInUse' =>  memory_get_usage() . ' (' . round(memory_get_usage() / 1024 / 1024, 2) . 'M)',
        'peakUsage' => memory_get_peak_usage() . ' (' . round(memory_get_peak_usage() / 1024 / 1024, 2) . 'M)',
        'memoryLimit' => ini_get('memory_limit')
    ];
}
