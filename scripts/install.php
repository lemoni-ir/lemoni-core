<?php
echo "Installing Lemoni Core...\n";

$projectRoot = dirname(__DIR__);
$templatePath = dirname(__DIR__, 1) . "/template";


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

exec("rm -rf $templatePath");

echo "Installation complete!\n";
