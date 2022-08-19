<?php

$line = "";
fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $line .= trim(fgets(STDIN));
}

error_log(var_export($line, true));

//Remove escaped string delimiters
$line = preg_replace("/(?<!\\\)\\\\\"/", "", $line);

//Remove everything that is in quotes or not a bracket
$line = preg_replace("/\"[^\"]*\"|[^\(\)\[\]\{\}]/", "", $line);

//No brackets in the input
if(empty($line)) die("No brackets");

//Remove valid brackets
do {
    $line = preg_replace("/\(\)|\[\]|\{\}/", "", $line, -1, $replaced);
} while($replaced);

//Not all brackets have been removed
if(!empty($line)) echo "Invalid" . PHP_EOL;
else echo "Valid" . PHP_EOL;
?>
