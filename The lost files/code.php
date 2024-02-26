<?php

fscanf(STDIN, "%d", $E);
for ($i = 0; $i < $E; $i++) {
    fscanf(STDIN, "%d %d", $n1, $n2);
    
    $links[$n1][$n2] = $n2;
    $links[$n2][$n1] = $n1;
}

$continents = 0;
$tiles = 0;
$nodes = range(0, max(array_keys($links)));

while(count($nodes)) {
    //We are starting to explore a continent at nodeID
    $nodeID = array_pop($nodes);
    $edges = 0;
    $toCheck = [$nodeID];
    $listNodes = [$nodeID => 1];

    while(count($toCheck)) {
        $node1 = array_pop($toCheck);

        foreach($links[$node1] as $node2) {
            ++$edges;

            unset($links[$node2][$node1]); //Don't count the same edge twice

            //We haven't been at this node yet
            if(!isset($listNodes[$node2])) {
                unset($nodes[$node2]);

                $listNodes[$node2] = 1;
                $toCheck[] = $node2;
            }
        }
    }
    
    $continents += 1;
    //We use Euler's formula (|V|-|E|+|F|=2) to find the number of tiles, we need to remove one for the "outside" face
    $tiles += (2 - count($listNodes) + $edges) - 1; 
}

echo $continents . " " . $tiles . PHP_EOL;
