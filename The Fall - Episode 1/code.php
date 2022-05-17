<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

// $W: number of columns.
// $H: number of rows.
fscanf(STDIN, "%d %d", $W, $H);
for ($i = 0; $i < $H; $i++)
{
    $grid[$i] = explode(' ', stream_get_line(STDIN, 200 + 1, "\n"));// represents a line in the grid and contains W integers. Each integer represents one room of a given type.
}
// $EX: the coordinate along the X axis of the exit (not useful for this first mission, but must be read).
fscanf(STDIN, "%d", $EX);


// game loop
while (TRUE)
{
    fscanf(STDIN, "%d %d %s", $XI, $YI, $POS);

    switch($grid[$YI][$XI]) {
        case 2:
        case 6:
            if($POS == "LEFT")
                echo(++$XI . " " . $YI . "\n");
            else
                echo(--$XI . " " . $YI . "\n");
            break;
        case 1:
        case 3:
        case 7:
        case 8:
        case 9:
        case 12:
        case 13:
            echo($XI . " " . ++$YI . "\n");
            break;
        case 4:
            if($POS == "TOP")
                echo(--$XI . " " . $YI . "\n");
            else
                echo($XI . " " . ++$YI . "\n");  
            break;
        case 5:
            if($POS == "TOP")
                echo(++$XI . " " . $YI . "\n");
            else
                echo($XI . " " . ++$YI . "\n");  
            break;
        case 10:
            echo(--$XI . " " . $YI . "\n");
            break;
        case 11:
            echo(++$XI . " " . $YI . "\n");
            break;
    }
}
?>
