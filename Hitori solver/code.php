<?php

$start = microtime(1);

fscanf(STDIN, "%d", $n);

$rows = array_fill(0, $n, array_fill(1, 8, 0));
$cols = array_fill(0, $n, array_fill(1, 8, 0));
$grid = "";

//Get all the neighbors for each positions
for($y = 0; $y < $n; ++$y) {
    for($x = 0; $x < $n; ++$x) {
        $index = $y * $n + $x;

        $neighbors[$index] = [0, []];
        if($x > 0) {
            $neighbors[$index][0] |= 1 << ($index - 1);
            $neighbors[$index][1][] = $index - 1;
        }
        if($x < $n - 1) {
            $neighbors[$index][0] |= 1 << ($index + 1);
            $neighbors[$index][1][] = $index + 1;
        }
        if($y > 0) {
            $neighbors[$index][0] |= 1 << ($index - $n);
            $neighbors[$index][1][] = $index - $n;
        }
        if($y < $n - 1) {
            $neighbors[$index][0] |= 1 << ($index + $n);
            $neighbors[$index][1][] = $index + $n;
        }
    }
}

//Check how many of each digits we have in each rows & cols
for ($y = 0; $y < $n; ++$y) {
    foreach(str_split(trim(fgets(STDIN))) as $x => $digit) {

        $grid .= $digit;
        $rows[$y][$digit]++;
        $cols[$x][$digit]++;
    }
}

//Check if all un-shaded create a single continuous area
function checkFloodFill(string $grid): bool {
    global $neighbors, $n;

    $toCheck = [($grid[0] != "*") ? 0 : 1]; //Shaded can't touch each other, if 0 is then 1 isn't
    $checked = [];

    while(count($toCheck)) {
        $position = array_pop($toCheck);

        if(isset($checked[$position])) continue;
        else $checked[$position] = 1;

        if($grid[$position] == "*") continue;

        foreach($neighbors[$position][1] as $neighbor) {
            $toCheck[] = $neighbor;
        }
    }

    return count($checked) == $n * $n;
}

function solve(int $position, string $grid, array $rows, array $cols, int $forbiddenShade): void {
    global $n, $neighbors;

    for($i = $position; $i < $n * $n; ++$i) {
        
        $digit = $grid[$i];
        $x = $i % $n;
        $y = intdiv($i, $n);

        //Check if this digit needs to shaded
        if($digit != "*" && ($rows[$y][$digit] > 1 || $cols[$x][$digit] > 1)) {

            //If we can shade this position
            if((($forbiddenShade >> $i) & 1) != 1) {
                //We shade it
                $grid[$i] = "*";
                $rows[$y][$digit]--;
                $cols[$x][$digit]--;

                solve($i, $grid, $rows, $cols, ($forbiddenShade | $neighbors[$i][0]));

                //Or we continue without shadding it
                $grid[$i] = $digit;
                $rows[$y][$digit]++;
                $cols[$x][$digit]++;
            }
        } 

        //We are on the last row, check the col for duplicate digits
        if($y == $n - 1 && max($cols[$x]) > 1) return;

        //We finished a row, make sure no digit appears more than once
        if($x == $n - 1 && max($rows[$y]) > 1) return; 
    }

    //We are done shading, make sure the continous area rule is respected
    if(checkFloodFill($grid) == false) return;

    echo implode("\n", str_split($grid, $n)) . PHP_EOL; 
}

solve(0, $grid, $rows, $cols, 0);

error_log(microtime(1) - $start);
