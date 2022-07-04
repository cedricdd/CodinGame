<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d %d", $w, $h);
fscanf(STDIN, "%d %d", $startRow, $startCol);
fscanf(STDIN, "%d", $n);

$paths = [];

for ($i = 0; $i < $n; $i++) {
    $map = [];

    for ($j = 0; $j < $h; $j++) {
        $map[] = stream_get_line(STDIN, $w + 1, "\n");
    }

    error_log(var_export($map, true));

    $count = 0;
    $x = $startCol;
    $y = $startRow;
    
    while(true) {
        $character = $map[$y][$x];
        ++$count;

        //Prevent loops
        $map[$y][$x] = "#";

        switch($character) {
            case "T":
                $paths[$i] = $count;
                break 2;
            case "^": $y--;
                break;
            case "v": ++$y;
                break;
            case "<": --$x;
                break;
            case ">": ++$x;
                break;
            default:
                //Invalid path
                continue 3;
        }

        //Out of the map, invalid path
        if($x < 0 || $x >= $w || $y < 0 || $y >= $h) continue 2;
    }
}

asort($paths);

if(!count($paths)) echo "TRAP";
else echo array_key_first($paths);
?>
