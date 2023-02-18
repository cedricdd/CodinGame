<?php

const NUMBERS = 511;
const NUMBERS_BIN = [1 => 1, 2 => 2, 3 => 4, 4 => 8, 5 => 16, 6 => 32, 7 => 64, 8 => 128, 9 => 256];
const REGIONS = [
    [0, 0, 2, 2], [3, 0, 5, 2], [6, 0, 8, 2],
    [0, 3, 2, 5], [3, 3, 5, 5], [6, 3, 8, 5],
    [0, 6, 2, 8], [3, 6, 5, 8], [6, 6, 8, 8],
];

$memory = [];

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
    global $cagesMatch, $affectedPositions, $answer;

    do {
        $numberFound = false;

        foreach($positionsToFind as $index => $filler) {

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

    //Try to create more cages by using rows
    $uniqueCages = [];
    $fullCages = array_fill(0, 9, []);
    $partialCages = array_fill(0, 9, []);
    $rows = [];

    for($y = 0; $y < 9; ++$y) {

        //Get all the uniques cages on the row
        for($x = 0; $x < 9; ++$x) {
            $position = $y * 9 + $x;
            $name = $grids[$gridID][$position];
            $uniqueCages[$y][$name] = $cagesSum[$name];
            $rows[$y][$position] = $position;
        }

        //Check if the cages are fully contained in the row or not
        foreach($uniqueCages[$y] as $name => $sum) {
            if(count(array_diff($cagesPositions[$name], $rows[$y])) == 0) $fullCages[$y][$name] = $sum;
            else $partialCages[$y][$name] = $sum;
        }

        $countFullCages = count($fullCages[$y]);

        /*
         * If there is at least one cage that is fully contained in the row
         *
         * EX:
         * bbcccdeee
         * fbbgddhii
         * ...
         * 
         * Cages 'c' & cage 'e' are fully contained in the row, hence we can find the sum of 'bb...dee', 'bbcccd..' & 'bb...d..' 
         */
        if($countFullCages > 0) {
            //If there are no partial cages, make sure we don't create duplicate cages
            for($size = 1; $size <= $countFullCages - (count($partialCages) == 0 ? 2 : 0); ++$size) {
                for($start = 0; $start <= $countFullCages - $size; ++$start) {

                    $usedCages = array_slice($fullCages[$y], $start, $size);
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

        /*
         * If there is only one cage not fully contained in the row
         *
         * EX:
         * bbccceeee
         * fbbgddhii
         * ...
         * 
         * Cage 'b' is the only one not fully contained in first row, hence we can find the sum of all the positions of 'b' that are not on row 1
         */
        if(count($partialCages[$y]) == 1) {
            $name = array_key_first($partialCages[$y]); //Name of the only cage not fully contained in the row

            $list = array_flip(array_diff($cagesPositions[$name], $rows[$y])); //All the positions part of the cage that are not in the row

            foreach($list as $position => $filler) {
                $cagesMatch[$position][] = $cageIndex; //Associate the positions with the new cage we are creating
            }

            //Create a new cage
            $cages[$cageIndex++] = [reset($partialCages[$y]) - 45 + array_sum($fullCages[$y]), count($list), $list];
        }
    }

    //Use a group of rows from top to bottom
    $fullCagesGroup = $fullCages[0];
    $partialCagesGroup = $partialCages[0];
    $rowsGroup = $rows[0];

    for($y = 1; $y < 9; ++$y) {
        $fullCagesGroup += $fullCages[$y]; //Add the cage that are fully contained in the row we are working on
        $partialCagesGroup += $partialCages[$y]; //Add the new partial group from the row we are working on
        $rowsGroup += $rows[$y]; //Add all the positions of the row we are working on

        foreach($partialCagesGroup as $name => $sum) {
            //This group is now fully contained in the group of rows
            if(count(array_diff($cagesPositions[$name], $rowsGroup)) == 0) {
                $fullCagesGroup[$name] = $cagesSum[$name];
                unset($partialCagesGroup[$name]);
            }
        }

        /*
         * If in a group of rows there's only one cage not fully contained
         * 
         * EX:
         * abcccdeee
         * fbbgddhie
         * fjggdkhil
         * fjmgkknil
         * ...
         * 
         * The only cage not fully contained in the group (1-4) is the cage 'n', hence we can find the sum of all the positions of 'n' that are not in the group
         */
        if(count($partialCagesGroup) == 1) {
            $name = array_key_first($partialCagesGroup); //Name of the only cage not fully contained in the group of rows

            $list = array_flip(array_diff($cagesPositions[$name], $rowsGroup)); //All the positions part of the cage that are not in the group of rows

            foreach($list as $position => $filler) {
                $cagesMatch[$position][] = $cageIndex; //Associate the positions with the new cage we are creating
            }

            //Create a new cage
            $cages[$cageIndex++] = [reset($partialCagesGroup) - (45 * ($y + 1)) + array_sum($fullCagesGroup), count($list), $list];
        }
    }

    //Use a group of rows from bottom to top
    $fullCagesGroup = $fullCages[8];
    $partialCagesGroup = $partialCages[8];
    $rowsGroup = $rows[8];

    for($y = 7; $y >= 0; --$y) {
        $fullCagesGroup += $fullCages[$y]; //Add the cage that are fully contained in the row we are working on
        $partialCagesGroup += $partialCages[$y]; //Add the new partial group from the row we are working on
        $rowsGroup += $rows[$y]; //Add all the positions of the row we are working on

        foreach($partialCagesGroup as $name => $sum) {
            //This group is now fully contained in the group of rows
            if(count(array_diff($cagesPositions[$name], $rowsGroup)) == 0) {
                $fullCagesGroup[$name] = $cagesSum[$name];
                unset($partialCagesGroup[$name]);
            }
        }

        if(count($partialCagesGroup) == 1) {
            $name = array_key_first($partialCagesGroup); //Name of the only cage not fully contained in the group of rows

            $list = array_flip(array_diff($cagesPositions[$name], $rowsGroup)); //All the positions part of the cage that are not in the group of rows

            foreach($list as $position => $filler) {
                $cagesMatch[$position][] = $cageIndex; //Associate the positions with the new cage we are creating
            }

            //Create a new cage
            $cages[$cageIndex++] = [reset($partialCagesGroup) - (45 * (9 - $y)) + array_sum($fullCagesGroup), count($list), $list];
        }
    }
    
    //Try to create more cages on cols
    $uniqueCages = [];
    $fullCages = array_fill(0, 9, []);
    $partialCages = array_fill(0, 9, []);
    $cols = [];

    for($x = 0; $x < 9; ++$x) {

        //Get all the uniques cages on the col
        for($y = 0; $y < 9; ++$y) {
            $position = $y * 9 + $x;
            $name = $grids[$gridID][$position];
            $uniqueCages[$x][$name] = $cagesSum[$name];
            $cols[$x][$position] = $position;
        }

        //Check if the cages are fully contained in the row or not
        foreach($uniqueCages[$x] as $name => $sum) {
            if(count(array_diff($cagesPositions[$name], $cols[$x])) == 0) $fullCages[$x][$name] = $sum;
            else $partialCages[$x][$name] = $sum;
        }

        $countFullCages = count($fullCages[$x]);

        /*
         * If there is at least one cage that is fully contained in the col
         *
         * EX:
         * bb...
         * fb...
         * fj...
         * fj...
         * oo...
         * so...
         * xx...
         * BC...
         * BB...
         * 
         * Cages 'f' & cage 's' are fully contained in the col, hence we can find the sum of 'b...osxBB', 'bfffo.xBB' & 'b...o.xBB' 
         */
        if($countFullCages > 0) {

            //If there are no partial cages, make sure we don't create duplicate cages
            for($size = 1; $size <= $countFullCages - (count($partialCages) == 0 ? 2 : 0); ++$size) {
                for($start = 0; $start <= $countFullCages - $size; ++$start) {

                    $usedCages = array_slice($fullCages[$x], $start, $size);
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

        /*
         * If there is only one cage not fully contained in the col
         *
         * EX:
         * ab...
         * fb...
         * fj...
         * fj...
         * oo...
         * xo...
         * xo...
         * xC...
         * xB...
         * 
         * Cage 'o' is the only one not fully contained in first col, hence we can find the sum of all the positions of 'o' that are not on col 1
         */
        if(count($partialCages[$x]) == 1) {
            $name = array_key_first($partialCages[$x]); //Name of the only cage not fully contained in the col

            $list = array_flip(array_diff($cagesPositions[$name], $cols[$x])); //All the positions part of the cage that are not in the col

            foreach($list as $position => $filler) {
                $cagesMatch[$position][] = $cageIndex; //Associate the positions with the new cage we are creating
            }

            //Create a new cage
            $cages[$cageIndex++] = [reset($partialCages[$x]) - 45 + array_sum($fullCages[$x]), count($list), $list];
        }
    }

    //Use a group of cols from left to right
    $fullCagesGroup = $fullCages[0];
    $partialCagesGroup = $partialCages[0];
    $colsGroup = $cols[0];

    for($x = 1; $x < 9; ++$x) {
        $fullCagesGroup += $fullCages[$x]; //Add the cage that are fully contained in the col we are working on
        $partialCagesGroup += $partialCages[$x]; //Add the new partial group from the col we are working on
        $colsGroup += $cols[$x]; //Add all the positions of the col we are working on

        foreach($partialCagesGroup as $name => $sum) {
            //This group is now fully contained in the group of col
            if(count(array_diff($cagesPositions[$name], $colsGroup)) == 0) {
                $fullCagesGroup[$name] = $cagesSum[$name];
                unset($partialCagesGroup[$name]);
            }
        }

        /*
         * If in a group of cols there's only one cage not fully contained
         * 
         * EX:
         * abc...
         * fbb...
         * fjg...
         * fjm...
         * oop...
         * sot...
         * xxt...
         * BCD...
         * BBD...
         * 
         * The only cage not fully contained in the group (1-2) is the cage 'b', hence we can find the sum of all the positions of 'b' that are not in the group
         */
        if(count($partialCagesGroup) == 1) {
            $name = array_key_first($partialCagesGroup); //Name of the only cage not fully contained in the group of cols

            $list = array_flip(array_diff($cagesPositions[$name], $colsGroup)); //All the positions part of the cage that are not in the group of cols

            foreach($list as $position => $filler) {
                $cagesMatch[$position][] = $cageIndex; //Associate the positions with the new cage we are creating
            }

            //Create a new cage
            $cages[$cageIndex++] = [reset($partialCagesGroup) - (45 * ($x + 1)) + array_sum($fullCagesGroup), count($list), $list];
        }
    }

    //Use a group of cols from right to left 
    $fullCagesGroup = $fullCages[8];
    $partialCagesGroup = $partialCages[8];
    $colsGroup = $cols[8];

    for($x = 7; $x >= 0; --$x) {
        $fullCagesGroup += $fullCages[$x]; //Add the cage that are fully contained in the row we are working on
        $partialCagesGroup += $partialCages[$x]; //Add the new partial group from the row we are working on
        $colsGroup += $cols[$x]; //Add all the positions of the row we are working on

        foreach($partialCagesGroup as $name => $sum) {
            //This group is now fully contained in the group of cols
            if(count(array_diff($cagesPositions[$name], $colsGroup)) == 0) {
                $fullCagesGroup[$name] = $cagesSum[$name];
                unset($partialCagesGroup[$name]);
            }
        }

        if(count($partialCagesGroup) == 1) {
            $name = array_key_first($partialCagesGroup); //Name of the only cage not fully contained in the group of cols

            $list = array_flip(array_diff($cagesPositions[$name], $colsGroup)); //All the positions part of the cage that are not in the group of cols

            foreach($list as $position => $filler) {
                $cagesMatch[$position][] = $cageIndex; //Associate the positions with the new cage we are creating
            }

            //Create a new cage
            $cages[$cageIndex++] = [reset($partialCagesGroup) - (45 * (9 - $x)) + array_sum($fullCagesGroup), count($list), $list];
        }
    }

     //Try to create more cages on regions
     $uniqueCages = [];
     $fullCages = array_fill(0, 9, []);
     $partialCages = array_fill(0, 9, []);
     $regions = [];

    for($r = 0; $r < 9; ++$r) {

        [$startX, $startY, $endX, $endY] = REGIONS[$r];

        //Get all the uniques cages in the region
        for($y = $startY; $y <= $endY; ++$y) {
            for($x = $startX; $x <= $endX; ++$x) {
                $position = $y * 9 + $x;
                $name = $grids[$gridID][$position];
                $uniqueCages[$r][$name] = $cagesSum[$name];
                $regions[$r][$position] = $position;
            }
        }

        //Check if all the positions of each cages are all in the region
        foreach($uniqueCages[$r] as $name => $sum) {
            if(count(array_diff($cagesPositions[$name], $regions[$r])) == 0) $fullCages[$r][$name] = $sum;
            else $partialCages[$r][$name] = $sum;
        }

        $countFullCages = count($fullCages[$r]);

        /*
         * If there is at least one cage that is fully contained in the region
         *
         * EX:
         * ..abbbf..
         * ..aaccf..
         * ..addcf..
         * ...dde...
         * 
         * Cages 'b' & cage 'c' are fully contained in the region, hence we can find the sum of '...accddc', 'bbba..dd.' & '...a..dd.' 
         */
        if($countFullCages > 0) {
            //If there are no partial cages, make sure we don't create duplicate cages
            for($size = 1; $size <= $countFullCages - (count($partialCages[$r]) == 0 ? 2 : 0); ++$size) {
                for($start = 0; $start <= $countFullCages - $size; ++$start) {

                    $usedCages = array_slice($fullCages[$r], $start, $size);
                    $list = [];

                    //Find all the positions not part of the cages we have selected
                    for($y = $startY; $y <= $endY; ++$y) {
                        for($x = $startX; $x <= $endX; ++$x) {
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

        /*
         * If there is only one cage not fully contained in the region
         *
         * EX:
         * ..abbbf..
         * ..aaccf..
         * ..addcf..
         * ...eee...
         * 
         * Cage 'a' is the only one not fully contained in the region, hence we can find the sum of all the positions of 'a' that are not on region
         */
        if(count($partialCages[$r]) == 1) {
            $name = array_key_first($partialCages[$r]); //Name of the only cage not fully contained in the region

            $list = array_flip(array_diff($cagesPositions[$name], $regions[$r])); //All the positions part of the cage that are not in the region

            foreach($list as $position => $filler) {
                $cagesMatch[$position][] = $cageIndex; //Associate the positions with the new cage we are creating
            }

            //Create a new cage
            $cages[$cageIndex++] = [reset($partialCages[$r]) - 45 + array_sum($fullCages[$r]), count($list), $list];
        }
    }

    //Use multiples regions
    foreach([[0, 1], [1, 2], [3, 4], [4, 5], [6, 7], [7, 8], [0, 3], [1, 4], [2, 5], [3, 6], [4, 7], [5, 8]] as $regionsUsed) {
        $fullCagesGroup = [];
        $partialCagesGroup = [];
        $regionsGroup = [];

        foreach($regionsUsed as $r) {
            $fullCagesGroup += $fullCages[$r];
            $partialCagesGroup += $partialCages[$r];
            $regionsGroup += $regions[$r];
        }

        foreach($partialCagesGroup as $name => $sum) {
            //This group is now fully contained in the group of cols
            if(count(array_diff($cagesPositions[$name], $regionsGroup)) == 0) {
                $fullCagesGroup[$name] = $cagesSum[$name];
                unset($partialCagesGroup[$name]);
            }
        }

        if(count($partialCagesGroup) == 1) {
            $name = array_key_first($partialCagesGroup); //Name of the only cage not fully contained in the group of cols

            $list = array_flip(array_diff($cagesPositions[$name], $regionsGroup)); //All the positions part of the cage that are not in the group of cols

            foreach($list as $position => $filler) {
                $cagesMatch[$position][] = $cageIndex; //Associate the positions with the new cage we are creating
            }

            //Create a new cage
            $cages[$cageIndex++] = [reset($partialCagesGroup) - (45 * count($regionsUsed)) + array_sum($fullCagesGroup), count($list), $list];
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

    error_log("Grid ID $gridID took: " . (microtime(1) - $gridTime));
}

echo implode("\n", array_map(function($line) {
    return implode(" ", $line);
}, $answer)) . PHP_EOL;

error_log("Total duration: " . (microtime(1) - $startTime));
