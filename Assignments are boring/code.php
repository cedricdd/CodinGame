<?php

$start = microtime(1);

fscanf(STDIN, "%d", $seed);
fscanf(STDIN, "%d", $paper);
fscanf(STDIN, "%d", $power);

$power = 2 ** $power;
$pages = array_fill(0, $power, 0);

for($i = 0; $i < $paper; ++$i) {
    $count = (1664525 * $seed + 1013904223) % $power;

    $pages[$count]++;

    $seed = $count;
}

foreach(array_filter($pages) as $count) {
    $output[] = $paper -= $count;
}

echo implode(" ", $output) . PHP_EOL;

error_log(microtime(1) - $start);
