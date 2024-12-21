<?php

$start = microtime(1);

$total = 0;

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d", $times[]);
}

sort($times);

while($times) {
    $count = count($times);

    if($count == 2) {
        $total += end($times);
        $times = [];
    }
    elseif($count == 3) {
        //We move the fastest and the slowest, then the fastest back, then the last two, in total we use the count of each of the three people
        $total += array_sum($times);

        $times = [];
    } elseif($count == 4) {
        $t4 = array_pop($times);
        $t3 = array_pop($times);
        $t2 = array_pop($times);
        $t1 = array_pop($times);

        /**
         * Choice 1: We move t1 & t2, then t1 back, then t3 & t4, then t2 back, then t1 & t2
         * Choice 2: We move t1 & t4, then t1 back, then t1 & t3, then t1 back, then t1 & t2
         */
        $total += min(3 * $t2 + $t1 + $t4, $t4 + $t1 + $t3 + $t1 + $t2);
    } else {
        //We first move the two fastest (t1 & t2), then move back t1, move the two slowest (t3 & t4) and then move back t2
        $t1 = $times[0];
        $t2 = $times[1];
        $t4 = array_pop($times);
        $t3 = array_pop($times);

        $total += $t2 + $t1 + $t4 + $t2;
    }
}

echo $total . PHP_EOL;

error_log(microtime(1) - $start);
