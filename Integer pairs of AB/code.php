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

/**
 * AB / A+B ​= N
 * AB − N(A+B) = 0
 * AB − N(A+B) + N² = N²
 * (A−N) (B−N) = N²
 * 
 * For each couple of integers whose product equal to N² we can create one or two pairs of solution (if the values are the same then we only have one)
 * 
 * If the prime factors of n are n = i1 ^ a . i2 ^ b . i3 ^ c then the number of divisors of N are (a + 1)(b + 1)(c + 1)
 * Since we need the divisors of N² and not N we need to double the expoents, so the number of divisors of N² are (2a + 1)(2b + 1)(2c + 1)
 * The final answer the number of divisor times 2 (because of the negative numbers) - 1 (exclude the invalid solution where the pair (0,0) is generated)
 */
fscanf(STDIN, "%d", $N);

$primes = primeFactors($N);

error_log(var_export($primes, 1));

array_walk($primes, function(&$v) {
    $v = $v * 2 + 1;
});

echo (array_product($primes) * 2 - 1) . PHP_EOL;
