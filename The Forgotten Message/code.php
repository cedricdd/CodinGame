<?php

const ALPHABET = [
    0 => ' ',
    2 => 'A', 22 => 'B', 222 => 'C', 
    3 => 'D', 33 => 'E', 333 => 'F',
    4 => 'G', 44 => 'H', 444 => 'I',
    5 => 'J', 55 => 'K', 555 => 'L',
    6 => 'M', 66 => 'N', 666 => 'O',
    7 => 'P', 77 => 'Q', 777 => 'R', 7777 => 'S',
    8 => 'T', 88 => 'U', 888 => 'V',
    9 => 'W', 99 => 'X', 999 => 'Y', 9999 => 'Z',
];

$output = "";
$upperCase = 0;

preg_match_all('/(.)\1*/', trim(fgets(STDIN)), $matches);

foreach($matches[0] as $string) {
    if($string == ' ') continue; //Separator between two letter using the same digits

    if($string == '#') $upperCase ^= 1; //Changing case
    else {
        $letter = ALPHABET[$string];
        $output .= ($upperCase ? $letter : strtolower($letter));
    }
}

echo $output . PHP_EOL;
