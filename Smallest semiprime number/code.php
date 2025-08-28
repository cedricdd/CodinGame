<?php

function getPrimes(int $limit): array {
    if ($limit < 2) return [];

    $primes = array_fill(2, $limit + 1, 1);

    $r = (int) floor(sqrt($limit));

    for ($p = 2; $p <= $r; $p++) {
        if (isset($primes[$p])) {
            for ($m = $p * $p; $m <= $limit; $m += $p) {
                unset($primes[$m]);
            }
        }
    }

    return $primes;
}

function checkSemiPrime(int $n) {
    global $primes;

    $max = sqrt($n);

    foreach($primes as $prime => $filler) {
        if($prime > $max) break;
        if(($n % $prime) != 0) continue;

        $coprime = $n / $prime;

        if(isset($primes[$coprime])) exit("$prime $coprime");
    }
}

function permutations(array $digits, string $permutation) {
    if(!$digits) {
        error_log($permutation);
        checkSemiPrime(intval($permutation));
        return;
    }

    foreach($digits as $i => $digit) {
        if(empty($permutation) && $digit == 0) continue;

        $digits2 = $digits;
        unset($digits2[$i]);

        permutations($digits2, $permutation . $digit);
    }
}

$primes = getPrimes(31623); //ceil(sqrt(999999999))

fscanf(STDIN, "%d", $N);

$digits = array_map('intval', explode(" ", fgets(STDIN)));

sort($digits);

permutations($digits, "");

echo "IMPOSSIBLE" . PHP_EOL;
