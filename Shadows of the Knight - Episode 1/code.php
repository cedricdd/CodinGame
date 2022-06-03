<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

// $W: width of the building.
// $H: height of the building.
fscanf(STDIN, "%d %d", $W, $H);
// $N: maximum number of turns before game over.
fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d %d", $X, $Y);

$limits = [[0, 0], [$W - 1, $H - 1]];

// game loop
while (TRUE)
{
    // $bombDir: the direction of the bombs from batman's current location (U, UR, R, DR, D, DL, L or UL)
    fscanf(STDIN, "%s", $bombDir);

    //We need to move to the left
    if(in_array($bombDir, ['DL', 'L', 'UL'])) {
        $limits[1][0] = $X - 1;
    }
     //We need to move to the right
    elseif(in_array($bombDir, ['DR', 'R', 'UR'])) {
        $limits[0][0] = $X + 1;
    }

    //We need to move to the top
    if(in_array($bombDir, ['UL', 'U', 'UR'])) {
        $limits[1][1] = $Y - 1;
    }
     //We need to move to the bottom
    elseif(in_array($bombDir, ['DR', 'D', 'DL'])) {
        $limits[0][1] = $Y + 1;
    }

    $X = ($limits[0][0] + $limits[1][0]) >> 1; //We divide by 2 and take the int part
    $Y = ($limits[0][1] + $limits[1][1]) >> 1;

    // the location of the next window Batman should jump to.
    echo("$X $Y\n");
}
?>
