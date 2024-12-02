<?php

$start = microtime(1);

fscanf(STDIN, "%d %d %d", $N, $K, $T);
fscanf(STDIN, "%f %d", $p, $l);

for ($i = 1; $i <= $K; $i++) {
    $jumps[$i] = explode(" ", trim(fgets(STDIN)));
    $counts[$i] = count($jumps[$i]);
}

$odds = [1 => 1.0];

//We just simulate each turn where the squirrel can be
for($i = 0; $i < $T; ++$i) {
    $newOdds = array_fill(1, $K, 0.0);

    foreach($odds as $id => $percentage) {
        $newOdds[$id] += $percentage * $p; //Case where the squirrel stays where it is

        //Case the squirrel is jumping
        foreach($jumps[$id] as $jumpID) $newOdds[$jumpID] += $percentage * ((1.0 - $p) / $counts[$id]);
    }

    $odds = $newOdds;
}

echo $N * $odds[$l] . PHP_EOL;

error_log(microtime(1) - $start);
