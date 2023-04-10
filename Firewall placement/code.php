<?php

fscanf(STDIN, "%d", $numNodes);
fscanf(STDIN, "%d", $virusLocation);
fscanf(STDIN, "%d", $numLinks);
for ($i = 0; $i < $numLinks; $i++){
    [$a, $b] = explode(" ", trim(fgets(STDIN)));
    $links[$a][] = $b;
    $links[$b][] = $a;
}

$best = 0;
$answer = 0;

for($nodeToCut = 0; $nodeToCut < $numNodes; ++$nodeToCut) {
    if($nodeToCut == $virusLocation) continue; //We can't cut the infected node

    $visited = [$nodeToCut => 1]; //We simulate the fact that the node has been cut
    $toCheck= [$virusLocation => 1];

    //Find how many nodes we can still reach from virus position
    while(count($toCheck)) {
        $newCheck = [];

        foreach($toCheck as $node => $filler) {
            if(isset($visited[$node])) continue;
            else $visited[$node] = 1;

            foreach($links[$node] as $neighbor) $newCheck[$neighbor] = 1;
        }

        $toCheck = $newCheck;
    }
    
    if($numNodes - count($visited) > $best) {
        $best = $numNodes - count($visited);
        $answer = $nodeToCut;
    }
}

echo $answer . PHP_EOL;
