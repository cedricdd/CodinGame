<?php

function GCD(int $a, int $b): int {
    if ($b == 0 ) return $a;
    
    return GCD($b, $a % $b);
}

fscanf(STDIN, "%d", $N);

$count = 0;
$t = sqrt($N);

/**
 * Euclid's Formula
 * Every primitive Pythagorean triple is produced uniquely by:
 * a = m²-n², b = 2mn, c = m² + n²
 * where the integers satisfy:
 * m > n > 0
 * gcd(m,n)=1
 * m and n have opposite parity (one odd, one even)
 */
for($m = 2; $m <= $t; ++$m) { // m <= sqrt(N)
    for($n = 1; $n < $m; ++$n) { // n < m 
        if(($m + $n) & 1 && GCD($m, $n) == 1) { //Need opposize parity and GCD == 1
            $c = $m * $m + $n * $n;
            if($c <= $N) ++$count;
            else continue 2; //Everything else with this m will be too big
        }
    }
}

echo $count . PHP_EOL;
