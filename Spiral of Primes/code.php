<?php

const DIRECTION = [[1, 0], [0, -1], [-1, 0], [0, 1]];

$primes = [2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59, 61, 67, 71, 73, 79, 83, 89, 97, 101, 103, 107, 109, 113, 127, 131, 137, 139, 149, 151, 157, 163, 167, 173, 179, 181, 191, 193, 197, 199, 211, 223, 227, 229, 233, 239, 241, 251, 257, 263, 269, 271, 277, 281, 283, 293, 307, 311, 313, 317, 331, 337, 347, 349, 353, 359, 367, 373, 379, 383, 389, 397, 401, 409, 419, 421, 431, 433, 439, 443, 449, 457, 461, 463, 467, 479, 487, 491, 499, 503, 509, 521, 523, 541];

fscanf(STDIN, "%d", $N);

$output[0][0] = 2;
$direction = 0;
$steps = 1;
$x = 0;
$y = 0;
$index = 1;
$xMax = $yMin = 0;

while($N != 1) {
    //Add all the prime in the current direction
    for($i = 1; $i <= $steps; ++$i) {
        $x += DIRECTION[$direction][0];
        $y += DIRECTION[$direction][1];

        $output[$y][$x] = $primes[$index++];

        if($x > $xMax) $xMax = $x;
        if($y < $yMin) $yMin = $y;

        if(--$N == 1) break 2; //We placed all the primes we want
    }

    $direction = ($direction + 1) % 4;
    $steps += 0.5; //Steps increase by one every 2 direction change
}

for($y = $yMin; $y <= abs($yMin); ++$y) {
    $line = [];

    for($x = ($xMax * -1); $x <= $xMax; ++$x) {
        $line[] = $output[$y][$x] ?? 0;    
    }

    echo implode(" ", $line) . PHP_EOL;
}
