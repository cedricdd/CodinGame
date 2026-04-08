<?php

fscanf(STDIN, "%d %d", $capacity, $itemCount);

$dp[0] = 0;
$start = microtime(1);

for ($i = 0; $i < $itemCount; $i++) {
    fscanf(STDIN, "%d %d", $w, $v);

    $current = $dp; //Foreach shouldn't loop over the values added in itself but use $curent just to be 100% safe

    //We check all the capacities we already have with the current $weight/$value
    foreach($current as $weight => $value) {
        $sum = $weight + $w;

        //The goal is to find the best value only for capacity <= $capacity
        if($sum <= $capacity) {
            //Check if using this pair of weight/value produce an higher value
            if(($dp[$sum] ?? -1) < $value + $v) $dp[$sum] = $value + $v;
        }
    }
}

echo ($dp[$capacity] ?? -1) . PHP_EOL;

error_log(microtime(1) - $start);
