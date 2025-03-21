<?php

function find_scss_files($dir) {
    $scss_files = [];

    // Safeguard if the directory doesn't exist
    if (!is_dir($dir)) {
        return $scss_files;
    }

    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'scss') {
            $scss_files[] = $file->getPathname();
        }
    }
    return $scss_files;
}


