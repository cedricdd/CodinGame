<?php

// Function to calculate GCD
function gcd(int $a, int $b): int {
    return $b == 0 ? $a : gcd($b, $a % $b);
}

// Extended Euclidean Algorithm to find the modular inverse
function extendedGCD(int $a, int $b): array {
    if ($b == 0) return [$a, 1, 0];
    
    [$g, $x1, $y1] = extendedGCD($b, $a % $b);

    $x = $y1;
    $y = $x1 - intdiv($a, $b) * $y1;

    return [$g, $x, $y];
}

fscanf(STDIN, "%d %d %d %d %d", $x, $y, $m, $n, $L);

if($m == $n) exit("Impossible"); //Both frogs move at the same speed, it's impossible

/**
 * After k jumps, the position of Frog A will be: (x + k * m) mod L
 * After k jumps, the position of Frog B will be: (y + k * n) mod L
 * For frogs to met we need to have: (x + k * m) ≡ (y + k * n) mod L
 * Or: k * (m − n) ≡ (y − x) mod L
 */

$jumpDiff = $m - $n;
$positionDiff = ($y - $x) % $L;

//Calculate gcd of (m - n) and L
$gcd = gcd($jumpDiff, $L);
    
//Check if gcd divides the position difference
if ($positionDiff % $gcd != 0) exit("Impossible");

//Normalize the values
$L = intdiv($L, $gcd);
$jumpDiff = intdiv($jumpDiff, $gcd);
$positionDiff = intdiv($positionDiff, $gcd);

//Get gcd, modular inverse (x), and y from the extended Euclidean algorithm
[, $modInv, ] = extendedGCD($jumpDiff, $L);

//Find the smallest positive k
$k = ($positionDiff * $modInv) % $L;

//We need the first non negative value
if ($k < 0) $k += abs($L);

echo $k . PHP_EOL;
