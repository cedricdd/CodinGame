<?php

class CustomPriorityQueue extends SplPriorityQueue {

    //When some nodes have the priority, the one with the smaller identifier is considered first.
    public function compare($a, $b) {
       if($a[0] == $b[0]) return $b[1] <=> $a[1];
       else return $b[0] <=> $a[0];
    }
}

fscanf(STDIN, "%d %d %d %d", $N, $E, $S, $G);
$estimations = explode(" ", trim(fgets(STDIN)));

for ($i = 0; $i < $E; $i++) {
    fscanf(STDIN, "%d %d %d", $x, $y, $c);

    $links[$x][] = [$y, $c];
    $links[$y][] = [$x, $c];
}

$expanded = [];

$queue = new \CustomPriorityQueue();
$queue->insert([0, $S], [0, $S]);

while($queue->count()) {
    //Next node to expand
    [$weight, $node] = $queue->extract();

    if(isset($expanded[$node])) continue; //This node was already expended, skipping
    else $expanded[$node] = 1;

    echo $node . " " . ($weight + $estimations[$node]) . PHP_EOL;

    if($node == $G) break; //We reached the goal

    //All the nodes you can reach from the current nodes
    foreach($links[$node] as [$newNode, $cost]) {
        $queue->insert([$weight + $cost, $newNode], [$weight + $cost + $estimations[$newNode], $newNode]);
    }
}
?>
