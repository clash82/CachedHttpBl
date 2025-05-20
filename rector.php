<?php declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    // target directories
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    // enable dead-code & code-quality rules
    ->withPreparedSets(deadCode: true, codeQuality: true)
    // auto-align PHP version to composer.json
    ->withPhpSets();
