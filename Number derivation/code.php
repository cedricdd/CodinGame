<?php

//Get the prime factors of $n and their weight
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

fscanf(STDIN, "%d", $n);

function solve(int $number): int {

    $primes = primeFactors($number);
    $prime = array_key_first($primes);

    //(p^n)′=n×p^(n−1)
    if(count($primes) == 1) {
        $power = reset($primes);
    
        return $power * pow($prime, ($power - 1));
    } //(n×m)′=n′×m+n×m′.
    else {
        $rest = ($number / $prime);

        return $rest + ($prime * solve($rest));
    }
}

echo solve($n) . PHP_EOL;
