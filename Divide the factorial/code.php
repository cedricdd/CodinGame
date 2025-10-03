<?php

//Find the largest porwer of $p that divides $fact! using Legendre’s formula
function findPowerPrime(int $fact, int $p): int { 
    $res = 0; 

    while ($fact > 0) {         
        $res += intval($fact / $p); 
        $fact = intval($fact / $p); 
    } 

    return $res; 
} 

//Return the prime factor decomposition of an integer $n
function primeFactors($n) {
    $factors = [];

    // Handle factor 2 separately
    while ($n % 2 == 0) {
        $factors[2] = ($factors[2] ?? 0) + 1;
        $n = $n / 2;
    }

    // Only check odd divisors up to sqrt(n)
    $divisor = 3;
    $sqrt = sqrt($n);

    while ($divisor <= $sqrt) {
        while ($n % $divisor == 0) {
            $factors[$divisor] = ($factors[$divisor] ?? 0) + 1;
            $n = $n / $divisor;
        }
        $divisor += 2;
    }

    // If n is still > 1, it's prime
    if ($n > 1)  $factors[$n] = 1;

    return $factors;
}

fscanf(STDIN, "%d %d", $A, $B);

$factors = primeFactors($A);

$largestPower = INF;

//https://en.wikipedia.org/wiki/Legendre%27s_formula
foreach($factors as $prime => $exponent) {
$largestPower = min($largestPower, intval(findPowerPrime($B, $prime) / $exponent));
}

echo $largestPower . PHP_EOL;
