<?php

function GCD (int $a, int $b): int {
    return $b ? GCD($b, $a % $b) : $a;
}

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    [$A, $B] = explode("/", trim(fgets(STDIN)));

    //Division by 0
    if($B == 0) {
        echo "DIVISION BY ZERO" . PHP_EOL;
        continue;
    } //Result is just 0
    elseif($A == 0) {
        echo "0" . PHP_EOL;
        continue;
    }

    $quotient = intdiv($A, $B);
    $remainder = $A % $B;

    //Result is just the integer part
    if($remainder == 0) {
        echo $quotient . PHP_EOL;
        continue;
    }

    $gcd = GCD(abs($remainder), abs($B));
    $numerator = abs($remainder / $gcd);
    $denominator = abs($B / $gcd);

    //It's a negative number with no integer part
    if($quotient == 0 && $A / $B < 0) $numerator *= -1;

    echo (($quotient != 0) ? "$quotient " : "") . $numerator . "/" . $denominator . PHP_EOL;
}
