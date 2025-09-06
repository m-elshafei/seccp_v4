<?php

$configPath = __DIR__ . '/config';
$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($configPath));

foreach ($rii as $file) {
    if ($file->isDir()) {
        continue;
    }

    if ($file->getExtension() !== 'php') {
        continue;
    }

    $filePath = $file->getPathname();

    try {
        $config = @include $filePath; // suppress errors
    } catch (Throwable $e) {
        echo "⚠️ Skipped (error in execution): {$filePath} -> " . $e->getMessage() . PHP_EOL;
        continue;
    }

    if (!is_array($config)) {
        echo "❌ Problem in: {$filePath} -> returns " . gettype($config) . PHP_EOL;
    }
}
