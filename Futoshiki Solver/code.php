<?php

fscanf(STDIN, "%d", $size);
for ($i = 0; $i < $size; ++$i) {
    $grid[] = stream_get_line(STDIN, 256 + 1, "\n");
}

$n = ($size + 1) / 2;

error_log(var_export($grid, true));

//Get all the possible values for the positions we have to fill
function getValues(array &$grid, int $size): array {
    $n = ($size + 1) / 2;
    $possibleValues = [];

    for ($y = 0; $y < $size; $y += 2) {
        for ($x = 0; $x < $size; $x += 2) {
            //Number is already given
            if($grid[$y][$x] != 0) continue; 

            $list = [];
            $min = 1;
            $max = $n;
    
            //Relation on right
            if($x < ($size - 2) && $grid[$y][$x + 1] != " ") {
                if($grid[$y][$x + 1] == ">") $min = ($grid[$y][$x + 2] ?: 1) + 1;
                if($grid[$y][$x + 1] == "<") $max = ($grid[$y][$x + 2] ?: $n) - 1;
            } //Relation on left
            if($x > 1 && $grid[$y][$x - 1] != " ") {
                if($grid[$y][$x - 1] == "<") $min = ($grid[$y][$x - 2] ?: 1) + 1;
                if($grid[$y][$x - 1] == ">") $max = ($grid[$y][$x - 2] ?: $n) - 1;
            } //Relation on bottom
            if($y < ($size - 2) && $grid[$y + 1][$x] != " ") {
                if($grid[$y + 1][$x] == "v") $min = ($grid[$y + 2][$x] ?: 1) + 1;
                if($grid[$y + 1][$x] == "^") $max = ($grid[$y + 2][$x] ?: $n) - 1;
            } //Relation on top
            if($y > 1 && $grid[$y - 1][$x] != " ") {
                if($grid[$y - 1][$x] == "^") $min = ($grid[$y - 2][$x] ?: 1) + 1;
                if($grid[$y - 1][$x] == "v") $max = ($grid[$y - 2][$x] ?: $n) - 1;
            }
    
            for($i = $min; $i <= $max; ++$i) $list[$i] = $i;
    
            //Check row & column
            for($k = 0; $k < $size; $k += 2) {
                if($grid[$y][$k] != 0) unset($list[$grid[$y][$k]]);
                if($grid[$k][$x] != 0) unset($list[$grid[$k][$x]]);
            }

            $possibleValues[$y][$x] = $list;  
        }
    }

    return $possibleValues;
}

//Set all the numbers that only have 1 possibility
function setValues(array &$grid, array &$possibleValues, int $size): int {

    $n = ($size + 1) / 2;

    do {
        $valueFound = false;
        $complete = true;

        foreach($possibleValues as $y => $line) {
            foreach($line as $x => $list) {
                $complete = false;

                //Only one possibility for this position, set it
                if(count($list) == 1) {
                    $valueFound = true;

                    $value = array_pop($list);
                    $grid[$y][$x] = $value;

                    //Update the row & column, can't use the same value multiple time
                    for($k = 0; $k < $size; $k += 2) {
                        unset($possibleValues[$y][$k][$value]);
                        unset($possibleValues[$k][$x][$value]);
                    }

                    //Relation on top
                    if($y > 1 && $grid[$y - 1][$x] != " ") {
                        if($grid[$y - 1][$x] == "^") {
                            for($k = $value; $k <= $n; ++$k) unset($possibleValues[$y - 2][$x][$k]);
                        } elseif($grid[$y - 1][$x] == "v") {
                            for($k = 1; $k <= $value; ++$k) unset($possibleValues[$y - 2][$x][$k]);
                        }
                    }
                    //Relation on bottom
                    if($y < ($size - 2) && $grid[$y + 1][$x] != " ") {
                        if($grid[$y + 1][$x] == "v") {
                        for($k = $value; $k <= $n; ++$k) unset($possibleValues[$y + 2][$x][$k]);
                        } elseif($grid[$y + 1][$x] == "^") {
                        for($k = 1; $k <= $value; ++$k) unset($possibleValues[$y + 2][$x][$k]);
                        }
                    }
                    //Relation on left
                    if($x < ($size - 2) && $grid[$y][$x + 1] != " ") {
                        if($grid[$y][$x + 1] == ">") {
                            for($k = $value; $k <= $n; ++$k) unset($possibleValues[$y][$x + 2][$k]); 
                        } elseif($grid[$y][$x + 1] == "<") {
                            for($k = 1; $k <= $value; ++$k) unset($possibleValues[$y][$x + 2][$k]); 
                        }
                    }
                   //Relation on roght
                    if($x > 1 && $grid[$y][$x - 1] != " ") {
                        if($grid[$y][$x - 1] == "<") {
                            for($k = $value; $k <= $n; ++$k) unset($possibleValues[$y][$x - 2][$k]);
                        } elseif($grid[$y][$x - 1] == ">") {
                            for($k = 1; $k <= $value; ++$k) unset($possibleValues[$y][$x - 2][$k]); 
                        }
                    }
                
                    unset($possibleValues[$y][$x]);
                }
            }
        }
    } while($valueFound);

    return $complete ? 1 : 0;    
}

//Get the position of the first missing number
function getGuess(array $possibleValues): array {
    foreach($possibleValues as $y => $line) {
        foreach($line as $x => $list) {
            return [$x, $y, array_pop($list)];
        }
    }
    return [-1, -1, null];
}

//Check if current grid is valid
function checkGrid($grid, $size): bool {
 
    for ($y = 0; $y < $size; $y += 2) {
        for ($x = 0; $x < $size; $x += 2) {
            //Check rows
            if(isset($checkR[$y][$grid[$y][$x]])) return false;
            else $checkR[$y][$grid[$y][$x]] = 1;

            //Check columns
            if(isset($checkC[$x][$grid[$y][$x]])) return false;
            else $checkC[$x][$grid[$y][$x]] = 1;

            //Relation on left
            if($x > 0 && $grid[$y][$x-2] != 0) {
                if($grid[$y][$x-1] == ">" && $grid[$y][$x-2] < $grid[$y][$x]) return false;
                if($grid[$y][$x-1] == "<" && $grid[$y][$x-2] > $grid[$y][$x]) return false;
            } //Relation on right
            if($x < ($size - 2) && $grid[$y][$x+2] != 0) {
                if($grid[$y][$x+1] == ">" && $grid[$y][$x+2] > $grid[$y][$x]) return false;
                if($grid[$y][$x+1] == "<" && $grid[$y][$x+2] < $grid[$y][$x]) return false;
            } //Relation on top
            if($y > 1 && $grid[$y - 2][$x] != 0) {
                if($grid[$y-1][$x] == "^" && $grid[$y-2][$x] > $grid[$y][$x]) return false;
                if($grid[$y-1][$x] == "v" && $grid[$y-2][$x] < $grid[$y][$x]) return false;
            } //Relation on bottom
            if($y < ($size - 2) && $grid[$y + 2][$x] != 0) {
                if($grid[$y+1][$x] == "^" && $grid[$y+2][$x] < $grid[$y][$x]) return false;
                if($grid[$y+1][$x] == "v" && $grid[$y+2][$x] > $grid[$y][$x]) return false;
            }
        }
    }

    return true;
}

$possibleValues = getValues($grid, $size);
$backups = [];

while(true) {

    $result = setValues($grid, $possibleValues, $size);

    //No more numbers missing
    if($result == 1) {
        if(checkGrid($grid, $size)) break;
        else $result = -1;
    }

    //Until we find a guess to test
    while(true) {

        //Invalid grid, reload last backup
        if($result == -1) {
            list($grid, $possibleValues, $x, $y, $value) = array_pop($backups);

            //Remove value that led to invalid grid
            unset($possibleValues[$y][$x][$value]);
        }

        //We have to make a guess
        list($x, $y, $value) = getGuess($possibleValues);

        //No possible guess, invalid grid
        if(!is_int($value)) $result = -1;
        else {
            //We have a guess, backup info
            $backups[] = [$grid, $possibleValues, $x, $y, $value];

            //Set the guess
            $possibleValues[$y][$x] = [$value];
            break;
        }
    }
}

//Display result
for ($y = 0; $y < $size; $y += 2) {
    for ($x = 0; $x < $size; $x += 2) {
        echo $grid[$y][$x];
    }
    echo "\n";
}
?>
