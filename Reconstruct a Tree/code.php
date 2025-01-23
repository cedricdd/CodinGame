<?php

function output(array $links, int $index): string {
    $output = $index;
    
    //This node has some connection
    if(count($links[$index])) {
        ksort($links[$index]); //We need to show them in order

        foreach($links[$index] as $nodeID => $filler) {
            $links2 = $links;
            unset($links2[$nodeID][$index]);

            $output .= " " . output($links2, $nodeID);
        }
    }

    return "(" . $output . ")";
}

$pruferCode = explode(" ", trim(fgets(STDIN)));

$links = [];
//The number of nodes is the number of value in the prufer code + 2
//Initially all the nodes have a degree of 1
$nodes = array_fill(1, count($pruferCode) + 2, 1);

foreach($pruferCode as $nodeID) $nodes[$nodeID]++; //For each number in the Prufer code, increment its degree by 1

foreach($pruferCode as $nodeID1) {
    //Find the node with a count 1 with the smallest ID
    foreach($nodes as $nodeID2 => $count) {
        if($count == 1) break;
    }

    //Connect the current number in prufer code with the node we have just selected
    $links[$nodeID1][$nodeID2] = 1;
    $links[$nodeID2][$nodeID1] = 1;

    unset($nodes[$nodeID2]);
    $nodes[$nodeID1]--; //Decrement the node we have just connected
}

//We have two nodes left, they are linked
$n1 = array_key_first($nodes);
$n2 = array_key_last($nodes);

$links[$n1][$n2] = 1;
$links[$n2][$n1] = 1;

fscanf(STDIN, "%d", $R);

echo output($links, $R) . PHP_EOL;
