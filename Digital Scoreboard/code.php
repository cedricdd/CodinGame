<?php

const DIGITS = [119 => 0, 18 => 1, 93 => 2, 91 => 3, 58 => 4, 107 => 5, 111 => 6, 82 => 7, 127 => 8, 122 => 9];
const CHECKS = [6 => [1, 3], 5 => [2, 2], 4 => [2, 6], 3 => [3, 3], 2 => [4, 2], 1 => [4, 6], 0 => [5, 3]];

function readInput(int &$digit1, int &$digit2, int $startLine, array $inputs, bool $addition = true) {
    foreach(CHECKS as $index => [$y, $x]) {
        if($inputs[$startLine + $y][$x] != " ") {
            if($addition) $digit1 |= 1 << $index;
            else $digit1 &= ~(1 << $index);
        }
        if($inputs[$startLine + $y][$x + 8] != " ") {
            if($addition) $digit2 |= 1 << $index;
            else $digit2 &= ~(1 << $index);
        }
    }
}

for ($i = 0; $i < 23; $i++) {
    $inputs[] = trim(fgets(STDIN));
}

$digit1 = 0;
$digit2 = 0;

readInput($digit1, $digit2, 0, $inputs);
readInput($digit1, $digit2, 8, $inputs, false);
readInput($digit1, $digit2, 16, $inputs);

echo DIGITS[$digit1] . DIGITS[$digit2] . PHP_EOL;
