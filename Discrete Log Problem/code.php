<?php

bcscale(0); // integer arithmetic only

function egcd(int $a, int $b): array
{
    if ($b === 0) return [$a, 1, 0];
    
    [$g, $x1, $y1] = egcd($b, $a % $b);
    return [$g, $y1, $x1 - intdiv($a, $b) * $y1];
}

function modinv(int $a, int $mod): ?int
{
    [$g, $x, $y] = egcd($a, $mod);
    if ($g !== 1) return null; // inverse does not exist
    
    return ($x % $mod + $mod) % $mod;
}

fscanf(STDIN, "%d %d %d", $G, $H, $Q);

//https://en.wikipedia.org/wiki/Baby-step_giant-step
$m = ceil(sqrt($Q));
$table = [];
$value = 1;

for ($j = 0; $j < $m; $j++) {
        $table[$value] = $j;

        $value = bcmod(bcmul($value, $G), $Q);
    }

// Compute G^{-m} mod Q
$Ginv = modinv($G, $Q);

$factor = bcpowmod($Ginv, $m, $Q);

// Giant steps
$gamma = $H;

for ($i = 0; $i < $m; $i++) {
    if (isset($table[$gamma])) {
        $j = $table[$gamma];
        $X = bcadd(bcmul((string)$i, $m), (string)$j);

        if ($X < $Q) {
            // Verify
            if (bcpowmod($G, $X, $Q) == $H) exit("$X");
        }
    }

    $gamma = bcmod(bcmul($gamma, $factor), $Q);
}
