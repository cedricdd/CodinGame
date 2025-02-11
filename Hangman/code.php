<?php

$word = trim(fgets(STDIN));
$guess = preg_replace("/[a-zA-Z]/", "_", $word);
$checked = [];
$errors = 0;

foreach(explode(" ", trim(fgets(STDIN))) as $c) {
    if(isset($checked[$c])) ++$errors;
    else {
        $checked[$c] = 1;
        
        if(stripos($word, $c) !== false) {
            for($i = strlen($word) - 1; $i >= 0; --$i) {
                if($c == strtolower($word[$i])) $guess[$i] = $word[$i];
            }
        } else ++$errors;
    }
}

$hangman = [
    "+--+",
    "|",
    "|",
    "|\\",
];

if($errors > 0) $hangman[1][3] = 'o';
if($errors > 2) $hangman[2][2] = '/';
if($errors > 1) $hangman[2][3] = '|';
if($errors > 3) $hangman[2][4] = '\\';
if($errors > 4) $hangman[3][2] = '/';
if($errors > 5) $hangman[3][4] = '\\';

echo implode(PHP_EOL, $hangman) . PHP_EOL . $guess . PHP_EOL;
