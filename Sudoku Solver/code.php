<?php

const REMOVE = [1 => 510, 2 => 509, 3 => 507, 4 => 503, 5 => 495, 6 => 479, 7 => 447, 8 => 383, 9 => 255];
const VALUES = [1 => 1, 2 => 2, 3 => 4, 4 => 8, 5 => 16, 6 => 32, 7 => 64, 8 => 128, 9 => 256];

$start = microtime(1);

$grid = "";

for ($i = 0; $i < 9; $i++) {
    $grid .= trim(fgets(STDIN));
}

$toCheck = [];

error_log($grid);

//First step we get all the possibilites for the numbers we have to find
for($y = 0; $y < 9; ++$y) {
    for($x = 0; $x < 9; ++$x) {
        $index = $y * 9 + $x;

        //This number is missing
        if($grid[$index] == 0) {
            $numbers = 511;
            $related = [];

            //Check row & column
            for($i = 0; $i < 9; ++$i) {
                $indexRow = intval($y * 9 + $i);

                if($grid[$indexRow] == 0) $related[$indexRow] = 1;
                else $numbers &= REMOVE[$grid[$indexRow]];

                $indexCol = intval($i * 9 + $x);

                if($grid[$indexCol] == 0) $related[$indexCol] = 1;
                else $numbers &= REMOVE[$grid[$indexCol]];
            }

            //Check the square
            for($y2 = (floor($y / 3) * 3); $y2 < ((floor($y / 3) + 1) * 3); ++$y2) {
                for($x2 = (floor($x / 3) * 3); $x2 < ((floor($x / 3) + 1) * 3); ++$x2) {
                    $indexSquare = intval($y2 * 9 + $x2);

                    if($grid[$indexSquare] == 0) $related[$indexSquare] = 1;
                    else $numbers &= REMOVE[$grid[$indexSquare]];
                }
            }

            unset($related[$index]);

            $possibilities[$index] = $numbers; //We save the possibilites
            $relations[$index] = $related;
            $toFind[$index] = 1;
        }
    }
}


function setNumbers(string &$grid, array &$possibilities, array &$relations, array &$toFind): int {

    //Setting number might leave only 1 possibility for other position
    do {
        $numberFound = false;

        foreach($toFind as $index => $filler) {

            switch($possibilities[$index]) {
                case 1: $value = 1; break;
                case 2: $value = 2; break;
                case 4: $value = 3; break;
                case 8: $value = 4; break;
                case 16: $value = 5; break;
                case 32: $value = 6; break;
                case 64: $value = 7; break;
                case 128: $value = 8; break;
                case 256: $value = 9; break;
                default: continue 2;
            }

            //error_log("setting $index as $value");

            $numberFound = true;

            //Update the grid
            $grid[$index] = $value;

            //We can only use this number once in the row
            foreach($relations[$index] as $indexToCheck => $filler) {
                if(($possibilities[$indexToCheck] &= REMOVE[$value]) == 0) {
                    //error_log("$indexToCheck is now empty");
                    return -1;
                }
            }

            unset($toFind[$index]);
        }
    } while ($numberFound);

    if(count($toFind) == 0) return 1;
    else return 0;
}

//Guess a number for the sudoku
function getGuess(array $toFind, array &$possibilities, array &$fobidden): bool {

    $index = array_key_first($toFind);
    $numbers = $possibilities[$index];

    //error_log("$index -- $numbers");

    foreach(VALUES as $value => $mask) {

        //We already tried, we got an invalid grid
        if(isset($fobidden[$index][$value])) continue; 

        if($numbers & $mask) {
            $fobidden[$index][$value] = 1;
            $possibilities[$index] = $mask;

            //error_log("we can guess $value for $index");
            //exit();
    
            return true;
        }
    }

    //All the possibilites for this position are forbidden, invalid grid
    return false;
}

$backups = [];
$forbidden = [];

//Solve the sudoky
while(true) {

    //We start by setting all the position with only one possibility
    $result = setNumbers($grid, $possibilities, $relations, $toFind);

    if($result == 1) break; //Solution has been found

    //Until we find a guess to test
    while(true) {
        $toCheck = [];

        //error_log("need to guess");

        //Invalid grid, reload last backup
        if($result == -1) {
            [$grid, $possibilities, $relations, $forbidden, $toFind] = array_pop($backups);
        }

        $temp = $possibilities;

        //No possible guess, invalid grid
        if(getGuess($toFind, $possibilities, $forbidden) == false) $result == -1;
        else {
            //error_log("using guess");

            //We have a guess, backup info
            $backups[] = [$grid, $temp, $relations, $forbidden, $toFind];
            break;
        }
    }
}

echo implode("\n", str_split($grid, 9)) . "\n";


error_log(microtime(1) - $start);
