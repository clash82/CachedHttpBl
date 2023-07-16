<?php declare(strict_types=1);

$baseDir = dirname(__DIR__);

$loader = require __DIR__.'/../vendor/autoload.php';
$loader->add('CachedHttpBL', [$baseDir.'/src/', $baseDir.'/tests/']);
$loader->register();
