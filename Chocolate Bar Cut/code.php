<?php

function gcd(int $a, int $b): int {
    return $b == 0 ? $a : gcd($b, $a % $b);
}

fscanf(STDIN, "%d", $N);

for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d %d", $X, $Y);

    echo ($X + $Y - gcd($X, $Y)) . PHP_EOL;
}
