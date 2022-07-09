<?php

fscanf(STDIN, "%d", $n);

$rows = array_fill(0, $n, [0, 0, ""]);
$cols = array_fill(0, $n, [0, 0, ""]);
$toFind = 0;

for ($y = 0; $y < $n; ++$y) {
    $line = stream_get_line(STDIN, 40 + 1, "\n");

    foreach(str_split($line) as $x => $c) {
        if($c === "1") {
            $rows[$y][1]++;
            $cols[$x][1]++;
        } elseif($c === "0") {
            $rows[$y][0]++;
            $cols[$x][0]++;
        } else $toFind++;

        $rows[$y][2] .= $c;
        $cols[$x][2] .= $c;
    }

    $grid[] = $line;
}

error_log(var_export($grid, true));
//error_log(var_export($rows, true));
//error_log(var_export($cols, true));

function setValues(&$grid, &$rows, &$cols, &$toFind, $n) {

    do {
        $valueFound = false;

        for ($y = 0; $y < $n; ++$y) {
            for ($x = 0; $x < $n; ++$x) {
                if($grid[$y][$x] != ".") continue;
        
                //error_log(var_export($x ." " . $y, true));
                
                $value = -1;
        
                //We have already set all the 0 on the row or column, it's a 1
                if($rows[$y][0] == ($n / 2) || $cols[$x][0] == ($n / 2)) {
                    $value = 1;
                } //We have already set all the 1 on the row or column, it's a 0
                elseif($rows[$y][1] == ($n / 2) || $cols[$x][1] == ($n / 2)) {
                    $value = 0;
                } //Two similar digit on the left
                elseif($x > 1 && $grid[$y][$x-1] != "." && $grid[$y][$x-1] == $grid[$y][$x-2]) {
                    $value = ($grid[$y][$x-1] + 1) % 2;
                } //Surrounded by two similar digit on row
                elseif($x > 0 && $x < ($n - 1) && $grid[$y][$x-1] != "." && $grid[$y][$x-1] == $grid[$y][$x+1]) {
                    $value = ($grid[$y][$x-1] + 1) % 2;
                } //Two similar digit on the right
                elseif($x < ($n - 2) && $grid[$y][$x+1] != "." && $grid[$y][$x+1] == $grid[$y][$x+2]) {
                    $value = ($grid[$y][$x+1] + 1) % 2;
                } //Two similar digit on the top
                elseif($y > 1 && $grid[$y-1][$x] != "." && $grid[$y-1][$x] == $grid[$y-2][$x]) {
                    $value = ($grid[$y-1][$x] + 1) % 2;
                } //Surrounded by two similar digit on column
                elseif($y > 0 && $y < ($n - 1) && $grid[$y-1][$x] != "." && $grid[$y-1][$x] == $grid[$y+1][$x]) {
                    $value = ($grid[$y-1][$x] + 1) % 2;
                } //Two similar digit on the bottom
                elseif($y < ($n - 2) && $grid[$y+1][$x] != "." && $grid[$y+1][$x] == $grid[$y+2][$x]) {
                    $value = ($grid[$y+1][$x] + 1) % 2;
                }
    
                //We have found a value
                if($value != -1) {
                    $grid[$y][$x] = $value;
                    $rows[$y][$value]++;
                    $cols[$x][$value]++;

                    //We need an equal number of 1s and 0s => current grid is invalid
                    if($rows[$y][$value] > ($n / 2) || $cols[$x][$value] > ($n / 2)) return -1;

                    $valueFound = true;
                    --$toFind;
                }
            }
        }

    } while($valueFound);

    if($toFind == 0) return 1;
    else return 0;
}

//Get the position of the first missing number
function getGuess($grid, $n) {
    for ($y = 0; $y < $n; ++$y) {
        for ($x = 0; $x < $n; ++$x) {
            if($grid[$y][$x] == ".") return [$x, $y];
        }
    }
    return [-1, -1];
}

//Flip an array diagonally 
function flipDiagonally($arr) {
    $out = array();
    foreach ($arr as $key => $subarr) {
        foreach (str_split($subarr) as $subkey => $subvalue) {
            $out[$subkey] = ($out[$subkey] ?? "") . $subvalue;
        }
    }
    return $out;
}

//Check if current grid valid
function checkGrid($grid, $n) {
    $checkR = [];
    for ($y = 0; $y < $n; ++$y) {
        //No identical rows
        if(isset($checkR[$grid[$y]])) return false;
        else $checkR[$grid[$y]] = 1;

        //No more than two of either number adjacent to each other
        if(strpos($grid[$y], "111") !== false || strpos($grid[$y], "000") !== false) return false;
    }

    $grid = flipDiagonally($grid);

    $checkC = [];
    for ($x = 0; $x < $n; ++$x) {
        //No identical columns
        if(isset($checkC[$grid[$x]])) return false;
        else $checkC[$grid[$x]] = 1;

        //No more than two of either number adjacent to each other
        if(strpos($grid[$x], "111") !== false || strpos($grid[$x], "000") !== false) return false;
    }

    return true;
}

$backups = [];

while(true) {
    
    //Set all the values that are certain
    $result = setValues($grid, $rows, $cols, $toFind, $n);

    //We have set all the missing values
    if($result == 1) {
        //We found the solution
        if(checkGrid($grid, $n)) break;
        //Invalid grid
        else $result = -1;
    }

    //Until we find a guess to test
    while(true) {
        //Invalid grid, reload last backup
        if($result == -1) {
            list($grid, $cols, $rows, $toFind, $x, $y) = array_pop($backups);

            //It can only be 0 or 1, since it can't be 0 it's 1
            $grid[$y][$x] = 1;
            $cols[$x][1]++;
            $rows[$y][1]++;
        }

        //We have to make a guess
        list($x, $y) = getGuess($grid, $n);

        //No possible guess, invalid grid
        if($x == -1 && $y == -1) $result == -1;
        else {
            --$toFind;

            //We have a guess, backup info
            $backups[] = [$grid, $cols, $rows, $toFind, $x, $y];

            //Set the guess
            $grid[$y][$x] = 0;
            $cols[$x][0]++;
            $rows[$y][0]++;
            break;
        }
    }
}

echo implode("\n", $grid);
?>
