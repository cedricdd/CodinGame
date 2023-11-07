<?php

function GCD(int $a, int $b): int {
    return $b ? GCD($b, $a % $b) : $a;
}

function LCM(int $a, int $b): int {
    return $a * $b / GCD($a, $b);
}

function findPeriod(int $size): int {
    static $history = [];

    if(isset($history[$size])) return $history[$size];

    $start = $transformation = range(1, $size);
    $steps = 0;

    do {
        $newTransformation = [];

        //Apply the transformation
        for($i = 0; $i < $size; $i += 2) $newTransformation[] = $transformation[$i];
        for($i = 1; $i < $size; $i += 2) $newTransformation[] = $transformation[$i];

        $transformation = $newTransformation;
        ++$steps;

    } while($transformation != $start); //We are back to the initial array, we have found the period

    return $history[$size] = $steps;
}

fscanf(STDIN, "%d", $T);
for ($i = 0; $i < $T; $i++) {
    fscanf(STDIN, "%d %d", $W, $H);

    //Sizes are independent, the answer is the LCM of both periods
    echo LCM(findPeriod($W), findPeriod($H)) . PHP_EOL;
}
