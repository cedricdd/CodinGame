<?php

$start = microtime(1);

$temp = [];
$queue = new SplPriorityQueue ();

fscanf(STDIN, "%d", $k);
fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%d %d", $value, $rate);

    $queue->insert([$value, $rate], $value + floor($value * ($rate / 100)) * 0.00001);
}


$totalCollected = 0.0;

for($i = 0; $i < $k; ++$i) {
    foreach($temp as $j => [$value2, $rate2, &$count]) {
        //We can use this pile again, it has been long enough
        if(++$count == 4) {
            $queue->insert([$value2, $rate2], $value2 + floor($value2 * ($rate2 / 100)) * 0.00001);
            unset($temp[$j]);
        }
    }

    if($queue->isEmpty()) {
        if(count($temp) == 0) break; //Nothing left to collect
        else continue; //We need to wait on replenishment
    }

    [$value, $rate] = $queue->extract();

    $totalCollected += $value;

    if($rate != 0) $temp[] = [floor($value * ($rate / 100)), $rate, 0];
}

echo $totalCollected . PHP_EOL;

error_log(microtime(1) - $start);
