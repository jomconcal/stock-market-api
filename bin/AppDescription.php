#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';
class AppDescription
{

    public static function run(): void
    {
        echo 'src'.PHP_EOL;
        self::printTree(__DIR__ . '/../src');
    }

    private static function printTree(string $dir, string $indent = ''): void
    {
        $files = scandir($dir);

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $path = $dir . DIRECTORY_SEPARATOR . $file;

            echo $indent . '├── ' . $file . PHP_EOL;

            if (is_dir($path)) {
                self::printTree($path, $indent . '│   ');
            }
        }
    }
}
AppDescription::run();
