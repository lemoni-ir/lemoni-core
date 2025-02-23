<?php
echo "Installing Lemoni Core...\n";

$projectRoot = dirname(__DIR__);
$templatePath = dirname(__DIR__, 1) . "/template";
$scriptsPath = dirname(__DIR__, 1) . "/scripts";


if (!is_dir($templatePath))
    die("Error: Template folder not found!\nprojectRoot: $projectRoot\ntemplatePath: $templatePath\n");


function copy_folder($src, $dst)
{
    $dir = opendir($src);
    @mkdir($dst, 0777, true);

    while (($file = readdir($dir)) !== false) {
        if ($file === '.' || $file === '..')
            continue;
        $srcFile = "$src/$file";
        $dstFile = "$dst/$file";
        if (is_dir($srcFile)) {
            copy_folder($srcFile, $dstFile);
        } else {
            copy($srcFile, $dstFile);
        }
    }
    closedir($dir);
}

copy_folder($templatePath, $projectRoot);

define('win', strtoupper(substr(PHP_OS, 0, 3)) === 'WIN');

if (win) {
    echo "Win\n";
    exec("rmdir /s /q \"$templatePath\"");
    exec("rmdir /s /q \"$scriptsPath\"");
} else {
    echo "Linux\n";
    exec("rm -rf \"$templatePath\"");
    exec("rm -rf \"$scriptsPath\"");
}

echo "Installation complete!\n";




