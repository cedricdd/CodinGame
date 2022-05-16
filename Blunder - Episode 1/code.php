<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

 $teleports = [];

fscanf(STDIN, "%d %d", $L, $C);
for ($i = 0; $i < $L; $i++) {
    $line = stream_get_line(STDIN, 101 + 1, "\n");

    if(($startPosition = strpos($line, "@")) !== false) {
        $bender = [$startPosition, $i];
    }
    if(($teleportPosition = strpos($line, "T")) !== false) {
        $teleports[] = [$teleportPosition, $i];
    }

    $grid[] = $line;
}

$directions = [
    0 => ["SOUTH", 0, 1], 
    1 => ["EAST", 1, 0], 
    2 => ["NORTH", 0, -1], 
    3 => ["WEST", -1, 0],
];
$currentDirection = $directions[0];

foreach($grid as $line) error_log(var_export($line, true));

$path = [];
$loop = [];
$breaker = false;

while(true) {
    list($x, $y) = $bender;
    list($name, $dx, $dy) = $currentDirection;

    $ux = $x + $dx;
    $uy = $y + $dy;
    $char = $grid[$uy][$ux];

    //We are breaking the wall
    if($char == "X" && $breaker) {
        $grid[$uy][$ux] = " ";
        $loop = []; //Reset the loop info, map has changed
    } //Path is blocked 
    elseif($char == "#" || $char == "X") {
        //Find the new direction
        foreach($directions as $direction) {
            list($name, $dx, $dy) = $direction;

            $ux = $x + $dx;
            $uy = $y + $dy;
            $char = $grid[$uy][$ux];

            //We can move there
            if($char != "#" && $char != "X") {
                //Check if this case already happened, we are in an inf loop then
                if(isset($loop[$x . "-" . $y . "-" . $breaker])) exit("LOOP");
                else $loop[$x."-".$y."-".$breaker] = 1;

                $currentDirection = $direction;
                break ;
            }
        }
    }

    //We are moving on a modifier
    switch($char) {
        case '$':
            $path[] = $name;
            break 2;
        case 'N': $currentDirection = ["NORTH", 0, -1];
            break;
        case 'S': $currentDirection = ["SOUTH", 0, 1];
            break;
        case 'E': $currentDirection = ["EAST", 1, 0];
            break;
        case 'W': $currentDirection = ["WEST", -1, 0];
            break;
        case 'B': $breaker = !$breaker;
            break;
        case 'I': $directions = array_reverse($directions);
            break;
        case 'T':
            list($t1x, $t1y) = $teleports[0];
            list($t2x, $t2y) = $teleports[1];
    
            if($ux == $t1x && $uy == $t1y) {
                $ux = $t2x;
                $uy = $t2y;
            } else {
                $ux = $t1x;
                $uy = $t1y;
            }
            break;
    }

    $path[] = $name;
    $bender = [$ux, $uy];
}

foreach($path as $direction) echo $direction . "\n";
?>
