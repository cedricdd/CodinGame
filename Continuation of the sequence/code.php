<?php

$start = microtime(1);

fscanf(STDIN, "%d", $n);
$inputs = explode(" ", trim(fgets(STDIN)));

$integers = array_fill(0, $n, 0);
$weights = array_fill(0, $n, 0);

$weights[0] = 1;

//On first turn we can find the value of A, on second turn the value of B, ...
for($i = 0; $i < $n; ++$i) {
    $value = $inputs[$i];
    $weightsUpdated = $weights;

    foreach($weights as $j => $m) {
        $value -= $integers[$j] * $m; //We need to substract how many times the other integers are used

        $weightsUpdated[$j] += $weights[$j - 1] ?? 0;//We update the weights for the next turn
    }

    $integers[$i] = $value;
    $weights = $weightsUpdated;
}

$output = 0;

//Now that we know the values of all the integers and the weights of the next turn we can calculate the next element in the sequence
foreach($weights as $i => $m) $output += $integers[$i] * $m;

echo $output . PHP_EOL;

error_log(microtime(1) - $start);
