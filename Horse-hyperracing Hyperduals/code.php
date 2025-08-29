<?php

function LCG(int $n, int $count, array &$horses) {
    $values = [$n];
    $count *= 2;

    for($i = 1; $i < $count; ++$i) {
        $n = (1103515245 * $n + 12345) % 2147483648;
        $values[] = $n;
    }

    for($i = 0; $i < $count; $i += 2) {
        $horses[] = [$values[$i], $values[$i + 1]];
    }
}

$start = microtime(1);
$horses = [];

fscanf(STDIN, "%d %d %d", $N, $M, $X);

for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d %d", $V, $E);

    $horses[] = [$V, $E];
}

if($M > 0) LCG($X, $M, $horses);

usort($horses, function($a, $b) {
    return $a[0] <=> $b[0];
});

$solution = INF;
$total = $N + $M;

for($i = 0; $i < $total; ++$i) {
    for($j = $i + 1; $j < $total; ++$j) {
        $v = $horses[$j][0] - $horses[$i][0];

        if($solution <= $v) continue 2;

        $v += abs($horses[$j][1] - $horses[$i][1]);

        if($v < $solution) $solution = $v;
    }
}

echo $solution . PHP_EOL;

error_log(microtime(1) - $start);
