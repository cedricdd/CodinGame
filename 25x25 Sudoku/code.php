<?php

const REMOVE = ["A" => 33554430, "B" => 33554429, "C" => 33554427, "D" => 33554423, "E" => 33554415, "F" => 33554399, "G" => 33554367, "H" => 33554303, "I" => 33554175, "J" => 33553919, "K" => 33553407, "L" => 33552383, "M" => 33550335, "N" => 33546239, "O" => 33538047, "P" => 33521663, "Q" => 33488895, "R" => 33423359, "S" => 33292287, "T" => 33030143, "U" => 32505855, "V" => 31457279, "W" => 29360127, "X" => 25165823, "Y" => 16777215];
const VALUES = ["A" => 1, "B" => 2, "C" => 4, "D" => 8, "E" => 16, "F" => 32, "G" => 64, "H" => 128, "I" => 256, "J" => 512, "K" => 1024, "L" => 2048, "M" => 4096, "N" => 8192, "O" => 16384, "P" => 32768, "Q" => 65536, "R" => 131072, "S" => 262144, "T" => 524288, "U" => 1048576, "V" => 2097152, "W" => 4194304, "X" => 8388608, "Y" => 16777216];

$start = microtime(1);

$grid = "";

for ($i = 0; $i < 25; $i++) {
    $grid .= trim(fgets(STDIN));
}


$rows = array_fill(0, 25, ["numbers" => array_flip(range("A", "Y")), "positions" => []]);
$columns = array_fill(0, 25, ["numbers" => array_flip(range("A", "Y")), "positions" => []]);
$squares = array_fill(0, 25, ["numbers" => array_flip(range("A", "Y")), "positions" => []]);

$time1 = 0.0;
$time2 = 0.0;

//First step we get all the possibilites for the numbers we have to find
for($y = 0; $y < 25; ++$y) {
    for($x = 0; $x < 25; ++$x) {

        $index = $y * 25 + $x;
        $colIndex = $x;
        $rowIndex = $y;
        $squareIndex = (intdiv($y, 5) * 5) + intdiv($x, 5);
        $squareY = intdiv($squareIndex, 5) * 5;
        $squareX = ($squareIndex % 5) * 5;

        //This number is missing
        if($grid[$index] == ".") {
            $numbers = 33554431;
            $related = [];

            //error_log("$x $y -- $squareX $squareY");

            $squares[$squareIndex]["positions"][$index] = 1;
            $columns[$colIndex]["positions"][$index] = 1;
            $rows[$rowIndex]["positions"][$index] = 1;

            //Check row & column
            for($i = 0; $i < 25; ++$i) {
                $indexRow = intval($y * 25 + $i);

                if($grid[$indexRow] == ".") $related[$indexRow] = 1;
                else $numbers &= REMOVE[$grid[$indexRow]];

                $indexCol = intval($i * 25 + $x);

                if($grid[$indexCol] == ".") $related[$indexCol] = 1;
                else $numbers &= REMOVE[$grid[$indexCol]];
            }

            //Check the square
            for($y2 = $squareY; $y2 < $squareY + 5; ++$y2) {
                for($x2 = $squareX; $x2 < $squareX + 5; ++$x2) {
                    $indexSquare = intval($y2 * 25 + $x2);

                    if($grid[$indexSquare] == ".") $related[$indexSquare] = 1;
                    else $numbers &= REMOVE[$grid[$indexSquare]];
                }
            }

            unset($related[$index]);

            $possibleNumbers[$index] = $numbers; //We save the possibilites
            $positionToFind[$index] = 1; //This position needs to be found

            $infos[$index] = [$colIndex, $rowIndex, $squareIndex, array_keys($related)];
        } else {
            unset($squares[$squareIndex]["numbers"][$grid[$index]]);
            unset($columns[$colIndex]["numbers"][$grid[$index]]);
            unset($rows[$rowIndex]["numbers"][$grid[$index]]);
        }
    }
}

//error_log(var_export($infos[18], true));
//error_log(var_export($squares, true));
//error_log(var_export($infos[3], true));

function setNumbers(string &$grid, array &$possibleNumbers, array &$positionToFind, array &$rows, array &$columns, array &$squares): int {

    global $infos, $time1, $time2;

    $searchBlock = true;

    //Setting number might leave only 1 possibility for other position
    do {
        $numberFound = false;

        $a = microtime(1);

        foreach($positionToFind as $index => $filler) {

            switch($possibleNumbers[$index]) {
                case 1:         $value = "A"; break;
                case 2:         $value = "B"; break;
                case 4:         $value = "C"; break;
                case 8:         $value = "D"; break;
                case 16:        $value = "E"; break;
                case 32:        $value = "F"; break;
                case 64:        $value = "G"; break;
                case 128:       $value = "H"; break;
                case 256:       $value = "I"; break;
                case 512:       $value = "J"; break;
                case 1024:      $value = "K"; break;
                case 2048:      $value = "L"; break;
                case 4096:      $value = "M"; break;
                case 8192:      $value = "N"; break;
                case 16384:     $value = "O"; break;
                case 32768:     $value = "P"; break;
                case 65536:     $value = "Q"; break;
                case 131072:    $value = "R"; break;
                case 262144:    $value = "S"; break;
                case 524288:    $value = "T"; break;
                case 1048576:   $value = "U"; break;
                case 2097152:   $value = "V"; break;
                case 4194304:   $value = "W"; break;
                case 8388608:   $value = "X"; break;
                case 16777216:  $value = "Y"; break;
                default: continue 2;
            }

            $numberFound = true;
            $searchBlock = true;

            [$colIndex, $rowIndex, $squareIndex, $related] = $infos[$index];

            //error_log("setting $index as $value");

            //Update the grid
            $grid[$index] = $value;

            //We can only use this number once in the row/col & square
            foreach($related as $indexToCheck) {
                if(($possibleNumbers[$indexToCheck] &= REMOVE[$value]) == 0) {
                    return -1;
                }
            }

            unset($positionToFind[$index]);

            unset($squares[$squareIndex]["numbers"][$value]);
            unset($squares[$squareIndex]["positions"][$index]);
            unset($columns[$colIndex]["numbers"][$value]);
            unset($columns[$colIndex]["positions"][$index]);
            unset($rows[$rowIndex]["numbers"][$value]);
            unset($rows[$rowIndex]["positions"][$index]);
        }

        $time1 += (microtime(1) - $a);

        if($numberFound == false && $searchBlock) {
            $searchBlock = false;

            $a = microtime(1);

            foreach($squares as $squareIndex => $square) {

                if(!$square["numbers"]) {
                    unset($squares[$squareIndex]);
                    continue;
                }
                
                foreach($square["numbers"] as $number => $filler) {
                    $uniquePosition = null;

                    foreach($square["positions"] as $position => $filler) {
                        if($possibleNumbers[$position] & VALUES[$number]) {
                            if($uniquePosition !== null) continue 2;
                            else $uniquePosition = $position;
                        }
                    }

                    if($uniquePosition === null) return -1;
                    else {
                        //error_log("in square $squareIndex only one pos for $number");
                        //error_log(var_export($possibilities, true));

                        $possibleNumbers[$uniquePosition] = VALUES[$number];
                        $numberFound = true;
                    }
                }
            }

            foreach($columns as $colIndex => $column) {


                if(!$column["numbers"]) {
                    unset($columns[$colIndex]);
                    continue;
                }

                foreach($column["numbers"] as $number => $filler) {
                    $uniquePosition = null;

                    foreach($column["positions"] as $position => $filler) {
                        if($possibleNumbers[$position] & VALUES[$number]) {
                            if($uniquePosition !== null) continue 2;
                            else $uniquePosition = $position;
                        }
                    }

                    if($uniquePosition === null) return -1;
                    else {
                        //error_log("in square $squareIndex only one pos for $number");
                        //error_log(var_export($possibilities, true));

                        $possibleNumbers[$uniquePosition] = VALUES[$number];
                        $numberFound = true;
                    }
                }
            }

            foreach($rows as $rowIndex => $row) {

                if(!$row["numbers"]) {
                    unset($rows[$rowIndex]);
                    continue;
                }
                
                foreach($row["numbers"] as $number => $filler) {
                    $uniquePosition = null;
                    
                    foreach($row["positions"] as $position => $filler) {
                        if($possibleNumbers[$position] & VALUES[$number]) {
                            if($uniquePosition !== null) continue 2;
                            else $uniquePosition = $position;
                        }
                    }

                    if($uniquePosition === null) return -1;
                    else {
                        //error_log("in square $squareIndex only one pos for $number");
                        //error_log(var_export($possibilities, true));

                        $possibleNumbers[$uniquePosition] = VALUES[$number];
                        $numberFound = true;
                    }
                }
            }

            $time2 += (microtime(1) - $a);
        }

    } while ($numberFound);

    if(count($positionToFind) == 0) return 1;
    else return 0;
}

//Guess a number for the sudoku
function getGuess(int $index, array &$possibleNumbers, array &$fobidden): bool {

    $numbers = $possibleNumbers[$index];

    foreach(VALUES as $value => $mask) {

        //We already tried, we got an invalid grid
        if(isset($fobidden[$index][$value])) continue; 

        //This is a possible number for the position
        if($numbers & $mask) {
            $fobidden[$index][$value] = 1;
            $possibleNumbers[$index] = $mask;
    
            return true;
        }
    }

    //All the possibilites for this position are forbidden, invalid grid
    return false;
}

$backups = [];
$forbidden = [];

//Solve the sudoku
while(true) {

    //We start by setting all the positions with only one possibility
    $result = setNumbers($grid, $possibleNumbers, $positionToFind, $rows, $columns, $squares);

    //break;

    if($result == 1) break; //Solution has been found

    //arsort($possibleNumbers);

    //Until we find a guess to test
    while(true) {
        //Invalid grid, reload last backup
        if($result == -1) {
            [$grid, $possibleNumbers, $forbidden, $positionToFind, $rows, $columns, $squares] = array_pop($backups);
        }

        $temp = $possibleNumbers;

        //No possible guess, invalid grid
        if(getGuess(array_key_first($positionToFind), $possibleNumbers, $forbidden) == false) $result == -1;
        else {
            //We have a guess, backup info
            $backups[] = [$grid, $temp, $forbidden, $positionToFind, $rows, $columns, $squares];
            break;
        }
    }
}

//error_log(var_export($squares, true));

echo implode("\n", str_split($grid, 25)) . "\n";

error_log(microtime(1) - $start);
error_log($time1);
error_log($time2);
