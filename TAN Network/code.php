<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%s", $startPoint);
fscanf(STDIN, "%s", $endPoint);
fscanf(STDIN, "%d", $N);

for ($i = 0; $i < $N; $i++) {
    $stop = explode(',', stream_get_line(STDIN, 256 + 1, "\n"));

    $unchecked[$stop[0]] = 1; //List of the node we still have to check
    $stops[$stop[0]] = $stop; //We use the UID as index
}

fscanf(STDIN, "%d", $M);

for ($i = 0; $i < $M; $i++) {
    $line = stream_get_line(STDIN, 256 + 1, "\n");

    list($start, $end) = explode(' ', $line);

    //Data are in degrees, formula uses radiant
    $latitudeA = $stops[$start][3] * pi() / 180;
    $latitudeB = $stops[$end][3] * pi() / 180;
    $longitudeA = $stops[$start][4] * pi() / 180;
    $longitudeB = $stops[$end][4] * pi() / 180;

    $x = ($longitudeB - $longitudeA) * cos(($latitudeA + $latitudeB) / 2);
    $y = ($latitudeB - $latitudeA);
    $d = sqrt(pow($x, 2) + pow($y, 2)) * 6371;

    $routes[$start][] = [$end, $d];
}

$waiting[$startPoint] = [0, $startPoint];

//Use Dijkstra
while(count($waiting)) {

    //The next node to work on is the one with the currently smallest distance from start
    uasort($waiting, function($a, $b) {
        return $b[0] <=> $a[0];
    });

    $position = array_key_last($waiting);
    list($distance, $previous) = array_pop($waiting);

    //This node should no longer be checked + save the previous node leading to current node
    unset($unchecked[$position]);
    $stops[$position][9] = $previous;

    //We are at the end node, no need to continue
    if($position == $endPoint) break;
    
    //Check all the stops we can reach from current stop
    foreach($routes[$position] as $destination) {
        list($dName, $dDistance) = $destination;

        //Only consider destination if we still care about that stop
        if(isset($unchecked[$dName])) {
            //This is the first time we reach this stop or we have a smallest distance
            if(!isset($waiting[$dName]) || $waiting[$dName][0] > ($distance + $dDistance)) {
                $waiting[$dName] = [$distance + $dDistance, $position];
            }
        }
    }
}

//We can't reach the end from the start
if(!isset($stops[$endPoint][9])) echo "IMPOSSIBLE\n";
else {
    $current = $endPoint;

    //Create the path from end to start 
    while(true) {
        $output[] = trim($stops[$current][1], '"');

        if($current != $startPoint) $current = $stops[$current][9]; //The previous stop in shortest path
        else break;
    }

    echo implode("\n", array_reverse($output));
}
?>
