<?php

function cutLink(int $a, int $b): void {
    global $links;

    echo $a . " " . $b . "\n";
    unset($links[$b][$a]);
    unset($links[$a][$b]);
}

fscanf(STDIN, "%d %d %d", $N, $L, $E);

for ($i = 0; $i < $L; $i++) {
    // $N1: N1 and N2 defines a link between these nodes
    fscanf(STDIN, "%d %d", $N1, $N2);

    $links[$N1][$N2] = $N2;
    $links[$N2][$N1] = $N1;
}

for ($i = 0; $i < $E; $i++) {
    // $EI: the index of a gateway node
    fscanf(STDIN, "%d", $gateway);
    $gateways[$gateway] = $gateway;
}

// game loop
while (TRUE) {
    fscanf(STDIN, "%d", $SI);

    $nodes = [];

    foreach ($gateways as $gate) {
        //We have a forced cut, the virus is one move away from a gateway
        if(isset($links[$gate][$SI])) {
            cutLink($gate, $SI);
            continue 2;
        }

        //The number of links to a gateway from a node
        foreach ($links[$gate] as $node) {
            $nodes[$node] = ($nodes[$node] ?? 0) + 1;
        }
    }

    //We want to cut a link between a gateway and a node that is linked to the most gateways
    $max = max($nodes);
    $nodes = array_filter($nodes, function($value) use ($max) {
        return $value == $max;
    });

    $nodesToCheck = [[$SI, 0]];
    $visited = [];

    while(count($nodesToCheck)) {
        $newNodes = [];

        foreach($nodesToCheck as [$node, $count]) {

            ++$count;

            //Check if this node has a direct link to a gateway
            foreach ($gateways as $gate) {
                //When the virus is at this node we have a forced move
                if(isset($links[$gate][$node])) {
                    --$count;
                    break;
                }
            }

            //For all the nodes we can reach from the current node
            foreach ($links[$node] as $destination) {
                //If the destination is a gateway or if we know of a path with less chances to cut we can skip
                if(isset($gateways[$destination]) || (isset($visited[$destination]) && $visited[$destination] <= $count)) continue;

                $visited[$destination] = $count;
                $newNodes[] = [$destination, $count];
                if(isset($nodes[$destination])) $nodes[$destination] = $count;
            }
          
        }

        $nodesToCheck = $newNodes;
    }

    //We can to cut the a link from the node that is the most "dangerous" => the one where we're gonna have the less occasions to cut it
    asort($nodes);

    $nodeDangerous = array_key_first($nodes);

    foreach ($links[$nodeDangerous] as $destination) {
        //We can cut any link between the dangerous node and a gateway
        if(isset($gateways[$destination])) {
            cutLink($nodeDangerous, $destination);
            continue 2;
        }
        
    }
}
