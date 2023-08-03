<?php

$start = microtime(1);

function solve(int $x, int $y, int $length, string $direction): string {

    global $W, $H;

    //Update the position of the light up to the next wall
    switch($direction) {
        case "UR":
            $distance = min($y, $W - $x);
            $x += $distance;
            $y -= $distance;
            break;
        case "DR":
            $distance = min($H - $y, $W - $x);
            $x += $distance;
            $y += $distance;
            break;
        case "UL";
            $distance = min($y, $x);
            $x -= $distance;
            $y -= $distance;
            break;
        case "DL":
            $distance = min($H - $y, $x);
            $x -= $distance;
            $y += $distance;
            break;
    }

    $length += $distance;

    //Check if the light is hitting a corner
    if($x == 0 && $y == 0) return "A $length";
    elseif($x == $W && $y == 0) return "B $length";
    elseif($x == 0 && $y == $H) return "S $length";
    elseif($x == $W && $y == $H) return "C $length";

    //We are hitting the wall on top
    if($y == 0) $direction[0] = "D";

    //We are hitting the wall on bottom
    if($y == $H) $direction[0] = "U";

    //We are hitting the wall on right
    if($x == $W) $direction[1] = "L";

    //We are hitting the wall on left
    if($x == 0) $direction[1] = "R";
    
    return solve($x, $y, $length, $direction);
}

fscanf(STDIN, "%d %d", $H, $W);

echo  solve(0, $H, 0, "UR") . PHP_EOL;

error_log(microtime(1) - $start);
