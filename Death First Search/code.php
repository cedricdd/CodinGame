<?php

fscanf(STDIN, "%d %d %d", $N, $L, $E);

for ($i = 0; $i < $L; $i++) {
    fscanf(STDIN, "%d %d", $N1, $N2);

    $links[$N1][$N2] = $N2;
    $links[$N2][$N1] = $N1;
}

for ($i = 0; $i < $E; $i++) {
    fscanf(STDIN, "%d", $index);

    $gateways[$index] = 1;
}

// game loop
while (TRUE)
{
    // $SI: The index of the node on which the Bobnet agent is positioned this turn
    fscanf(STDIN, "%d", $SI);

    $visited = [];
    $toCheck = [[$SI, []]]; 

    //Search the shortest path to a gateway
    while(count($toCheck)) {

        $newCheck = [];

        foreach($toCheck as [$position, $list]) {

            $visited[$position] = 1;
            $list[] = $position;

            //We reached a gateway, we know what the shortest path to a gateway is, cut the first link
            if(isset($gateways[$position])) {
                echo $list[0] . " " . $list[1] . PHP_EOL;

                unset($links[$list[0]][$list[1]]); //Link has been cut
                unset($links[$list[1]][$list[0]]); //Link has been cut

                continue 3;
            }

            //Only move to a node if we haven't been there already
            foreach($links[$position] as $destination) {
                if(!isset($visited[$destination])) $newCheck[] = [$destination, $list];
            }
        }

        $toCheck = $newCheck;
    }
}
?>
