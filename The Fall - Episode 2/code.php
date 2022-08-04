<?php

fscanf(STDIN, "%d %d", $W, $H);
for ($i = 0; $i < $H; $i++) {
    $grid[$i] = explode(' ', stream_get_line(STDIN, 1000 + 1, "\n"));// each line represents a line in the grid and contains W integers T. The absolute value of T specifies the type of the room. If T is negative, the room cannot be rotated.
}
fscanf(STDIN, "%d", $exit);

//Get the new value of a room after a rotation
const TRANSFORMATION = [
    2  => ["LEFT" => 3,  "RIGHT" => 3],
    3  => ["LEFT" => 2,  "RIGHT" => 2],
    4  => ["LEFT" => 5,  "RIGHT" => 5],
    5  => ["LEFT" => 4,  "RIGHT" => 4],
    6  => ["LEFT" => 9,  "RIGHT" => 7],
    7  => ["LEFT" => 6,  "RIGHT" => 8],
    8  => ["LEFT" => 7,  "RIGHT" => 9],
    9  => ["LEFT" => 8,  "RIGHT" => 6],
    10 => ["LEFT" => 13, "RIGHT" => 11],
    11 => ["LEFT" => 10, "RIGHT" => 12],
    12 => ["LEFT" => 11, "RIGHT" => 13],
    13 => ["LEFT" => 12, "RIGHT" => 10],
];

//Get the possible exit from a room based on entering direction
const MOVES = [
    1 => [
        //[x modifier, y modifier, new entry direction, rotation needed, rotation direction]
        "TOP" => [[0, 1, "TOP", 0, ""]],
        "LEFT" => [[0, 1, "TOP", 0, ""]],
        "RIGHT" => [[0, 1, "TOP", 0, ""]],
    ],
    2 => [
        "TOP" => [[0, 1, "TOP", 1, "LEFT"],],
        "LEFT" => [[1, 0, "LEFT", 0, ""]],
        "RIGHT" => [[-1, 0, "RIGHT", 0, ""]],
    ],
    3 => [
        "TOP" => [[0, 1, "TOP", 0, ""]],
        "LEFT" => [[1, 0, "LEFT", 1, "LEFT"]],
        "RIGHT" => [[-1, 0, "RIGHT", 1, "LEFT"]],
    ],
    4 => [
        "TOP" => [[-1, 0, "RIGHT", 0, ""], [1, 0, "LEFT", 1, "RIGHT"]],
        "LEFT" => [[0, 1, "TOP", 1, "RIGHT"]],
        "RIGHT" => [[0, 1, "TOP", 0, ""]],
    ],
    5 => [
        "TOP" => [[-1, 0, "RIGHT", 1, "LEFT"], [1, 0, "LEFT", 0, ""]],
        "LEFT" => [[0, 1, "TOP", 0, ""]],
        "RIGHT" => [[0, 1, "TOP", 1, "LEFT"]],
    ],
    6 => [
        "TOP" => [[0, 1, "TOP", 1, "RIGHT"], [0, 1, "TOP", 1, "LEFT"],],
        "LEFT" => [[1, 0, "LEFT", 0, ""], [0, 1, "TOP", 1, "LEFT"]],
        "RIGHT" => [[-1, 0, "RIGHT", 0, ""], [0, 1, "TOP", 1, "RIGHT"]],
    ],
    7 => [
        "TOP" => [[0, 1, "TOP", 0, ""], [0, 1, "TOP", 2, "LEFT"]],
        "LEFT" => [[1, 0, "LEFT", 1, "LEFT"], [0, 1, "TOP", 1, "RIGHT"]],
        "RIGHT" => [[0, 1, "TOP", 0, ""], [-1, 0, "RIGHT", 1, "LEFT"]],
    ],
    8 => [
        "TOP" => [[0, 1, "TOP", 1, "LEFT"], [0, 1, "TOP", 1, "RIGHT"]],
        "LEFT" => [[0, 1, "TOP", 0, ""], [1, 0, "LEFT", 2, "LEFT"]],
        "RIGHT" => [[0, 1, "TOP", 0, ""], [-1, 0, "RIGHT", 2, "LEFT"]],
    ],
    9 => [
        "TOP" => [[0, 1, "TOP", 0, ""], [0, 1, "TOP", 2, "LEFT"]],
        "LEFT" => [[0, 1, "TOP", 0, ""], [1, 0, "LEFT", 1, "RIGHT"]],
        "RIGHT" => [[0, 1, "TOP", 1, "LEFT"], [-1, 0, "RIGHT", 1, "RIGHT"]],
    ],
    10 => [
        "TOP" => [[-1, 0, "RIGHT", 0, ""], [1, 0, "LEFT", 1, "RIGHT"]],
        "LEFT" => [[0, 1, "TOP", 1, "LEFT"]],
        "RIGHT" => [[0, 1, "TOP", 2, "RIGHT"]],
    ],
    11 => [
        "TOP" => [[1, 0, "LEFT", 0, ""], [-1, 0, "RIGHT", 1, "LEFT"]],
        "LEFT" => [[0, 1, "TOP", 2, "LEFT"]],
        "RIGHT" => [[0, 1, "TOP", 1, "RIGHT"]],
    ],
    12 => [
        "TOP" => [[1, 0, "LEFT", 1, "LEFT"], [-1, 0, "RIGHT", 2, "LEFT"]],
        "LEFT" => [[0, 1, "TOP", 1, "RIGHT"]],
        "RIGHT" => [[0, 1, "TOP", 0, ""]],
    ],
    13 => [
        "TOP" => [[-1, 0, "RIGHT", 1, "RIGHT"], [1, 0, "LEFT", 2, "RIGHT"]],
        "LEFT" => [[0, 1, "TOP", 0, ""]],
        "RIGHT" => [[0, 1, "TOP", 1, "LEFT"]],
    ],
];

//Add the wait instruction in the path, we want the rotation done the latest possible
function formatPath(array $list, array $positions): array {
    
    $path = array_fill(0, count($positions), ["WAIT"]);

    $i = count($positions);
    foreach(array_reverse($list) as [$x, $y, $rotationDirection, $before]) {
        while($i >= $before) --$i;
        $path[$i] = [$x, $y, $rotationDirection];
        --$i;
    }

    return [$path, $positions];
}

//Find all the path for indy to reach the exit
function findPaths(int $x, int $y, string $d): array {
    global $grid, $exit, $W, $H;

    $paths = [];
    $toCheck[] = [$x, $y, $d, 0, [], []];

    while(count($toCheck)) {
        [$x, $y, $entryDirection, $rotationAvailable, $list, $positions] = array_pop($toCheck);

        //Andy is out of the grid - invalid path
        if($x < 0 || $x >= $W || $y >= $H || $grid[$y][$x] == 0) continue;

        //Save indy position
        $positions[] = $x . "-" . $y;

        //Andy reached the exit
        if($x == $exit && $y == $H - 1) {
            $paths[] = formatPath($list, $positions);
            continue;
        }

        $canRotate = $grid[$y][$x] > 0;

        foreach(MOVES[abs($grid[$y][$x])][$entryDirection] as [$xm, $ym, $newDirection, $rotationNeeded, $rotationDirection]) {
            //No rotation needed
            if($rotationNeeded == 0) {
                $toCheck[] = [$x + $xm, $y + $ym, $newDirection, $rotationAvailable + 1, $list, $positions];
            } //We need at least 1 rotation and the room isn't locked
            elseif($canRotate && $rotationAvailable >= $rotationNeeded) {

                $listUpdate = $list;
                foreach(range(1, $rotationNeeded) as $r) $listUpdate[] = [$x, $y, $rotationDirection, count($positions) - 1];

                $toCheck[] = [$x + $xm, $y + $ym, $newDirection, $rotationAvailable - $rotationNeeded + 1, $listUpdate, $positions];
            }
        }
    }

    return $paths;
}

function getNextPosition(array &$grid, int $x, int $y, string $dir): array {
    global $W, $H;

    //Going down
    if(($dir == "TOP" && in_array(abs($grid[$y][$x]), [1, 3, 7, 9]))
    || ($dir == "LEFT" && in_array(abs($grid[$y][$x]), [1, 5, 8, 9, 13]))
    || ($dir == "RIGHT" && in_array(abs($grid[$y][$x]), [1, 4, 7, 8, 12]))) {
        $y++;
        $dir = "TOP";
    } //Going left
    elseif(($dir == "TOP" && in_array(abs($grid[$y][$x]), [4, 10]))
    || ($dir == "RIGHT" && in_array(abs($grid[$y][$x]), [2, 6]))) {
        $x--;
        $dir = "RIGHT";
    } //Rock will go right
    elseif(($dir == "TOP" && in_array(abs($grid[$y][$x]), [5, 11]))
    || ($dir == "LEFT" && in_array(abs($grid[$y][$x]), [2, 6]))) {
        $x++;
        $dir = "LEFT";
    } 

    //Destroyed
    if($x < 0 || $x == $W || $y == $H
    || ($dir == "TOP" && in_array(abs($grid[$y][$x]), [0, 2, 6, 8, 12, 13]))
    || ($dir == "LEFT" && in_array(abs($grid[$y][$x]), [0, 3, 4, 7, 10, 11, 12]))
    || ($dir == "RIGHT" && in_array(abs($grid[$y][$x]), [0, 3, 5, 9, 10, 11, 13]))) {
        return [-1, -1, -1];
    }

    return [$x, $y, $dir];
}

//Check if a rotation would destroy the rock
function getDestroyAction(&$grid, $x, $y, $dir) {
    switch($grid[$y][$x]) {
        case 2:
        case 3:
        case 4:
        case 5:
            return [$x, $y, "LEFT"];
        case 6:
            if($dir == "LEFT") return [$x, $y, "RIGHT"];
            elseif($dir == "RIGHT") return [$x, $y, "LEFT"];
            break;
        case 7:
            if($dir == "TOP") return [$x, $y, "LEFT"];
            break;
        case 8:
            if($dir == "LEFT") return [$x, $y, "LEFT"];
            elseif($dir == "RIGHT") return [$x, $y, "RIGHT"];
            break;
        case 9:
            if($dir == "TOP") return [$x, $y, "RIGHT"];
            break;
        case 10:
            return [$x, $y, "LEFT"];
        case 11:
            return [$x, $y, "RIGHT"]; 
        case 12:
            return [$x, $y, "LEFT"];
        case 13:
            return [$x, $y, "RIGHT"];
    }

    return null;
}

function checkRocks(array $path, array $positions, int $startStep, int $rockID): array {
    global $grid, $rocks;

    //We have checked all the rocks
    if($rockID == count($rocks)) return $path;

    $stepRock = $startStep;
    $gridRock = $grid;
    $destroyActions = [];
    [$x, $y, $dir] = $rocks[$rockID];

    while($stepRock < count($path) - 1) {
        //Update the grid
        if($path[$stepRock][0] !== "WAIT") {
            [$xa, $ya, $ra] = $path[$stepRock];

            $gridRock[$ya][$xa] = TRANSFORMATION[$gridRock[$ya][$xa]][$ra];
        }

        $stepRock++;

        list($x, $y, $dir) = getNextPosition($gridRock, $x, $y, $dir);

        //Rock is out of the grid or it got destroyed
        if($x == -1) {
            return checkRocks($path, $positions, $startStep, $rockID + 1);
        }
        
        //This rock will kill indy, it needs to be destroyed
        if($positions[$stepRock] == $x . "-" . $y) {

            //No solution to destroy this rock
            if(count($destroyActions) == 0) return [];

            //Search for a WAIT a action to replace
            for($i = $startStep; $i < count($path); ++$i) {
                if($path[$i][0] !== "WAIT") continue;

                //Search for a solution to destroy this rock
                foreach($destroyActions as $before => [$x, $y, $rotationDirection]) {
                    //Too late for this
                    if($i > $before) continue;

                    //We found a solution to destroy the rock, check the rest of the rock with this new rotation
                    $path[$i] = [$x, $y, $rotationDirection];

                    $updatedPath = checkRocks($path, $positions, $startStep, $rockID + 1);

                    if(count($updatedPath)) return $updatedPath;

                    //The previous change didn't result in a valid path
                    $path[$i] = ["WAIT"];
                }
            }

            //All the solutions to destroy this rock can't be used
            return [];
        }

        //Try to do a rotation to destroy the rock
        $action = getDestroyAction($gridRock, $x, $y, $dir);

        if($action != null) $destroyActions[$stepRock] = $action;
    }

    //This rock won't hit indy, check next one
    return checkRocks($path, $positions, $startStep, $rockID + 1);
}

$step = 0;
$paths = [];
$visited = [];

// game loop
while (TRUE)
{
    fscanf(STDIN, "%d %d %s", $xi, $yi, $di);

    $start = microtime(true);
    $rocks = [];

    if(count($paths) == 0) {
        $paths = findPaths($xi, $yi, $di);
    }

    // $R: the number of rocks currently in the grid.
    fscanf(STDIN, "%d", $R);

    for ($i = 0; $i < $R; $i++) {
        fscanf(STDIN, "%d %d %s", $xr, $yr, $dr);

        //The rock is on a position indy was before, it can't catch up
        if(isset($visited[$xr . "-" . $yr])) continue;
    
        $rocks[] = [$xr, $yr, $dr];
    }

    //There are at least one rock on the map
    if(count($rocks) > 0) {

        foreach($paths as $key => [$path, $positions]) {

            //Indy is not in the right position to use this path
            if(($positions[$step] ?? "") != "$xi-$yi") continue;

            $updatedPath = checkRocks($path, $positions, $step, 0);

            //We have a valid path (no rock is killing indy)
            if(count($updatedPath)) {
                $path = $updatedPath;
                break;
            } 
        }
    } else {
        //Use the first valid path
        foreach($paths as $key => [$path, $positions]) {
            //Indy is not in the right position to use this path
            if(($positions[$step] ?? "") != "$xi-$yi") continue;

            break;
        }   
    }

    if($path[$step][0] !== "WAIT") {
        [$x, $y, $rotationDirection] = $path[$step];

        //Do the rotation
        echo "$x $y $rotationDirection\n";

        //Update the map
        $grid[$y][$x] = TRANSFORMATION[$grid[$y][$x]][$rotationDirection];
    }
    else echo "WAIT\n";

    ++$step;
    $visited[$xi . "-" .$yi] = 1;

    error_log(var_export("\n" . (microtime(true) - $start), true));
}
?>
