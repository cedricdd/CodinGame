<?php

$start = microtime(1);

fscanf(STDIN, "%s", $s);
fscanf(STDIN, "%s", $i);

/**
 * R1: 1 + 0i
 * R2: 1 + 1i
 * R3: 1 + 2i
 * R4: 1 + 3i
 * Rn: 1 + (n-1)i
 * So we know that if we have n rows we are using: n + (0+1+2+3+4+...+n-1)i stars
 * The sum from 1 to k is k(k + 1) / 2 so the sum from 1 to (n-1) is (n-1)n / 2 => (n² - n) / 2
 * With n rows we are using: n + ((n² - 2) / 2) * i stars
 * 
 * To find the nbr of rows we can have we need to solve
 * n + ((n² - 2) / 2) * i < s
 * After combining & simplifing we get:
 * in2 − (i−2)n < 2s
 * In quadratic form (ax²+bx+c=0):
 * in2 − (i−2)n −2s < 0
 * with a = i, b = −(i−2) and c= −2s
 * 
 * https://en.wikipedia.org/wiki/Quadratic_equation
 * We know that n is a positive number so we know that:
 * n = ((i−2) + √((i−2)² + 8it)) / 2i
 */

//Calculate the number nbrRow of row we can create
$nbrRow = (($i - 2) + sqrt((($i - 2) ** 2) + 8 * $i * $s)) / (2 * $i);

if(intval($nbrRow) == $nbrRow) $nbrRow -= 1; //We can't use every single stars, we need at least 1 star at the bottom
else $nbrRow = floor($nbrRow);

//Calculate how many stars are left at the bottom, we need to use BC Math Functions, numbers get too big.
$left = bcsub($s, bcadd($nbrRow, bcmul(bcdiv(bcsub(bcmul($nbrRow, $nbrRow), $nbrRow), 2), $i)));

echo ($nbrRow + $left) . PHP_EOL;

error_log(microtime(1) - $start);
