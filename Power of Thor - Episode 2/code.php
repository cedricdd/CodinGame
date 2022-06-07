<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d %d", $TX, $TY);

$defaultMap = array_fill(0, 18, array_fill(0, 40, 1));

//In case of several directions having the same score we want to use a diagonal move first so we declare them first
$directions = [
    [-1, -1, "NW"], [1, -1, "NE"], [-1, 1, "SW"],  [1, 1, "SE"],
    [0, -1, "N"], [0, 1, "S"], [-1, 0, "W"], [1, 0, "E"], 
];

//Get the count of giant that would be destroyed if Thor strikes
function findGiantInRange(&$map, $X, $Y) {
    $count = 0;
    for($y = max(0, $Y - 5); $y <= min(17, $Y + 5); ++$y) {
        for($x = max(0, $X - 5); $x <= min(39, $X + 5); ++$x) {
            if($map[$y][$x] === "G") ++$count;
        }
    }

    return $count;
}

//Find the move Thor should make during the turn
function findMove(&$map, $TX, $TY, $closest, $farthest) {

    global $directions;
    list($cx, $cy) = $closest;
    list($fx, $fy) = $farthest;
    $moves = [];

    foreach($directions as $direction) {
        $ux = $TX + $direction[0];
        $uy = $TY + $direction[1];

        //We would move to a valid cell
        if(($map[$uy][$ux] ?? 0) == 1) {
            //We want to move away from the closest giant
            $score = (abs($ux - $cx) - abs($TX - $cx)) + (abs($uy - $cy) - abs($TY - $cy)) * -1;
            //We want to move toward the farthest giant
            $score += (abs($ux - $fx) - abs($TX - $fx)) + (abs($uy - $fy) - abs($TY - $fy));
            //We want to move loosely toward the center of the map (at least on one axis)
            $score += min((abs($ux - 20) - abs($TX - 20)), (abs($uy - 9) - abs($TY - 9)));
            
            $moves[] = [$ux, $uy, $direction[2], $score];
        } 
    }

    //Order moves by best to worth
    usort($moves, function($a, $b) {
        return  $a[3] <=> $b[3];
    });

    return array_shift($moves);
}

// game loop
while (TRUE)
{
    // $H: the remaining number of hammer strikes.
    // $N: the number of giants which are still present on the map.
    fscanf(STDIN, "%d %d", $H, $N);

    $map = $defaultMap;
    $moves = [];
    $giants = [];

    for ($i = 0; $i < $N; $i++) {
        fscanf(STDIN, "%d %d", $X, $Y);

        $map[$Y][$X] = "G";

        $distance = sqrt(pow($TX - $X, 2) + pow($TY - $Y, 2)); //Distance between Thor and the giant
        $giants[] = [$X, $Y, $distance];

        //Every cell a giant can move to is a not a valid cell for Thor
        for($y = max(0, $Y - 1); $y < min(18, $Y + 2); ++$y) {
            for($x = max(0, $X - 1); $x < min(40, $X + 2); ++$x) {
                if($map[$y][$x] !== "G") $map[$y][$x] = 0;
            }
        }
    }

    //Sort giants by closest to farthest 
    usort($giants, function($a, $b) {
        return $a[2] <=> $b[2];
    });

    $map[$TY][$TX] = "T";
    $giantInReach = findGiantInRange($map, $TX, $TY);

    //There are currently no giants in reach, we just wait for now
    if($giantInReach == 0) {
        echo "WAIT\n";
        continue;
    }

    //We can kill enough giants, we strike
    if($giantInReach >= ($N / $H)) {
        echo "STRIKE\n";
        continue;
    } 

    $move = findMove($map, $TX, $TY, current($giants), end($giants));

    //We have somewhere to move to
    if($move !== null) {
        $TX = $move[0];
        $TY = $move[1];
        echo $move[2] . "\n";
    } //We can't move anywhere, we have to strike
    else {
        echo "STRIKE\n";
    } 
}
?>
