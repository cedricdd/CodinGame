<?php

$start = microtime(1);

function solve(int $current, int $weightID, int $countBins, array $usage): bool {
    global $binSize, $countWeights, $weights;

    //We have filled a bin
    if($current == $binSize) {
        if(--$countBins == 0) return true; //All the bins are full, we have a valid solution

        $current = 0;
        $weightID = 0;
    }

    for($i = $weightID; $i < $countWeights; ++$i) {
        if($usage[$i]) continue; //We already use this weight

        if(($sum = $current + $weights[$i]) > $binSize) continue; //Not enough space left in the bin
 
        if($current + ($countWeights - $i) * $weights[$i] < $binSize) return false; //Not enough weights left to reach the bin size

        $usage[$i] = 1;

        if(solve($sum, $i + 1, $countBins, $usage)) return true;

        if($current == 0) return false; //This is the first weight we're using in the bin, all the weights need to be used, if we reach this we know we can't have a valid solution.

        $usage[$i] = 0;
    }

    return false;
}

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $info = explode(" ", trim(fgets(STDIN)));

    $weights = array_slice($info, 2);
    rsort($weights);

    $sum = array_sum($weights);

    //The weights can't be divided equally among the bins
    if(array_sum($weights) % $info[0] != 0) {
        echo "no" . PHP_EOL;
        continue;
    }

    $countWeights = count($weights);
    $binSize = $sum / $info[0]; 

    echo (solve(0, 0, $info[0], array_fill(0, $countWeights, 0)) ? "yes" : "no") . PHP_EOL;
}

error_log(microtime(1) - $start);
