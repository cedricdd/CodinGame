<?php

//Get the prime factors of $n and their weight
function primeFactors(int $n): array {
    $factors = [];
    $divisor = 2;

    while ($n >= 2) {
        if ($n % $divisor == 0) {
            $factors[$divisor] = ($factors[$divisor] ?? 0) + 1;
            $n = $n / $divisor;
        } else {
            $divisor++;
        }
    }

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
