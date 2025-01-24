<?php

$start = microtime(1);

$cooldown = [];
$queue = new SplPriorityQueue ();

fscanf(STDIN, "%d", $k);
fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%d %d", $value, $rate);

    $queue->insert([$value, $rate], $value + floor($value * ($rate / 100)) * 0.00001);
}

$history = [];
$totalCollected = 0.0;

for($i = 0; $i < $k; ++$i) {
    foreach($cooldown as $j => [$value2, $rate2, &$count]) {
        //We can use this pile again, it has been long enough
        if(++$count == 4) {
            $queue->insert([$value2, $rate2], $value2 + floor($value2 * ($rate2 / 100)) * 0.00001);
            unset($cooldown[$j]);
        }
    }

    if($queue->isEmpty()) {
        if(count($cooldown) == 0) break; //Nothing left to collect
        else continue; //We need to wait on replenishment
    }

    [$value, $rate] = $queue->extract();

    /** If there is enough treasures with a replenishment rate of 100 we are going to end in a loop **/
    //We can only have a loop if everything has a rate of 100, reset history
    if($rate != 100) $history = [];
    else {
        //We have found a loop
        if(($size = count($history)) > 3 && reset($history) == $value) {
            $left = $k - $i; //How many treasures we still need to select

            //Add everything in the loop the proper amount of time
            foreach($history as $x => $value) {
                $totalCollected += $value * (intdiv($left, $size) + (($x <= ($left % $size) - 1) ? 1 : 0));
            }

            break; //We are done
        }
    
        $history[] = $value;
    }

    $totalCollected += $value;

    if($rate != 0) $cooldown[] = [floor($value * ($rate / 100)), $rate, 0];
}

echo $totalCollected . PHP_EOL;

error_log(microtime(1) - $start);
