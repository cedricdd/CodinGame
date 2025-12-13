<?php

const INDEX = [7,6,9,8,11,10,1,0,3,2,5,4];

$tiles = [];
$entrances = [];
$current = 0;
$score = 0;
$x = 0;
$y = -1;

function updateCoordinate(int &$x, int &$y, int $index) {
    switch($index) {
        case 0:
        case 1: --$y; break;
        case 2:
        case 3: --$y; --$x; break;
        case 4:
        case 5: --$x; break;
        case 6:
        case 7: ++$y; break;
        case 8:
        case 9: ++$y; ++$x; break;
        case 10:
        case 11: ++$x; break;
        default: exit("invalid index");
    }
}

// game loop
while (TRUE) {
    for ($i = 0; $i < 6; $i++) {
        fscanf(STDIN, "%d %d", $A, $B);

        $entrances[$x][$y][] = [$A, $B];
    }

    $quadruples = [];
    $inc = 1;

    do {
        $score += $inc++;
        foreach($entrances[$x][$y] as [$i1, $i2]) {
            if($current == $i1 || $current == $i2) {
                $quadruples[] = "$x $y $i1 $i2";

                $current = INDEX[$i1 == $current ? $i2 : $i1];

                break;
            }
        }

        updateCoordinate($x, $y, $current);
    } while(isset($entrances[$x][$y]));

    echo $score . PHP_EOL;
    echo implode(";", $quadruples) . PHP_EOL;
}
