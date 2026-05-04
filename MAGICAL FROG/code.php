<?php

const MOD = 1000000007;

/**
 * The recurrence is: f(n)=f(n−1)+f(n−2)+...+f(n−K)
 * We know the first K values: f(0),f(1),...,f(K−1)
 * Kitamasa computes a vector: [a0,a1,...,aK−1]
 * such that: f(n) = a0 * f(0) + a1 * f(1) + ... + aK−1 * f(K−1)
 * So instead of computing all terms up to n, we compute how to express f(n) using only the first K terms.
 */
function kitamasa(int $N, array $C, int $K): array {

    # result = polynomial for x^0
    $res = array_fill(0, $K, 0);
    $res[0] = 1;

    # polynomial for x^1
    $base = array_fill(0, $K, 0);
    $base[1] = 1;

    while ($N > 0) {
        if ($N & 1) $res = combine($res, $base, $C, $K);

        $base = combine($base, $base, $C, $K);

        $N >>= 1;
    }

    return $res;
}

function combine(array $A, array $B, array $C, int $K): array {
    //Multiplying degree K by degree K can produce degree up to 2K.
    $tmp = array_fill(0, 2 * $K, 0);

    /**
     * Polynomial multiplication
     * A[i] is coefficient of x^i
     * B[j] is coefficient of x^j
     * => multiplying them contributes to x^i+j
    */
    for ($i = 0; $i < $K; $i++) {
        for ($j = 0; $j < $K; $j++) {
            $tmp[$i + $j] += $A[$i] * $B[$j];
            $tmp[$i + $j] %= MOD;
        }
    }

    /**
     * Reduce degrees >= K
     * Because: x^K = x^(K-1)+x^(K-2)+...+1
     * So if we have: v * x^d where d >= K,
     * we "push" that value down into lower degrees.
     */
    for ($d = 2 * $K - 1; $d >= $K; $d--) {
        if ($tmp[$d] == 0) continue; //Nothing to push down

        $v = $tmp[$d];

        for ($j = 1; $j <= $K; $j++) {
            $tmp[$d - $j] += $v * $C[$K - $j];
            $tmp[$d - $j] %= MOD;
        }
    }

    return array_slice($tmp, 0, $K);
}

fscanf(STDIN, "%d %d", $N, $K);

//STEP 1: Build the first K values
$values = array_fill(0, $K, 0);
$values[0] = 1;
$sum = 1;

for ($i = 1; $i < $K; ++$i) {
    $values[$i] = $sum;
    $sum = ($sum + $values[$i]) % MOD;
}

//Recurrence coefficients, in our case it's always 1
$C = array_fill(0, $K, 1);

error_log(var_export($values, 1));

//STEP 2: Find the Recurrence coefficients
$coef = kitamasa($N, $C, $K);

//STEP 3: We have the K first values and the coefficients, we can calculate the value at N
$answer = 0;

for ($i = 0; $i < $K; $i++) {
    $answer += $coef[$i] * $values[$i];
    $answer %= MOD;
}

echo $answer . PHP_EOL;
