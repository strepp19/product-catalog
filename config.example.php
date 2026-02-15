<?php

/**
 * Konfiguračný súbor - príklad
 * Skopíruj tento súbor ako config.php a uprav hodnoty
 */

return [
    'database' => [
        'host' => 'localhost',
        'dbname' => 'product_catalog',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4'
    ],
    
    'app' => [
        'name' => 'Produktový katalóg',
        'version' => '1.0.0',
        'debug' => true
    ]
];
