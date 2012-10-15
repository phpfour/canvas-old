#!/usr/bin/env php
<?php

function bundleHtml($file)
{
    $html = file_get_contents($file);

    $html = str_replace(array("\r\n", "\n", "\r"), " ", $html);
    $html = str_replace("'", "\\'", $html);
    $html = preg_replace("/\s+/", " ", $html);

    return $html;
}

$dirIterator = new DirectoryIterator(__DIR__ . '/../app/Resources/templates');

$bundle = "Templates = {};\n";
foreach ($dirIterator as $file) {
    if ($file->isFile()) {
        $html = bundleHtml($file->getPathname());
        $bundle .= "Templates." . $file->getBasename('.html') . " = '" . $html . "';\n";
    }
}

file_put_contents(__DIR__ . '/../app/Resources/js/Templates.js', $bundle);

if (php_sapi_name() == 'cli') {
    echo "Templates bundle created at app/Resources/js/Templates.js for inclusion.", PHP_EOL;
}