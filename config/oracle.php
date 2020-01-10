<?php

// PDO ORACLE configuration
$options =  array(
    \PDO::ATTR_PERSISTENT => true,
    \PDO::ATTR_CASE,
    \PDO::CASE_LOWER,
    \PDO::ATTR_ERRMODE,
    \PDO::ERRMODE_EXCEPTION,
);

return [
    'consinco' => [
        'driver' => 'oracle',
        'host' => '192.168.250.23',
        'port' => 1521,
        'database' => 'teste',
        'username' => 'CONSINCO',
        'password' => 'C5_2044',
        'charset' => 'utf8',
        'options' => $options,
    ],
    'lojamarkvn' => [
        'driver' => 'oracle',
        'host' => '192.168.250.23',
        'port' => 1521,
        'database' => 'teste',
        'username' => 'LOJAMARKVN',
        'password' => 'LOJAMARKVN2018',
        'charset' => 'utf8',
        'options' => $options,
    ],
];
