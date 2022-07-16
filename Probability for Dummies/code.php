<?php

fscanf(STDIN, "%d", $m);
fscanf(STDIN, "%d", $n);

/*
Get exact value but times out
function solve($p, $m, $n, $t) {

    if($t + $n < $m) return 0;
    if($t == $m) return $p;

    $p2 = $p * (38 - $t) / 38; //We get a new number
    $p3 = $p * 1 - $p2; //We get a number we already had
    --$n;

    return solve($p2, $m, $n, $t + 1) + solve($p3, $m, $n, $t);
}

echo round(solve(1, $m, $n - 1, 1) * 100) . "%\n";
*/

$tries = 50000;
$good = 0;

for($i = 0; $i <$tries; ++$i) {

    $numbers = [];
    for($j = 1; $j <= $n; ++$j) {
        $numbers[random_int(0, 37)] = 1;
    }

    if(count($numbers) >= $m) ++$good;
}

echo round(($good / $tries) * 100) . "%";
?>
