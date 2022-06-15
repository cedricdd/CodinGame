<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

for ($y = 0; $y < 10; $y++) {
    $map[] = stream_get_line(STDIN, 10 + 1, "\n");

    if(($postition = strpos($map[$y], 'C')) != false) $postitions[0] = [[$postition, $y]];
}

error_log(var_export($map, true));

$W = strlen($map[0]);
$H = 10;
$step = 1;

//We do a simple flood fill, as soon as we reach M we're done
while(true) {
    foreach($postitions[$step - 1] as $postition) {
        foreach([[0, -1], [-1, 0], [0, 1], [1, 0]] as $move) {
            $x = $postition[0] + $move[0];
            $y = $postition[1] + $move[1];
    
            //We move inside the map and not in a wall
            if($x >= 0 && $x < $W && $y >= 0 && $y < $H && $map[$y][$x] != "#") {
                if($map[$y][$x] == "M") break 3;

                $map[$y][$x] = "#";
                $postitions[$step][] = [$x, $y];
            }
        }
    }

    ++$step;
}

echo ($step * 10) . "km\n"
