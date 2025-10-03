<?php
//Check if a number n is a prime number
function primeCheck($n) {
    if ($n == 1) return 0;
     
    for ($i = 2; $i <= sqrt($n); ++$i){
        if ($n % $i == 0) return 0;
    }

    return 1;
}

//Get the prime factors of $n
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

fscanf(STDIN, "%d",$n);

$factors = primeFactors($n);

//It's a prime number
if(count($factors) == 1) exit("NO");

foreach($factors as $factor => $weight) {
    if(($n - 1) % ($factor - 1) != 0) exit("NO");
}

echo "YES";
