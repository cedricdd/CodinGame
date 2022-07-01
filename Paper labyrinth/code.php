<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d %d", $xs, $ys);
fscanf(STDIN, "%d %d", $xr, $yr);
fscanf(STDIN, "%d %d", $w, $h);
for ($i = 0; $i < $h; $i++) {
    fscanf(STDIN, "%s", $line);
    $map[] = array_map('hexdec', str_split($line));
}

//error_log(var_export($map, true));

function solve($xs, $ys, $xe, $ye) {
    global $map, $w, $h;

    $visited = [];
    $toCheck = [[$xs, $ys, 0]];

    while(count($toCheck)) {
        $newPositions = [];

        foreach($toCheck as $checking) {

            list($x, $y, $step) = $checking;

            //Reached the end
            if($x == $xe && $y == $ye) return $step;
            //Already visited
            if(isset($visited[$y][$x])) continue;
            else $visited[$y][$x] = 1;

            //Possible movements
            if(!($map[$y][$x] & 1)) $newPositions[] = [$x, $y + 1, $step + 1];
            if(!($map[$y][$x] & 2)) $newPositions[] = [$x - 1, $y, $step + 1];
            if(!($map[$y][$x] & 4)) $newPositions[] = [$x, $y - 1, $step + 1];
            if(!($map[$y][$x] & 8)) $newPositions[] = [$x + 1, $y, $step + 1];
        }

        $toCheck = $newPositions;
    }
}

echo solve($xs, $ys, $xr, $yr) . " " . solve($xr, $yr, $xs, $ys);
?>
