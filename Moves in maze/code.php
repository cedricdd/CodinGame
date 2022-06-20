<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

$steps = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";

fscanf(STDIN, "%d %d", $w, $h);
for ($y = 0; $y < $h; $y++) {
    $map[] = stream_get_line(STDIN, 255 + 1, "\n");

    //Starting postion
    if(($x = strpos($map[$y], 'S')) !== false) {
        $map[$y][$x] = 0;
        $positionToCheck = [[$x, $y]];
    }
}

$step = 1;
while(count($positionToCheck)) {

    $newPositions = [];

    //Check each positions of last step
    foreach($positionToCheck as $position) {
        list($x, $y) = $position;

        //Check the 4 directions move
        foreach([[0, -1], [-1, 0], [0, 1], [1, 0]] as $move) {
            $ux = ($x + $move[0] + $w) % $w;
            $uy = ($y + $move[1] + $h) % $h;

            //Found a cell we haven't visited before
            if($map[$uy][$ux] == ".") {
                $map[$uy][$ux] = $steps[$step];
                $newPositions[] = [$ux, $uy];
            }
        }
    }

    $positionToCheck = $newPositions;
    ++$step;
}

echo implode("\n", $map);
?>
