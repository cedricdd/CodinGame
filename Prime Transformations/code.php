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

$transformations = [];

fscanf(STDIN, "%d", $X);
fscanf(STDIN, "%d", $C);

for ($i = 0; $i < $C; $i++) {
    fscanf(STDIN, "%d %d", $a, $b);

    $pa = primeFactors($a);
    $pb = primeFactors($b);

    foreach($pa as $prime1 => $exp1) {
        //We already know the transormation for this prime
        if(isset($transformations[$prime1])) {
            unset($pb[$transformations[$prime1]]);

            continue;
        }

        //Find all the primes with the same amount of exponent
        $matches = [];

        foreach($pb as $prime2 => $exp2) {
            if($exp1 == $exp2) {
                $matches[] = $prime2;
            }
        }

        //There's only one possibility
        if(count($matches) == 1) {
            $transformations[$prime1] = $matches[0];

            unset($pb[$matches[0]]);
        }
    }
}

$result = 1;

foreach(primeFactors($X) as $prime => $exponent) {
    $result *= pow($transformations[$prime], $exponent );
}

echo $result . PHP_EOL;
