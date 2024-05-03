<?php

//Get how many person we can add when we have someone at the start and the end with a given size
function solve(int $size) {
    static $history = [];

    if(isset($history[$size])) return $history[$size];

    if($size < 5) return 0; //Not enough space to add more

    $middle = $size >> 1;

    return $history[$size] = 1 + solve($middle + 1) + solve($size - $middle);
}

$start = microtime(1);

fscanf(STDIN, "%d", $n);

$solution = [0, 0];

for($i = 0; $i < $n >> 1; ++$i) {
    $count = 1;

    //We can add people on the left
    if($i >= 2) $count += 1 + solve($i + 1);

    //We can add  people on the right
    if($i < $n - 2) $count += 1 + solve($n - $i);

    //Starting here results in an higher count
    if($count > $solution[0]) $solution = [$count, $i + 1];
}

echo implode(" ", $solution) . PHP_EOL;

error_log(microtime(1) - $start);
