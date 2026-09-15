<?php

fscanf(STDIN, "%d", $N);
for ($i = 1; $i <= $N; ++$i) {
    fscanf(STDIN, "%d %d", $D, $P);

    $tasks[$i] = [$i, $D, $P];
}

uasort($tasks, function($a, $b) {
    $va = $a[2] / $a[1];
    $vb = $b[2] / $b[1];

    if($va != $vb) return $vb <=> $va;
    else return $a[0] <=> $b[0];
});

$total = 0;
$days = 0;

foreach($tasks as [, $D, $P]) {
    $days += $D;
    $total += $P * $days;
}

echo implode(" ", array_keys($tasks)) . PHP_EOL . $total . PHP_EOL;
