<?php

$alphabet = [
    "A" => "0x1818243C42420000", "B" => "0x7844784444780000", "C" => "0x3844808044380000", "D" => "0x7844444444780000", "E" => "0x7C407840407C0000", 
    "F" => "0x7C40784040400000", "G" => "0x3844809C44380000", "H" => "0x42427E4242420000", "I" => "0x3E080808083E0000", "J" => "0x1C04040444380000", 
    "K" => "0x4448507048440000", "L" => "0x40404040407E0000", "M" => "0x4163554941410000", "N" => "0x4262524A46420000", "O" => "0x1C222222221C0000", 
    "P" => "0x7844784040400000", "Q" => "0x1C222222221C0200", "R" => "0x7844785048440000", "S" => "0x1C22100C221C0000", "T" => "0x7F08080808080000", 
    "U" => "0x42424242423C0000", "V" => "0x8142422424180000", "W" => "0x4141495563410000", "X" => "0x4224181824420000", "Y" => "0x4122140808080000", "Z" => "0x7E040810207E0000"
];

$answer = array_fill(0, 8, "");

foreach(str_split(trim(fgets(STDIN))) as $c) {
     //Convert each letter to 64 bits binary and split into 8 lines of 8 bits
    foreach(str_split(str_pad(base_convert($alphabet[$c], 16, 2), 64, "0", STR_PAD_LEFT), 8) as $y => $line) {
        $answer[$y] .= $line;
    }
}

echo implode(PHP_EOL, array_map(function($line) {
    return rtrim(strtr($line, "01", " X"));
}, array_filter($answer, function($line) {
    return intval($line) != 0; //Do not print any blank lines
})));
