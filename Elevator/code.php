<?php

class MinPriorityQueue extends SplPriorityQueue {

    public function compare($a, $b) {
       return $b <=> $a;
    }
}

$start = microtime(1);

fscanf(STDIN, "%d %d %d %d %d", $n, $a, $b, $k, $m);

$history = [];

$queue = new MinPriorityQueue();
$queue->insert([0, $k], abs($k - $m));

while(true) {
    //If it is impossible to move the elevator to the floor m
    if($queue->isEmpty()) exit("IMPOSSIBLE");

    [$steps, $floor] = $queue->extract();

    //We have already checked this floor
    if(isset($history[$floor])) continue;
    else $history[$floor] = 1;

    if($floor == $m) break; //We reached the target floor
    else ++$steps;

    //We can move UP
    if(($newFloor = $floor + $a) <= $n) $queue->insert([$steps, $newFloor], abs($newFloor - $m));
    //We can move DOWN
    if(($newFloor = $floor - $b) >= 1) $queue->insert([$steps, $newFloor], abs($newFloor - $m));
}

echo $steps . PHP_EOL;

error_log(microtime(1) - $start);
