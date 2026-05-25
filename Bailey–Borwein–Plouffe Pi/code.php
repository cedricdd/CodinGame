<?php

fscanf(STDIN, "%d", $N);

$start = microtime(1);

function powmod(int $base, int $exp, int $mod): int {
    if ($exp < 0) return 0;
    $result = 1;
    $base = $base % $mod;
    while ($exp > 0) {
        if ($exp & 1) $result = ($result * $base) % $mod;
        $base = ($base * $base) % $mod;
        $exp >>= 1;
    }
    return $result;
}

function solve(int $n, int $offset): float {
    $sum = 0.0;

    // Finite sum: use fast integer modular exponentiation
    for ($k = 0; $k <= $n; ++$k) {
        $sum += powmod(16, $n - $k, $offset) / $offset;
        $sum = fmod($sum, 1.0); // keep it in [0,1)
        $offset += 8;
    }

    // Infinite tail: 16^(n-k) for k > n is a small fraction,
    $pow = 1.0;
    for ($k = $n + 1; $k < $n + 10; ++$k) {
        $pow /= 16.0;
        $sum += $pow / $offset;
        $offset += 8;
    }

    return fmod($sum, 1.0);
}

//https://en.wikipedia.org/wiki/Bailey%E2%80%93Borwein%E2%80%93Plouffe_formula
function BBP(int $n): int {
    $S1 = 4 * solve($n, 1);
    $S2 = 2 * solve($n, 4);
    $S3 = solve($n, 5);
    $S4 = solve($n, 6);
    $S = fmod($S1 - $S2 - $S3 - $S4, 1.0);

    //Make sure $S is positif
    if($S < 0.0) $S -= floor($S);

    return $S * 16;
}

echo BBP($N - 1) . PHP_EOL;
error_log(microtime(1) - $start);
