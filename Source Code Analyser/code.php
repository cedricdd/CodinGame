<?php

const EXCLUDED = [
    "and" => 0, "array" => 1, "echo" => 2, "else" => 3, "elseif" => 4, "if" => 5,  "for" => 6, 
    "foreach" => 7, "function" => 8, "or" => 9, "return" => 10, "while" => 11, "new" => 12
];

fscanf(STDIN, "%d", $n);

$functions = [];
$code = "";

for ($i = 0; $i < $n; $i++) {
    $line = preg_replace("/\/\/.*$/", "", stream_get_line(STDIN, 256 + 1, "\n")) . " "; //Remove single line comment
    $line = preg_replace("/\t/", "", $line); //Remove tab characters
    $line = preg_replace("/\s{2,}/", " ", $line); //Replace multiple whitespaces
    $code .= str_replace("'", "\"", $line); //Replace single quote by double quote
}

$code = preg_replace("/\/\*[^\*]*\*\//", "", $code); //Remove multi line comments
$code = preg_replace("/\"[^\"]*\"/", "", $code); //Remove anything within string literals

//Exclude class name and user-defined functions
preg_match_all("/(?<=function |new )[a-zA-Z0-9_]+(?=\()/", $code, $matches);

foreach($matches[0] as $match) {
    $code = str_replace($match, "", $code);
}

//Get all the function names
preg_match_all("/(?<!\\$)[a-zA-Z0-9_]+(?=\()/", $code, $matches);

foreach($matches[0] as $match) {
    if(!isset(EXCLUDED[strtolower($match)])) $functions[$match] = ($functions[$match] ?? 0) + 1;
}

if(count($functions) == 0) echo "NONE\n";
else {
    ksort($functions);

    foreach($functions as $name => $count) {
        echo "$name $count" . PHP_EOL;
    }
}
?>
