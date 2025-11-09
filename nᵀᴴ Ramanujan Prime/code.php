<?php

function sieveOfEratosthenes(int $limit): array {

    // Initialise the sieve array
    $primes = array_fill(2, $limit - 1, 1);
    $upper = sqrt($limit) + 1;

    for($i = 2; $i < $upper; ++$i) {
        //This number is still in the sieve, remove all it's multiples
        if(isset($primes[$i])) {
            for($j = $i * 2; $j <= $limit; $j += $i) unset($primes[$j]);
        }
    }

    return $primes;
}

fscanf(STDIN, "%d", $n);

$start = microtime(1);

$a = ceil(2 * $n * log(2 * $n));
$b = floor(4 * $n * log(4 * $n));
$primes = sieveOfEratosthenes($b);
$counts = [];
$result = null;
$accumulative = 0; //The number of primes we have seen so far

for($i = $a >> 1; $i <= $b; ++$i) {
    if(isset($primes[$i])) ++$accumulative;
    $counts[$i] = $accumulative;
    
    if($i >= $a) {
        //There are enough primes in (i/2, i], set it as current result if we don't already have one
        if($counts[$i] - $counts[$i >> 1] >= $n) $result = $result ?? $i;
        //There are not enough primes in (i/2, i], remove current result
        else $result = null;
    } 
}

echo $result . PHP_EOL;

error_log(microtime(1) - $start);
