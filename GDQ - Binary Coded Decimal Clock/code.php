<?php

const BINARY = ["0000", "0001", "0010", "0011", "0100", "0101", "0110", "0111", "1000", "1001"];
const POS = [1 => 1, 3 => 3, 5 => 4, 7 => 6, 9 => 7, 11 => 9];

$input = trim(fgets(STDIN));

for ($y = 0; $y < 4; ++$y) {
    $line = "";

    for($x = 0; $x < 13; ++$x) {
        if($x & 1) $line .= BINARY[$input[POS[$x]]][$y] ? "#####" : "_____";
        else $line .= "|";
    }

    echo $line . PHP_EOL;
}
