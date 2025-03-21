<?php

//https://en.wikipedia.org/wiki/Shoelace_formula
function shoelaceFormula(array $vertices): int {
    $n = count($vertices);
    $sum = 0;

    for ($i = 0; $i < $n - 1; $i++) {
        $sum += ($vertices[$i][0] * $vertices[$i + 1][1] - $vertices[$i + 1][0] * $vertices[$i][1]);
    }

    return abs($sum) / 2;
}

fscanf(STDIN, "%d", $n);

$x = 0;
$y = 0;
$border = 0;
$vertices = [[0, 0]];

for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%s %d", $direction, $step);

    switch($direction) {
        case '>':   $x += $step;    break;
        case '<':   $x -= $step;    break;
        case 'v':   $y += $step;    break;
        case '^':   $y -= $step;    break;
    }

    $vertices[] = [$x, $y];
    $border += $step;
}

//https://en.wikipedia.org/wiki/Pick%27s_theorem
echo (shoelaceFormula($vertices) + $border / 2 + 1) . PHP_EOL;
