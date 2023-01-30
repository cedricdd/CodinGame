<?php

$lists = [];

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%d", $p);

    $current = 0;
    
    //Find the current highest sequence where we can add the number
    foreach($lists as $number => $count) {
        if($number < $p && $count > $current) $current = $count;
    }
    
    $lists[$p] = max($lists[$p] ?? 0, $current + 1);
}

echo max($lists) . PHP_EOL;
