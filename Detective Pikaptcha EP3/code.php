<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d %d", $width, $height);
for ($i = 0; $i < $height; $i++) {
    fscanf(STDIN, "%s", $line);
    $map[] = str_split($line);

    if(preg_match("/([<>^v])/", $line, $match)) {
        $sx = $px = strpos($line, $match[0]);
        $sy = $py = $i;

        switch($match[0]) {
            case "<": $direction = "LEFT"; break;
            case ">": $direction = "RIGHT"; break;
            case "^": $direction = "UP"; break;
            case "v": $direction = "DOWN"; break;
        }
    }
}
fscanf(STDIN, "%s", $side);

for ($i = 0; $i < $height; $i++) {
    error_log(var_export(implode("", $map[$i]), true));
}

//Replace starting postion
$map[$py][$px] = 0;

function getNewPosition($x, $y, $values) {
    global $width, $height;

    $y += $values[0];

    /*
     * If we are on the left side of the map (< center) we will end up on the right side,
     * the offset we had from the start of the map is now applied from the center.
     * If we are on the right side of the map (>= center) we will end up on the left side,
     * the offset we had from the center is now applied from the start.
     */
    if($y == -1 || $y == $height) {
        $center = ($width / 2);

        if($x >= $center) $x -= $center;
        else $x += $center;

        $y = ($y + $height) % $height;
    }
 
    //Easy case we just end up on the other side
    $x = ($x + $width + $values[1]) % $width; //We add $width to never get negative values

    return [$x, $y];
}


if($side == "L") {
    $directions = [
        "RIGHT" => ["UP" => [-1, 0], "RIGHT" => [0, 1], "DOWN" => [1, 0], "LEFT" => [0, -1]],
        "UP" => ["LEFT" => [0, -1], "UP" => [-1, 0], "RIGHT" => [0, 1], "DOWN" => [1, 0]],
        "LEFT" => ["DOWN" => [1, 0], "LEFT" => [0, -1], "UP" => [-1, 0], "RIGHT" => [0, 1]],
        "DOWN" => ["RIGHT" => [0, 1], "DOWN" => [1, 0], "LEFT" => [0, -1], "UP" => [-1, 0]],
    ];
} else {
    $directions = [
        "RIGHT" => ["DOWN" => [1, 0], "RIGHT" => [0, 1], "UP" => [-1, 0], "LEFT" => [0, -1]],
        "UP" => ["RIGHT" => [0, 1], "UP" => [-1, 0], "LEFT" => [0, -1], "DOWN" => [1, 0]],
        "LEFT" => ["UP" => [-1, 0], "LEFT" => [0, -1], "DOWN" => [1, 0], "RIGHT" => [0, 1]],
        "DOWN" => ["LEFT" => [0, -1], "DOWN" => [1, 0], "RIGHT" => [0, 1], "UP" => [-1, 0]],
    ];
}

//Check if we can't move at all
$blocked = 0;

foreach([[0, 1], [0, -1], [1, 0], [-1, 0]] as $values) {
    list($ux, $uy) = getNewPosition($px, $py, $values);

    if(($map[$uy][$ux]) === "#") ++$blocked;
}

if($blocked != 4) {

    while(true) {

        //Find the new direction to take
        foreach($directions[$direction] as $newDirection => $values) {

            list($ux, $uy) = getNewPosition($px, $py, $values);

            //The first available path
            if(($map[$uy][$ux]) !== "#") {
                $direction = $newDirection;
                $py = $uy;
                $px = $ux;
                break;
            }
        }

        $map[$py][$px]++;
   
        //Back at the start
        if($px == $sx && $py == $sy) break;
    }

}

for ($i = 0; $i < $height; $i++) {
    echo implode("", $map[$i]) . "\n";
}
?>
