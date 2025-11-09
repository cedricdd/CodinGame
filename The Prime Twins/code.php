<?php

//https://en.wikipedia.org/wiki/Sieve_of_Eratosthenes
function sieveOfEratosthenes(int $limit): array {

    // Initialise the sieve array
    $sieve = array_fill(2, $limit - 1, 1);
    $upper = sqrt($limit) + 1;

    for($i = 2; $i < $upper; ++$i) {
        //This number is still in the sieve, remove all it's multiples
        if(isset($sieve[$i])) {
            for($j = $i * 2; $j < $limit; $j += $i) unset($sieve[$j]);
        }
    }

    return array_keys($sieve);
}

$start = microtime(1);

fscanf(STDIN, "%d", $n);

$primes = sieveOfEratosthenes(100200);
$count = count($primes);

for($i = 0; $i < $count; ++$i) {
    if($primes[$i] > $n && $primes[$i + 1] == $primes[$i] + 2) break;
}

echo $primes[$i] . " " . $primes[$i + 1] . PHP_EOL;

error_log(microtime(1) - $start);
