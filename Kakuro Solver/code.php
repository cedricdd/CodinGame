<?php

const DIGITS = 511;
const SINGLE_DIGIT = [1 => 1, 2 => 2, 3 => 4, 4 => 8, 5 => 16, 6 => 32, 7 => 64, 8 => 128, 9 => 256];
const REMOVE_DIGIT = [1 => 510, 2 => 509, 3 => 507, 4 => 503, 5 => 495, 6 => 479, 7 => 447, 8 => 383, 9 => 255];

function findSumPermutations(int $sum, int $used, array $cells, array &$results): bool {
    global $maskInfo;

    $index = count($cells) - 1;

    if($index == -1) {
        if($sum == 0) return true;
        else return false;
    }

    $solutionFound = false;
    $mask = array_pop($cells);
    
    foreach($maskInfo[$mask]["digits"] as $digit => $binary) {

        if(($updatedSum = $sum - $digit) < 0) break;

        //If we are not already using this digit
        if(($used & $binary) == 0) {
            
            //Check if we can reach the sum is we use this digit for this cell
            if(findSumPermutations($updatedSum, $used | $binary, $cells, $results)) {
                $solutionFound = true;

                $results[$index] |= $binary;
            }
        }
    }

    return $solutionFound;
}

//For each possible digit mask we generate the count of digits & the list of digits to speed up the code
function generateMaskInfo(int $mask = 0, int $index = 0, array $digits = []) {
    global $maskInfo;

    //We have reach 9 bits, it's over
    if($index == 9) {
        $maskInfo[$mask] = ["count" => count($digits), "digits" => $digits];
        return;
    }

    $binary = 2 ** $index;
    $index += 1;

    generateMaskInfo($mask, $index, $digits); //We set this position as 0

    $digits[$index] = $binary;

    generateMaskInfo($mask + $binary, $index, $digits); //We set this positions as 1
}

function solve(array $grid, array $cells, array $cellToCages, array $cages) {
    global $width, $height, $maskInfo;

    while(true) {
    
        //First check if some cells have a unique value
        do {
            $digitFound = false;
    
            foreach($cells as $index => $filler) {
                switch($cells[$index]) {
                    case 1:   $value = 1; break;
                    case 2:   $value = 2; break;
                    case 4:   $value = 3; break;
                    case 8:   $value = 4; break;
                    case 16:  $value = 5; break;
                    case 32:  $value = 6; break;
                    case 64:  $value = 7; break;
                    case 128: $value = 8; break;
                    case 256: $value = 9; break;
                    case 0: return; //We made an invalid guess
                    default: continue 2;
                }

                //All other cells of the cages this cell belongs too can't use this value
                foreach($cellToCages[$index] as $cageIndex => $filler) {

                    //This was the last cell in the cage
                    if(count($cages[$cageIndex][1]) == 1) {
                        if($cages[$cageIndex][0] != $value) return; //We made an invalid guess
    
                        unset($cages[$cageIndex]);
                        continue;
                    }

                    $cages[$cageIndex][0] -= $value;

                    unset($cages[$cageIndex][1][$index]);
        
                    foreach($cages[$cageIndex][1] as $indexToUpdate => $filler2) {         
                        $cells[$indexToUpdate] &= REMOVE_DIGIT[$value];
                    }
                }

                unset($cells[$index]);
                unset($cellToCages[$index]);
        
                $grid[intdiv($index, $width)][$index % $width] = $value; //Set the digit in the grid
        
                $digitFound = false;
            }

        } while($digitFound);
    
        if(count($cells) == 0) break; //We have found the value of all the cells
    
        $posibilitiesReduced = false;
    
        foreach($cages as $index => [$sum, $list]) {

            $cellsGrouped = [];
    
            //We group the cells in the cage by the digits they can use
            foreach($list as $cellIndex => $filler) {
                $cellsGrouped[$cells[$cellIndex]][$cellIndex] = 1;
            }
    
            //If we have X cells that can use the same X digits, we know none of the other cells in the cage can use any of these X digits
            foreach($cellsGrouped as $mask => $listPositions) {
                if($maskInfo[$mask]["count"] > 1 && $maskInfo[$mask]["count"] == count($listPositions)) {
                    foreach(array_diff_key($list, $listPositions) as $index => $filler) {
                        $cells[$index] &= ~$mask;
                    }
                }
            }

            //Computing all the ways to create the sum becomes slower than making guesses when the number of cells increase
            if(count($list) <= 3) {
                $possibleDigits = [];
                $sumDigits = [];
                $indexInfo = [];
        
                foreach($list as $cellIndex => $filler) {
                    $possibleDigits[$cellIndex] = $cells[$cellIndex];
                    $sumDigits[] = 0;
                    $indexInfo[] = $cellIndex;
                }
    
                findSumPermutations($sum, 0, $possibleDigits, $sumDigits);
    
                foreach($indexInfo as $index => $cellIndex) {
                    if($sumDigits[$index] == 0) return; //We made an invalid guess
    
                    //We have reduced the # of possible digits for this cell
                    if($cells[$cellIndex] != $sumDigits[$index]) {
                        $cells[$cellIndex] = $sumDigits[$index];
        
                        $posibilitiesReduced = true;
                    }
                }
            }
        }
    
        //We need to make a guess
        if($posibilitiesReduced == false) {
            //We are making a guess on the first cell with multiple possibilites
            $cellIndex = array_key_first($cells);

            //Test each values for this cell
            foreach($maskInfo[$cells[$cellIndex]]["digits"] as $value => $binary) {
                $cells[$cellIndex] = $binary;

                solve($grid, $cells, $cellToCages, $cages);
            }
        
            return;
        }
    }

    //Display the complete Kakuro
    echo implode("\n", array_map(function ($line) {
        return implode(",", $line);
    }, $grid)) . PHP_EOL;
}

$start = microtime(1);

fscanf(STDIN, "%d %d", $height, $width);
for ($y = 0; $y < $height; ++$y) {
    $line = array_slice(array_map("trim", explode("|", trim(fgets(STDIN)))), 1, -1);

    foreach($line as $x => $c) {
        if(ctype_digit($c)) $cells[$y * $width + $x] = SINGLE_DIGIT[$c];
        elseif(empty($c)) $cells[$y * $width + $x] = DIGITS;
    }

    $grid[] = $line;
}

generateMaskInfo();

$cellToCages = [];
$cageIndex = 0;
$cages = [];

for($y = 0; $y < $height; ++$y) {
    for($x = 0; $x < $width; ++$x) {
        if(preg_match("/([0-9]*)\\\([0-9]*)/", $grid[$y][$x], $matches)) {
            //Sum of the cells below
            if($matches[1] != '') {
                $cages[$cageIndex][0] = $matches[1];

                for($y2 = $y + 1; $y2 < $height; ++$y2) {
                    if(ctype_digit($grid[$y2][$x]) || empty($grid[$y2][$x])) {
                        $index = $y2 * $width + $x;

                        $cellToCages[$index][$cageIndex] = 1;
                        $cages[$cageIndex][1][$index] = 1;
                    } else break;
                }

                ++$cageIndex;
            }
            //Sum of the cells to the right
            if($matches[2] != '') {
                $cages[$cageIndex][0] = $matches[2];

                for($x2 = $x + 1; $x2 < $width; ++$x2) {
                    if(ctype_digit($grid[$y][$x2]) || empty($grid[$y][$x2])) {
                        $index = $y * $width + $x2;

                        $cellToCages[$index][$cageIndex] = 1;
                        $cages[$cageIndex][1][$index] = 1;
                    } else break;
                }

                ++$cageIndex;
            }
        }
    }
}

solve($grid, $cells, $cellToCages, $cages);

error_log(microtime(1) - $start);
