<?php

function GCD(int $a, int $b): int {
    return $b ? GCD($b, $a % $b) : $a;
}

for ($i = 0; $i < 3; $i++) {
    fscanf(STDIN, "%d %d %d", $x[], $y[], $k[]);
}

/**
 * We want to check if we can solve:
 * x1+n1⋅k1
 * x2+n2⋅k2
 * x3+n3⋅k3
 * Such as x1+n1⋅k1 = x2+n2⋅k2 = x3+n3⋅k3
 * 
 * Which gives us:
 * n1⋅k1−n2⋅k2 = x2−x1 => x2−x1 must be an integer multiple of k1 and k2 => $x2-x1 must be divisible by gcd(k1,k2)
 * n2⋅k2−n3⋅k3 = x3−x2 => x3−x2 must be an integer multiple of k2 and k3 => $x3-x2 must be divisible by gcd(k2,k3)
 * n3⋅k3−n1⋅k1 = x1−x3 => x1−x3 must be an integer multiple of k3 and k1 => $x1-x3 must be divisible by gcd(k3,k1)
 */

$gcd1 = GCD($k[0], $k[1]);
$gcd2 = GCD($k[1], $k[2]);
$gcd3 = GCD($k[2], $k[0]);

if(($x[1] - $x[0]) % $gcd1 == 0 && ($x[2] - $x[1]) % $gcd2 == 0 && ($x[0] - $x[2]) % $gcd3 == 0 && 
    ($y[1] - $y[0]) % $gcd1 == 0 && ($y[2] - $y[1]) % $gcd2 == 0 && ($y[0] - $y[2]) % $gcd3 == 0) echo "Possible" . PHP_EOL;
else echo "Impossible" . PHP_EOL;
