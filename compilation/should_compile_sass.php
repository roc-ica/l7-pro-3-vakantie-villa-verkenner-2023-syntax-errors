<?php

require_once 'utils.php';

function files_need_recompile($scss_dir) {
    $scss_files = find_scss_files($scss_dir);

    foreach ($scss_files as $scss_file) {
        // Convert SCSS file path to corresponding CSS path
        $relative_path = str_replace($scss_dir, '', $scss_file);
        $css_file = __DIR__ . '/../assets/css' . str_replace('.scss', '.css', $relative_path);

        // If the CSS file doesn't exist or SCSS is newer, we need recompilation
        if (!file_exists($css_file) || filemtime($scss_file) > filemtime($css_file)) {
            return true;
        }
    }

    return false;
}

$scss_dir = realpath(__DIR__ . '/../assets/scss');
if (!$scss_dir) {
    echo "SCSS directory not found.\n";
    exit;
}

// Check if we need to recompile
if (files_need_recompile($scss_dir)) {
    // Include compiler script to run compilation
    include_once __DIR__ . '/compiler_sass.php';
    echo "SCSS files recompiled.\n";
} else {
    echo "No changes detected. SCSS is up to date.\n";
}
