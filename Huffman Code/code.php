<?php

class MinPriorityQueue extends SplPriorityQueue {

    public function compare($a, $b) {
       return $b <=> $a;
    }
}

fscanf(STDIN, "%d", $n);
$inputs = explode(" ", fgets(STDIN));

$queue = new MinPriorityQueue();
$answer = 0;

foreach($inputs as $i => $input) {
    $queue->insert([intval($input), [$i => 1]], intval($input));
}

while(--$n) {
    //Get the 2 nodes with the lowest weight
    $nodeA = $queue->extract();
    $nodeB = $queue->extract();

    $weight = $nodeA[0] + $nodeB[0];
    $characters = $nodeA[1] + $nodeB[1];

    //Each characters of the 2 nodes gain 1 bit
    foreach($characters as $index => $filler) $answer += $inputs[$index];

    //We insert the merged nodes
    $queue->insert([$weight, $characters], $weight);
}

//If there's only one characters answer is currently 0
echo ($answer ?: $inputs[0]) . PHP_EOL;
