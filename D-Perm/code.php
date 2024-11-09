<?php

function dPerm(array $matrix, int $direction): array {
    global $n;

    $permutation = [];

    //Top-Left
    if($direction == 1) {
        for($y = 0; $y < $n; ++$y) {
            for($x = 0; $x < $n; ++$x) {
                if($x == 0) $permutation[$n - 1][$n - 1 - $y] = $matrix[$y][$x];
                elseif($y == 0) $permutation[$n - 1 - $x][$n - 1] = $matrix[$y][$x];
                else $permutation[$y - 1][$x - 1] = $matrix[$y][$x];
            }
        }
    }
    //Top-Right
    if($direction == 2) {
        for($y = 0; $y < $n; ++$y) {
            for($x = 0; $x < $n; ++$x) {
                if($x == $n - 1) $permutation[$n - 1][$y] = $matrix[$y][$x];
                elseif($y == 0) $permutation[$x][0] = $matrix[$y][$x];
                else $permutation[$y - 1][$x + 1] = $matrix[$y][$x];
            }
        }
    }
    //Bottom-Right
    if($direction == 3) {
        for($y = 0; $y < $n; ++$y) {
            for($x = 0; $x < $n; ++$x) {
                if($x == $n - 1) $permutation[0][$n - 1 - $y] = $matrix[$y][$x];
                elseif($y == $n - 1) $permutation[$n - 1 - $x][0] = $matrix[$y][$x];
                else $permutation[$y + 1][$x + 1] = $matrix[$y][$x];
            }
        }
    }
    //Bottom-Left
    if($direction == 4) {
        for($y = 0; $y < $n; ++$y) {
            for($x = 0; $x < $n; ++$x) {
                if($x == 0) $permutation[0][$y] = $matrix[$y][$x];
                elseif($y == $n - 1) $permutation[$x][$n - 1] = $matrix[$y][$x];
                else $permutation[$y + 1][$x - 1] = $matrix[$y][$x];
            }
        }
    }

    return $permutation;
}

fscanf(STDIN, "%d %d", $n, $k);

for ($i = 0; $i < $n; $i++) {
    $matrix[] = array_map("intval", explode(" ", trim(fgets(STDIN))));
}

foreach(explode(" ", trim(fgets(STDIN))) as $direction) $matrix = dPerm($matrix, $direction);

ksort($matrix);

echo implode(PHP_EOL, array_map(function($line) {
    ksort($line);

    return implode(" ", $line);
}, $matrix)) . PHP_EOL;
