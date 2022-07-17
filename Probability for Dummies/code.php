<?php

fscanf(STDIN, "%d", $m);
fscanf(STDIN, "%d", $n);

$history = [];
function solve($m, $n, $t) {
    global $history; 

    if(($t + $n) < $m) return 0;
    if($t == $m) return 1;
    if(isset($history[$t][$n])) return $history[$t][$n];

    $p = (38 - $t) / 38; //We get a new number
    $p2 = 1 - $p; //We get a number we already had

    return $history[$t][$n] = $p * solve($m, $n - 1, $t + 1) + $p2 * solve($m, $n - 1, $t);
}

echo round(solve($m, $n, 0) * 100) . "%\n";

/*
$tries = 50000;
$good = 0;

for($i = 0; $i <$tries; ++$i) {

    $numbers = [];
    for($j = 1; $j <= $n; ++$j) {
        $numbers[random_int(0, 37)] = 1;
    }

    if(count($numbers) >= $m) ++$good;
}

echo round(($good / $tries) * 100) . "%";*/
?>
