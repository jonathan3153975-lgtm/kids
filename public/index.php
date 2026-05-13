<?php

declare(strict_types=1);

use Core\App;

session_start();

define('ROOT_PATH', dirname(__DIR__));

require ROOT_PATH . '/vendor/autoload.php';
require ROOT_PATH . '/core/helpers.php';

spl_autoload_register(static function (string $class): void {
    $prefixes = [
        'App\\' => ROOT_PATH . '/app/',
        'Core\\' => ROOT_PATH . '/core/',
    ];

    foreach ($prefixes as $prefix => $baseDir) {
        if (!str_starts_with($class, $prefix)) {
            continue;
        }

        $relativeClass = substr($class, strlen($prefix));
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

        if (is_file($file)) {
            require $file;
        }
    }
});

$GLOBALS['app_config'] = require ROOT_PATH . '/config/app.php';

(new App($GLOBALS['app_config']))->run();
