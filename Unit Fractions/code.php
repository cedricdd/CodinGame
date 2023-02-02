<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $n);

$power = pow($n ,2);

//Get the prime factors of $n and their weight
function primeFactors($n) {
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

$primes = primeFactors($power);

/*
 * Get all the values for the prime based on weight,
 * example prime 3, weight 4
 * 1, 3, 9, 27, 81
 */
foreach($primes as $prime => $weight) {
    foreach(range(0, $weight) as $exp) $factorization[$prime][] = pow($prime, $exp);
}

//Reset indexes
$factorization = array_values($factorization);

//Generate all the divisors of $power
$divisors = $factorization[0];

for($i = 1; $i < count($factorization); ++$i) {
    $tempDivisors = [];
    foreach($factorization[$i] as $value) {
        foreach($divisors as $divisor) {
            $tempDivisors[] = $divisor * $value;
        }
    }

    $divisors = $tempDivisors;
}

//Sort the list by x in descending order.
rsort($divisors);

//x = n+a, y = n+n^2/a where a is a divisosr or n^2
for($i = 0; $i < ceil(count($divisors) / 2); ++$i) {
        echo("1/" . $n . " = 1/" . ($n + $divisors[$i]) . " + 1/" . ($n + $power / $divisors[$i]) . "\n");
}
?>
