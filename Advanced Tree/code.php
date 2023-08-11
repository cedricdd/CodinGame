<?php

function explodeString(array &$directory, string $string): void {
    global $showHidden, $onlyDirectories;

    if(empty($string)) return;

    //We are not showing hidden files
    if($string[0] == "." && $showHidden == false) return;

    $position = strpos($string, "/");

    //We are working on a directory
    if($position !== false) {
        $name = substr($string, 0, $position);

        if(!isset($directory[$name])) $directory[$name] = [];

        explodeString($directory[$name], substr($string, $position + 1));
    } //We are working on a file and we don't only want directories 
    elseif($onlyDirectories != true) $directory[$string] = 1;
}

function printDirectory(int &$directories, int &$files, string $prepend, int $depth, array $directory): void {
    global $limitDepth;

    if($depth > $limitDepth) return; //We are behond the max depth

    //Sort the elements in the directory
    uksort($directory, function($a, $b) {
        return strcasecmp(ltrim($a, "."), ltrim($b, "."));
    });

    $last = array_key_last($directory);

    foreach($directory as $name => $info) {
        echo $prepend . ($name == $last ? "`" : "|") . "-- " . $name . PHP_EOL;

        if(is_array($info)) {
            ++$directories;

            printDirectory($directories, $files, $prepend . ($name == $last ? " "  : "|") . "   ", $depth + 1, $info);
        } else ++$files;
    }
}

$path = $pathCheck = trim(fgets(STDIN));
$showHidden = false;
$onlyDirectories = false;
$limitDepth = INF;

//Read the flags
foreach(explode(",", trim(fgets(STDIN))) as $option) {
    if($option == "-a") $showHidden = true;
    elseif($option == "-d") $onlyDirectories = true;
    elseif(preg_match("/-L ([0-9]+)/", $option, $matches)) $limitDepth = $matches[1];
}

$directory = [];

if($pathCheck[0] != ".") $pathCheck = "./" . $pathCheck;

for ($i = trim(fgets(STDIN)); $i--;) {
    $line = trim(fgets(STDIN));

    //If this file is needs to be shown, parse it
    if(strpos($line, $pathCheck) === 0) {
        explodeString($directory, substr($line, strlen($pathCheck) + 1));
    }   
}

$directories = 0;
$files = 0;

if(count($directory)) {
    echo $path . PHP_EOL;

    printDirectory($directories, $files, "", 1, $directory);
} //Nothing to show, path is a file or doesn't exist
else echo "$path [error opening dir]" . PHP_EOL;


echo PHP_EOL . $directories . ($directories == 1 ? " directory" : " directories") . ($onlyDirectories == false ? (", " . $files . ($files == 1 ? " file" : " files")) : "") . PHP_EOL;
