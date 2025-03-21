<?php

require __DIR__ . '/libs/sass_compiler_library/vendor/autoload.php';

use ScssPhp\ScssPhp\Compiler;

/**
 * Compiles a single SCSS file to a given CSS file.
 */
function compile_scss($input_scss_file, $output_css_file) {
    $compiler = new Compiler();
    // Point the import paths to the scss folder (outside compilation/)
    $compiler->setImportPaths(dirname($input_scss_file));

    try {
        $compiled_css = $compiler->compileString(
            file_get_contents($input_scss_file)
        )->getCss();

        file_put_contents($output_css_file, $compiled_css);
    } catch (Exception $e) {
        // Print or handle errors as needed
        echo "Error compiling SCSS: " . $e->getMessage() . PHP_EOL;
    }
}

/**
 * Finds all SCSS files, compiles each, and writes the resulting CSS.
 */
function compile_all_scss() {
    // scss/ is one level above compilation/
    $scss_dir = realpath(__DIR__ . '/../assets/scss');
    if (!$scss_dir) {
        echo "SCSS directory not found.\n";
        return;
    }

    $scss_files = find_scss_files($scss_dir);

    foreach ($scss_files as $input_scss) {
        // Build the corresponding CSS path:
        // 1) replace the scss/ portion with css/
        // 2) replace .scss with .css
        $relative_path = str_replace($scss_dir, '', $input_scss); // e.g. /subfolder/file.scss
        $output_css = __DIR__ . '/../assets/css' . str_replace('.scss', '.css', $relative_path);

        // Ensure the CSS output directory exists
        $output_dir = dirname($output_css);
        if (!is_dir($output_dir)) {
            mkdir($output_dir, 0777, true);
        }

        // Compile the file
        compile_scss($input_scss, $output_css);
    }
}

// Run the full compilation process
compile_all_scss();
