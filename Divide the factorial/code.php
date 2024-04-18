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
function primeFactors(int $n): array {
    $factors = [];

    while($n % 2 == 0) {
        $factors[2] = ($factors[2] ?? 0) + 1;
        $n /= 2;
    }
 
    for ($i = 3; $i <= sqrt($n); $i += 2) {
        while ($n % $i == 0) {
            $factors[$i] = ($factors[$i] ?? 0) + 1;
            $n /= $i;
        }
    }

    if($n > 2) $factors[$n] = 1;

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
