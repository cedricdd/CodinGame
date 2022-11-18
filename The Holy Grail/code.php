<?php

fscanf(STDIN, "%d %d", $W, $H);

$map = array_fill(0, $H, array_fill(0, $W, 0));
$map[0][0] = 1;
$map[$H - 1][$W - 1] = 1;

for ($i = 1; $i <= 158; $i++) {
    //Read inputs until there are no more new tiles
    if(fscanf(STDIN, "%d %d", $x, $y)) {
        $map[$y][$x] = $i;
    } else break;
}

$toCheck = [[0, 0, 0]];
$visited = [];
$answer = INF;

while(count($toCheck)) {

    $newCheck = [];

    foreach($toCheck as [$x, $y, $count]) {
        //We reached the grail
        if($x == $W - 1 && $y == $H - 1) {
            //Check if this path is available earlier
            $answer = min($count, $answer);
            continue;
        }

        $count = max($count, $map[$y][$x]); //The time we have to wait to have all the tiles of the current path

        if(isset($visited[$y][$x]) && $visited[$y][$x] <= $count) continue;
        else $visited[$y][$x] = $count;

        foreach([[0, 1], [0, -1], [1, 0], [-1, 0]] as [$xm, $ym]) {
            $xu = $x + $xm;
            $yu = $y + $ym;

            //Make sure we are not moving outside of the room or on a tile that never appeared 
            if($xu >= 0 && $xu < $W && $yu >= 0 && $yu < $H && $map[$y][$x] != 0) $newCheck[] = [$xu, $yu, $count];
        }
    }

    $toCheck = $newCheck;
}

echo $answer . PHP_EOL;
