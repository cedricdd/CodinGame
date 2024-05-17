<?php

function generateInfo(int $n): array {
    $size = strlen(decbin($n));
    $info = [[0, 0, 0], [1, 1, 1]];

    for($i = 2; $i < $size; ++$i) {
        $a = $info[$i - 1][0] * 2; //The count of numbers with a binary represenation of $size bits
        $b = $info[$i - 1][1] * 2 + $info[$i - 1][0]; //The count of '1' in these representation
        $c = $info[$i - 1][2] + $b; //The count of '1' in the binary representation since 0 

        $info[$i] = [$a, $b, $c];
    }

    return $info;
}

function solve(int $n, array $info): int {
    $count = 0;

    while($n) {
        $size = strlen(strval(decbin($n))); //The current length of the binary representation
        $power = 2 ** ($size - 1); //The first number having the same length in binary as $n
    
        $count += $info[$size - 1][2]; //The first bit is a '1', add the count of '1' needed to reach the current bit position
        $count += $n - $power + 1; //The count of '1' at the current bit position
        $n -= $power;
    }

    return $count;
}

fscanf(STDIN, "%d", $n);

$info = generateInfo($n);

echo solve($n, $info) . PHP_EOL;
