<?php

fscanf(STDIN, "%d %d", $starty, $startx);
fscanf(STDIN, "%d %d", $endy, $endx);
fscanf(STDIN, "%d %d", $h, $w);
for ($i = 0; $i < $h; $i++) {
    fscanf(STDIN, "%s", $maze[]);
}

error_log(var_export($startx . "-" . $starty, true));
error_log(var_export($endx . "-" . $endy, true));
error_log(var_export($maze, true));

$toCheck = [[$startx, $starty, 0]];
$visisted = [];
$step = 0;

while(true) {

    $newPositions = [];

    foreach($toCheck as $info) {
        list($x, $y, $f) = $info;

        //We reached the end
        if($x == $endx && $y == $endy) break 2;

        //Already visited, skip
        if(isset($visisted[$y][$x][$f])) continue;
        else $visisted[$y][$x][$f] = 1;

        //Vertical slope, can only move vertically
        if($maze[$y][$x] == "|") {
            if($maze[$y + 1][$x] == "+") {
                $newPositions[] = [$x, $y - 1, 0]; //Going down
                $newPositions[] = [$x, $y + 1, 1]; //Going up
            } else {
                $newPositions[] = [$x, $y - 1, 1]; //Going up
                $newPositions[] = [$x, $y + 1, 0]; //Going down
            }
        }//Horizontal slope, can only move horizontally
        elseif($maze[$y][$x] == "-") {
            if($maze[$y][$x - 1] == "+") {
                $newPositions[] = [$x - 1, $y, 1]; //Going up
                $newPositions[] = [$x + 1, $y, 0]; //Going down
            } else {
                $newPositions[] = [$x, $y - 1, 0]; //Going down
                $newPositions[] = [$x, $y + 1, 1]; //Going up
            }
        }
        else {
            //Moving up
            switch($maze[$y - 1][$x]) {
                case ".":
                case "O":
                    if($f == 0) $newPositions[] = [$x, $y - 1, 0]; break;
                case "+":
                    if($f == 1) $newPositions[] = [$x, $y - 1, 1]; break;
                case "X":
                case "|":
                    $newPositions[] = [$x, $y - 1, $f];  break;
            }

            //Moving down
            switch($maze[$y + 1][$x]) {
                case ".":
                case "O":
                    if($f == 0) $newPositions[] = [$x, $y + 1, 0]; break;
                case "+":
                    if($f == 1) $newPositions[] = [$x, $y + 1, 1]; break;
                case "X":
                case "|":
                    $newPositions[] = [$x, $y + 1, $f]; break;
            }

            //Moving left
            switch($maze[$y][$x - 1]) {
                case ".":
                    if($f == 0) $newPositions[] = [$x - 1, $y, 0]; break;
                case "+":
                    if($f == 1 || $maze[$y][$x] == "-") $newPositions[] = [$x - 1, $y, 1]; break;
                case "X":
                case "-":
                    $newPositions[] = [$x - 1, $y, $f]; break;
            }

            //Moving right
            switch($maze[$y][$x + 1]) {
                case ".":
                    if($f == 0) $newPositions[] = [$x + 1, $y, 0]; break;
                case "+":
                    if($f == 1 || $maze[$y][$x] == "-") $newPositions[] = [$x + 1, $y, 1]; break;
                case "X":
                case "-":
                    $newPositions[] = [$x + 1, $y, $f]; break;
            }
        }
    }

    ++$step;
    $toCheck = $newPositions;
}

echo $step;
?>
