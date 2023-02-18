<?php

const NUMBERS = 511;
const NUMBERS_BIN = [1 => 1, 2 => 2, 3 => 4, 4 => 8, 5 => 16, 6 => 32, 7 => 64, 8 => 128, 9 => 256];

$memory = [];
$guess = 0;
$check = 0;

//Find all the digits that are used in a way to reach $sum by using $count different digits
//We can't use the same digit multiple times, the digit we can use are given by checking the bits of $numbers
function findSumPermutations(int $sum, int $count, int $numbers): int {

    global $memory;

    if(isset($memory[$sum][$count][$numbers])) return $memory[$sum][$count][$numbers];

    //Sum is too big, we reached the max # of digits or we used all the possible digits
    if($sum < 0 || $count == 0 || $numbers == 0) return 0;

    foreach(NUMBERS_BIN as $value => $binary) {

        //If this digit can be used
        if($numbers & $binary) {

            if($count == 1 && $sum == $value) return $memory[$sum][$count][$numbers] = $binary;

            //Case where we don't use the current digit
            $result = findSumPermutations($sum, $count, $numbers & ~$binary);

            //If by using the current digit there's a way to reach the sum
            if($solution = findSumPermutations($sum - $value, $count - 1, $numbers & ~$binary)) {
                $result |= $solution; //All digits we used in the recursion are part of the solution
                $result |= $binary; //The current digit is part of the solution
            }

            return $memory[$sum][$count][$numbers] = $result;
        }
    } 

    return $memory[$sum][$count][$numbers] = 0;
}

//Get the all the positions in the grid that are affected when we set a number
//Positions in the same row, col or region
function generateAffectedPositions(): array {
    $affected = [];

    for($y = 0; $y < 9; ++$y) {
        for($x = 0; $x < 9; ++$x) {
            $index = $y * 9 + $x;

            for($i = 0; $i < 9; ++$i) {
                //The position on the same row
                $affected[$index][$i * 9 + $x] = 1;
                //The position on the same col
                $affected[$index][$y * 9 + $i] = 1;
            }
        
            //The positions in the same region
            for($y2 = (floor($y / 3) * 3); $y2 < ((floor($y / 3) + 1) * 3); ++$y2) {
                for($x2 = (floor($x / 3) * 3); $x2 < ((floor($x / 3) + 1) * 3); ++$x2) {
                    $affected[$index][intval($y2 * 9 + $x2)] = 1;
                }
            }

            unset($affected[$index][$index]); //No need to update yourself
        }
    }

    return $affected;
}

function solve(string $grid, array $possibleDigits, array $cages, array $positionsToFind): void {
    global $cagesMatch, $affectedPositions, $answer, $guess, $check;

    do {
        $numberFound = false;

        foreach($positionsToFind as $index => $filler) {

            ++$check;

            //There is only only possible digit for this position
            switch($possibleDigits[$index]) {
                case 1:   $value = 1; break;
                case 2:   $value = 2; break;
                case 4:   $value = 3; break;
                case 8:   $value = 4; break;
                case 16:  $value = 5; break;
                case 32:  $value = 6; break;
                case 64:  $value = 7; break;
                case 128: $value = 8; break;
                case 256: $value = 9; break;
                default: $value = 0;
            }

            if($value == 0) continue; //Several numbers are still possible for this position

            $grid[$index] = $value; //Save the digit we used

            unset($positionsToFind[$index]);

            //Update all the possitions where this digit can no longer be used
            foreach($affectedPositions[$index] as $position => $filler) {
                if(($possibleDigits[$position] &= ~NUMBERS_BIN[$value]) == 0) return;
            }

            //Update all the cages that this position is part of
            foreach($cagesMatch[$index] as $cageIndex) {

                //This was the last position to find in the region
                if(--$cages[$cageIndex][1] == 0) {
                    if($value != $cages[$cageIndex][0]) return; //Sum of the cage doesn't match, invalid grid
                    else {
                        unset($cages[$cageIndex]); //Nothing left to do with this cage
                        continue;
                    }
                }

                $cages[$cageIndex][0] -= $value; //The new sum left
                unset($cages[$cageIndex][2][$index]); //This position has been set

                //We get all the digits that can still be used in the cage
                $digits = 0;
                foreach($cages[$cageIndex][2] as $cagePosition => $filler) $digits |= $possibleDigits[$cagePosition];

                $digitsSum = findSumPermutations($cages[$cageIndex][0], $cages[$cageIndex][1], $digits);

                //Update all the positions left in the cage
                foreach($cages[$cageIndex][2] as $cagePosition => $filler) {
                    //If one position is set to 0, the grid is invalid
                    if(($possibleDigits[$cagePosition] &= $digitsSum) == 0) return;
                }  
            }

            $numberFound = true;
        }

    } while($numberFound); //Restart the loop as long as some digit has been found

    //There are some positions with multiple possibilities
    if(count($positionsToFind) > 0) {

        $position = array_key_last($positionsToFind);
        $numbers = $possibleDigits[$position];

        //Test each values for this position
        foreach(NUMBERS_BIN as $value => $binary) {
            if(($numbers & $binary) != 0) {
                $possibleDigits[$position] = $binary;

                ++$guess;

                solve($grid, $possibleDigits, $cages, $positionsToFind);
            } 
        }

        return;
    } 

    //We have found the solution, add it to the answer
    for($y = 0; $y < 9; ++$y) {
        for($x = 0; $x < 9; ++$x) {
            $answer[$y][$x] += $grid[$y * 9 + $x];
        }
    }
}

$startTime = microtime(1);
$answer = array_fill(0, 9, array_fill(0, 9, 0));

fscanf(STDIN, "%d", $numPuzzles);

for($i = 0; $i < $numPuzzles; ++$i) {
    $grids[] = trim(fgets(STDIN));
}
for($i = 0; $i < $numPuzzles; ++$i) {
    $cageValues[] = trim(fgets(STDIN));
}

$affected = generateAffectedPositions();

for($gridID = 0; $gridID < $numPuzzles; ++$gridID) {
    $affectedPositions = $affected;
    $possibleDigits = array_fill(0, 81, NUMBERS);
    $grid = str_repeat("0", 81);
    $positionsToFind = range(0, 80);
    $cagesPositions = [];
    $cagesMatch = [];
    $cages = [];
    $cagesSum = [];
    $cageIndex = 0;
    $gridTime = microtime(1);

    //error_log(var_export(str_split($grids[$gridID], 9), true));

    //Get all the positions in each cages
    for($position = 0; $position < 81; ++$position) {
        $cagesPositions[$grids[$gridID][$position]][] = $position;
    }

    //Get the sum of each cages
    foreach(explode(" ", $cageValues[$gridID]) as $values) {
        [$name, $sum] = explode("=", $values);
    
        $cagesSum[$name] = $sum;
    }

    foreach($cagesSum as $name => $sum) {

        $list = $cagesPositions[$name];
        $size = count($list);
        
        //Add the other positions in the cage to the affected positions
        for($i = 0; $i < $size; ++$i) {
            for($j = $i + 1; $j < $size; ++$j) {
                $affectedPositions[$list[$i]][$list[$j]] = 1;
                $affectedPositions[$list[$j]][$list[$i]] = 1;
            }
        }

        //Save that the position is inside this cage
        foreach($list as $position) {
            $cagesMatch[$position][] = $cageIndex;
        }

        //Create the new cage
        $cages[$cageIndex++] = [intval($sum), $size, array_flip($list)];
    }

    //Try to create more cages on rows
    for($y = 0; $y < 9; ++$y) {
        $uniqueCages = [];
        $fullCages = [];
        $partialCages = [];
        $row = [];

        //Get all the uniques cages on the row
        for($x = 0; $x < 9; ++$x) {
            $position = $y * 9 + $x;
            $uniqueCages[$grids[$gridID][$position]] = 1;
            $row[] = $position;
        }

        //Check if all the positions of each cages are all in the row
        foreach($uniqueCages as $name => $filler) {
            if(count(array_diff($cagesPositions[$name], $row)) == 0) $fullCages[$name] = $cagesSum[$name];
            else $partialCages[$name] = $cagesSum[$name];
        }

        $countFullCages = count($fullCages);

        //If there is at least one cage with all it's positions in the row we can create more cages
        if($countFullCages > 0) {
            //If there are no partial cages, make sure we don't create duplicate cages
            for($size = 1; $size <= $countFullCages - (count($partialCages) == 0 ? 2 : 0); ++$size) {
                for($start = 0; $start <= $countFullCages - $size; ++$start) {

                    $usedCages = array_slice($fullCages, $start, $size);
                    $list = [];

                    //Find all the positions not part of the cages we have selected
                    for($x = 0; $x < 9; ++$x) {
                        $position = $y * 9 + $x;
                        
                        if(!in_array($grids[$gridID][$position], array_keys($usedCages))) {
                            $cagesMatch[$position][] = $cageIndex;
                            $list[$position] = 1;
                        }
                    }

                    //Create a new cage
                    $cages[$cageIndex++] = [45 - array_sum($usedCages), count($list), $list];
                }
            }
        }

        
        if(count($partialCages) == 1) {
            $name = array_key_first($partialCages);

            //error_log(var_export("row $y", true));
            //error_log(var_export($fullCages, true));
            //error_log(var_export($partialCages, true));
            
            $list = array_flip(array_diff($cagesPositions[$name], $row));

            foreach($list as $position => $filler) {
                $cagesMatch[$position][] = $cageIndex;
            }

            //error_log(var_export($list, true));
            //error_log(var_export(reset($partialCages) - 45 + array_sum($fullCages), true));

            //Create a new cage
            $cages[$cageIndex++] = [reset($partialCages) - 45 + array_sum($fullCages), count($list), $list];
        }
    }

    //Try to create more cages on cols
    for($x = 0; $x < 9; ++$x) {
        $uniqueCages = [];
        $fullCages = [];
        $partialCages = [];
        $col = [];

        //Get all the uniques cages on the col
        for($y = 0; $y < 9; ++$y) {
            $position = $y * 9 + $x;
            $uniqueCages[$grids[$gridID][$position]] = 1;
            $col[] = $position;
        }

        //Check if all the positions of each cages are all in the col
        foreach($uniqueCages as $name => $filler) {
            if(count(array_diff($cagesPositions[$name], $col)) == 0) $fullCages[$name] = $cagesSum[$name];
            else $partialCages[$name] = $cagesSum[$name];
        }

        $countFullCages = count($fullCages);

        //If there is at least one cage with all it's positions in the col we can create more cages
        if($countFullCages > 0) {
            //If there are no partial cages, make sure we don't create duplicate cages
            for($size = 1; $size <= $countFullCages - (count($partialCages) == 0 ? 2 : 0); ++$size) {
                for($start = 0; $start <= $countFullCages - $size; ++$start) {

                    $usedCages = array_slice($fullCages, $start, $size);
                    $list = [];

                    //Find all the positions not part of the cages we have selected
                    for($y = 0; $y < 9; ++$y) {
                        $position = $y * 9 + $x;
                        
                        if(!in_array($grids[$gridID][$position], array_keys($usedCages))) {
                            $cagesMatch[$position][] = $cageIndex;
                            $list[$position] = 1;
                        }
                    }

                    //Create a new cage
                    $cages[$cageIndex++] = [45 - array_sum($usedCages), count($list), $list];
                }
            }
        }

        
        if(count($partialCages) == 1) {
            $name = array_key_first($partialCages);

            //error_log(var_export("!!!!!!!col $x", true));
            //error_log(var_export($fullCages, true));
            //error_log(var_export($partialCages, true));
            
            $list = array_flip(array_diff($cagesPositions[$name], $col));

            foreach($list as $position => $filler) {
                $cagesMatch[$position][] = $cageIndex;
            }

            //error_log(var_export($list, true));
            //error_log(var_export(reset($partialCages) - 45 + array_sum($fullCages), true));

            //Create a new cage
            $cages[$cageIndex++] = [reset($partialCages) - 45 + array_sum($fullCages), count($list), $list];
        }
    }

     //Try to create more cages on regions
    for($r = 0; $r < 9; ++$r) {
        $uniqueCages = [];
        $fullCages = [];
        $partialCages = [];
        $region = [];
        

        //Get all the uniques cages in the region
        for($y = (intdiv($r, 3) * 3); $y < ((intdiv($r, 3) + 1) * 3); ++$y) {
            for($x = ($r % 3) * 3; $x < (($r % 3) + 1) * 3; ++$x) {
                $position = $y * 9 + $x;
                $uniqueCages[$grids[$gridID][$position]] = 1;
                $region[] = $position;
            }
        }

        //Check if all the positions of each cages are all in the region
        foreach($uniqueCages as $name => $filler) {
            if(count(array_diff($cagesPositions[$name], $region)) == 0) $fullCages[$name] = $cagesSum[$name];
            else $partialCages[$name] = $cagesSum[$name];
        }

        $countFullCages = count($fullCages);

        //If there is at least one cage with all it's positions in the region we can create more cages
        if($countFullCages > 0) {
            //If there are no partial cages, make sure we don't create duplicate cages
            for($size = 1; $size <= $countFullCages - (count($partialCages) == 0 ? 2 : 0); ++$size) {
                for($start = 0; $start <= $countFullCages - $size; ++$start) {

                    $usedCages = array_slice($fullCages, $start, $size);
                    $list = [];

                    //Find all the positions not part of the cages we have selected
                    for($y = (intdiv($r, 3) * 3); $y < ((intdiv($r, 3) + 1) * 3); ++$y) {
                        for($x = ($r % 3) * 3; $x < (($r % 3) + 1) * 3; ++$x) {
                            $position = $y * 9 + $x;
                        
                            if(!in_array($grids[$gridID][$position], array_keys($usedCages))) {
                                $cagesMatch[$position][] = $cageIndex;
                                $list[$position] = 1;
                            }
                        }
                    }

                    //Create a new cage
                    $cages[$cageIndex++] = [45 - array_sum($usedCages), count($list), $list];
                }
            }
        }

        if(count($partialCages) == 1) {
            $name = array_key_first($partialCages);

            //error_log(var_export("!!!!!!!region $r", true));
            //error_log(var_export($fullCages, true));
            //error_log(var_export($partialCages, true));
            
            $list = array_flip(array_diff($cagesPositions[$name], $region));

            foreach($list as $position => $filler) {
                $cagesMatch[$position][] = $cageIndex;
            }

            //error_log(var_export($list, true));
            //error_log(var_export(reset($partialCages) - 45 + array_sum($fullCages), true));

            //Create a new cage
            $cages[$cageIndex++] = [reset($partialCages) - 45 + array_sum($fullCages), count($list), $list];
        }
    }

    $uniqueCages = [];
    $rows = [];

    
    for($y = 0; $y < 9; ++$y) {

        $fullCages = [];
        $partialCages = [];

        //Get all the uniques cages on the rows
        for($x = 0; $x < 9; ++$x) {
            $position = $y * 9 + $x;
            $uniqueCages[$grids[$gridID][$position]] = 1;
            $rows[] = $position;
        }

        //Check if all the positions of each cages are all in the row
        foreach($uniqueCages as $name => $filler) {
            if(count(array_diff($cagesPositions[$name], $rows)) == 0) $fullCages[$name] = $cagesSum[$name];
            else $partialCages[$name] = $cagesSum[$name];
        }

        if(count($partialCages) == 1) {

            //error_log(var_export("col $y", true));
            //error_log(var_export($fullCages, true));
            //error_log(var_export($partialCages, true));

            $name = array_key_first($partialCages);
            
            $list = array_flip(array_diff($cagesPositions[$name], $rows));

            foreach($list as $position => $filler) {
                $cagesMatch[$position][] = $cageIndex;
            }

            //error_log(var_export($list, true));
            //error_log(var_export(reset($partialCages) - 45 + array_sum($fullCages), true));

            //Create a new cage
            $cages[$cageIndex++] = [reset($partialCages) - (45 * ($y + 1)) + array_sum($fullCages), count($list), $list];
        }
    }

    $uniqueCages = [];
    $rows = [];

    for($y = 8; $y >= 0; --$y) {

        $fullCages = [];
        $partialCages = [];

        //Get all the uniques cages on the rows
        for($x = 0; $x < 9; ++$x) {
            $position = $y * 9 + $x;
            $uniqueCages[$grids[$gridID][$position]] = 1;
            $rows[] = $position;
        }

        //Check if all the positions of each cages are all in the row
        foreach($uniqueCages as $name => $filler) {
            if(count(array_diff($cagesPositions[$name], $rows)) == 0) $fullCages[$name] = $cagesSum[$name];
            else $partialCages[$name] = $cagesSum[$name];
        }

        if(count($partialCages) == 1) {

            //error_log(var_export("col $y", true));
            //error_log(var_export($fullCages, true));
            //error_log(var_export($partialCages, true));

            $name = array_key_first($partialCages);
            
            $list = array_flip(array_diff($cagesPositions[$name], $rows));

            foreach($list as $position => $filler) {
                $cagesMatch[$position][] = $cageIndex;
            }

            //error_log(var_export($list, true));
            //error_log(var_export(reset($partialCages) - 45 + array_sum($fullCages), true));

            //Create a new cage
            $cages[$cageIndex++] = [reset($partialCages) - (45 * (9 - $y)) + array_sum($fullCages), count($list), $list];
        }
    }

    $uniqueCages = [];
    $cols = [];

    for($x = 0; $x < 9; ++$x) {

        $fullCages = [];
        $partialCages = [];

        //Get all the uniques cages on the cols
        for($y = 0; $y < 9; ++$y) {
            $position = $y * 9 + $x;
            $uniqueCages[$grids[$gridID][$position]] = 1;
            $cols[] = $position;
        }

        //Check if all the positions of each cages are all in the cols
        foreach($uniqueCages as $name => $filler) {
            if(count(array_diff($cagesPositions[$name], $cols)) == 0) $fullCages[$name] = $cagesSum[$name];
            else $partialCages[$name] = $cagesSum[$name];
        }

        if(count($partialCages) == 1) {

            //error_log(var_export("row $x", true));
            //error_log(var_export($fullCages, true));
            //error_log(var_export($partialCages, true));

            $name = array_key_first($partialCages);
            
            $list = array_flip(array_diff($cagesPositions[$name], $cols));

            foreach($list as $position => $filler) {
                $cagesMatch[$position][] = $cageIndex;
            }

            //error_log(var_export($list, true));
            //error_log(var_export(reset($partialCages) - 45 + array_sum($fullCages), true));

            //Create a new cage
            $cages[$cageIndex++] = [reset($partialCages) - (45 * ($x + 1)) + array_sum($fullCages), count($list), $list];
        }
    }

    $uniqueCages = [];
    $cols = [];

    for($x = 8; $x >= 0; --$x) {

        $fullCages = [];
        $partialCages = [];

        //Get all the uniques cages on the cols
        for($y = 0; $y < 9; ++$y) {
            $position = $y * 9 + $x;
            $uniqueCages[$grids[$gridID][$position]] = 1;
            $cols[] = $position;
        }

        //Check if all the positions of each cages are all in the cols
        foreach($uniqueCages as $name => $filler) {
            if(count(array_diff($cagesPositions[$name], $cols)) == 0) $fullCages[$name] = $cagesSum[$name];
            else $partialCages[$name] = $cagesSum[$name];
        }

        if(count($partialCages) == 1) {

            //error_log(var_export("row $x", true));
            //error_log(var_export($fullCages, true));
            //error_log(var_export($partialCages, true));

            $name = array_key_first($partialCages);
            
            $list = array_flip(array_diff($cagesPositions[$name], $cols));

            foreach($list as $position => $filler) {
                $cagesMatch[$position][] = $cageIndex;
            }

            //error_log(var_export($list, true));
            //error_log(var_export(reset($partialCages) - 45 + array_sum($fullCages), true));

            //Create a new cage
            $cages[$cageIndex++] = [reset($partialCages) - (45 * (9 - $x)) + array_sum($fullCages), count($list), $list];
        }
    }

    //For each cages try to reduce the possible digits of their positions
    foreach($cages as $cageIndex => [$sum, $count, $list]) {

        $digitsSum = findSumPermutations($sum, $count, NUMBERS);

        //Update all the positions in the cage
        foreach($list as $position => $filler) {
            $possibleDigits[$position] &= $digitsSum;
        }
    }

    solve($grid, $possibleDigits, $cages, $positionsToFind);
    //error_log(var_export($possibleDigits, true));

    error_log("Grid ID $gridID took: " . (microtime(1) - $gridTime));
}

echo implode("\n", array_map(function($line) {
    return implode(" ", $line);
}, $answer)) . PHP_EOL;

error_log("Total duration: " . (microtime(1) - $startTime));
error_log("Total guesses: $guess -- Total checks: $check");
