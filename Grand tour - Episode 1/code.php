<?php

$start = microtime(1);

const MOD = 4294967296;

fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d %d %d", $rngseed, $rnga, $rngb);

$rng = [$rngseed];
$speeds = array_fill(1, 99, 0);

for($i = 1; $i <= $N; ++$i) {
    $rng[$i] = ($rng[$i - 1] * $rnga + $rngb) % MOD;
    $speeds[($rng[$i] % 99) + 1]++;
}

$position = 1;
$aggregate = $rngseed;
$speeds = array_reverse(array_filter($speeds), true); //We only want the speeds with some cars, order by fastest

foreach($speeds as $speed => $count) 
    for($i = 0; $i < $count; ++$i)
        $aggregate = ($aggregate * ($position++) + $speed) % MOD;

echo $aggregate . PHP_EOL;

error_log(microtime(1) - $start);
