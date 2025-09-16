#!/usr/bin/env php
<?php


$basePath = __DIR__;


$type = $argv[1] ?? null;    
$service = $argv[2] ?? null;  

if (!$type || !$service) {
    echo "Usage: php copy-trait.php [auth|response] [service]\n";
    exit(1);
}


$map = [
    'auth' => 'AuthCheckTrait.php',
    'response' => 'ResponseTrait.php',
];

if (!isset($map[$type])) {
    echo "Invalid type. Allowed: auth | response\n";
    exit(1);
}

$fileName = $map[$type];


$sourceFile = $basePath . "/" . $fileName;


$destinationPath = dirname($basePath, 2) . "/services/{$service}-service/app/Traits";
$destinationFile = $destinationPath . "/" . $fileName;


if (!file_exists($sourceFile)) {
    echo "❌ Source file not found: $sourceFile\n";
    exit(1);
}

if (!is_dir($destinationPath)) {
    mkdir($destinationPath, 0755, true);
    echo "📂 Created folder: $destinationPath\n";
}

if (copy($sourceFile, $destinationFile)) {
    echo "✅ Copied $fileName → $destinationPath\n";
} else {
    echo "❌ Failed to copy file.\n";
    exit(1);
}
