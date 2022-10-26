<?php

fscanf(STDIN, "%d", $inertia);
fscanf(STDIN, "%d %d", $W, $H);
for ($i = 0; $i < $H; $i++) {
    $coaster[] = stream_get_line(STDIN, 128 + 1, "\n");
}
 
//Find the starting position
for($y = 0; $y < $H; ++$y) {
    if($coaster[$y][0] == "_") {
        $positionX = 0;
        $positionY = $y;
    }
}

$direction = 1; //Initially moving to the left

while(true) {
    //We changed direction
    if($coaster[$positionY][$positionX] == ".") {
        if($positionY > 0 && $coaster[$positionY - 1][$positionX] != ".") $positionY--;
        else $positionY++;
    }

    //Update the inertia based on the type of track
    switch($coaster[$positionY][$positionX]) {
        case "_": --$inertia; break;
        case "\\": $inertia += ($direction == 1 ? 9 : -10); break;
        case "/": $inertia += ($direction == 1 ? -10 : 9); break;
    }

    //We are changing direction
    if($inertia < 0) {
        $direction *= -1; 
        $inertia *= -1;
    }
    
    //No more inertia, we don't move
    if($inertia == 0) {
        //We stopped on an horizontal track, the ride is over
        if($coaster[$positionY][$positionX] == "_") break;
    } //Wagon is moving
    else {
        if($coaster[$positionY][$positionX] == "\\") $positionY = min($H - 1, max(0, $positionY + $direction));
        if($coaster[$positionY][$positionX] == "/") $positionY = min($H - 1, max(0, $positionY - $direction));
        $positionX += $direction;
    }

    //Wagon reached the last track or came back to the first one
    if($positionX == 0 || $positionX == $W - 1) break;
}

echo $positionX . PHP_EOL;
