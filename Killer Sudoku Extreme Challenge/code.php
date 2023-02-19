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

function createCage(array $positions, int $sum, bool $checkCreated = false, bool $isInput = false) {
    global $cageIndex, $cages, $cagesMatch, $fullCagesColCreated, $fullCagesRowCreated;

    $count = count($positions);

    //If the cage is big we only add if it's one of the cages from the inputs
    if($isInput == false && $count >= 7) return;

    $index = implode("-", $positions);

    //We don't want to create the same cage multiple times
    if(isset($knownCages[$index])) return;
    else $knownCages[$index] = 1;

    //Create a link between the position and the cage
    foreach($positions as $position) {
        $cagesMatch[$position][] = $cageIndex;
    }

    //Create a new cage
    $cages[$cageIndex++] = [$sum, $count, array_flip($positions)];

    //If this cage has more than position we check if it's fully contained in a row or col and save it
    if($checkCreated && $count > 1) {
        $check = getDispertion($positions);

        if(count($check["y"]) == 1) {
            $fullCagesRowCreated[array_key_first($check["y"])][$index] = [$sum, $positions];
        }
        if(count($check["x"]) == 1) {
            $fullCagesColCreated[array_key_first($check["x"])][$index] = [$sum, $positions];
        }
    }
}

function getDispertion(array $postitions): array {
    $results = [];

    foreach($postitions as $postition) {
        $results["x"][$postition % 9] = 1;
        $results["y"][intdiv($postition, 9)] = 1;
    }

    return $results;
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
    $knownCages = [];
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

        createCage($list, intval($sum), false, true);
    }

    $fullCagesRowCreated = array_fill(0, 9, []);
    $fullCagesColCreated = array_fill(0, 9, []);

    //Try to create more cages by using rows
    $uniqueCages = [];
    $fullCagesRow = array_fill(0, 9, []);
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
            if(count(array_diff($cagesPositions[$name], $rows[$y])) == 0) {
                $fullCagesRow[$y][] = [$sum, $cagesPositions[$name]];
            }
            else $partialCages[$y][$name] = $sum;
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

            createCage(array_diff($cagesPositions[$name], $rows[$y]), reset($partialCages[$y]) - 45 + array_sum(array_column($fullCagesRow[$y], 0)), true);
        }
    }

    //Use a group of rows from top to bottom
    $fullCagesSum = array_sum(array_column($fullCagesRow[0], 0));
    $partialCagesGroup = $partialCages[0];
    $rowsGroup = $rows[0];

    for($y = 1; $y < 9; ++$y) {
        $fullCagesSum += array_sum(array_column($fullCagesRow[$y], 0)); //Add the sum of all the cages that are fully contained in the row we are working on
        $partialCagesGroup += $partialCages[$y]; //Add the new partial group from the row we are working on
        $rowsGroup += $rows[$y]; //Add all the positions of the row we are working on

        foreach($partialCagesGroup as $name => $sum) {
            //This group is now fully contained in the group of rows
            if(count(array_diff($cagesPositions[$name], $rowsGroup)) == 0) {
                $fullCagesSum += $sum;
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

            createCage(array_diff($cagesPositions[$name], $rowsGroup), reset($partialCagesGroup) - (45 * ($y + 1)) + $fullCagesSum, true);
        }
    }

    //Use a group of rows from bottom to top
    $fullCagesSum = array_sum(array_column($fullCagesRow[8], 0));
    $partialCagesGroup = $partialCages[8];
    $rowsGroup = $rows[8];

    for($y = 7; $y >= 0; --$y) {
        $fullCagesSum += array_sum(array_column($fullCagesRow[$y], 0)); //Add the sum of all the cages that are fully contained in the row we are working on
        $partialCagesGroup += $partialCages[$y]; //Add the new partial group from the row we are working on
        $rowsGroup += $rows[$y]; //Add all the positions of the row we are working on

        foreach($partialCagesGroup as $name => $sum) {
            //This group is now fully contained in the group of rows
            if(count(array_diff($cagesPositions[$name], $rowsGroup)) == 0) {
                $fullCagesSum += $sum;
                unset($partialCagesGroup[$name]);
            }
        }

        if(count($partialCagesGroup) == 1) {
            $name = array_key_first($partialCagesGroup); //Name of the only cage not fully contained in the group of rows

            createCage(array_diff($cagesPositions[$name], $rowsGroup), reset($partialCagesGroup) - (45 * (9 - $y)) + $fullCagesSum, true);
        }
    }
    
    //Try to create more cages on cols
    $uniqueCages = [];
    $fullCagesCol = array_fill(0, 9, []);
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
            if(count(array_diff($cagesPositions[$name], $cols[$x])) == 0) {
                $fullCagesCol[$x][] = [$sum, $cagesPositions[$name]];
            }
            else $partialCages[$x][$name] = $sum;
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

            createCage(array_diff($cagesPositions[$name], $cols[$x]), reset($partialCages[$x]) - 45 + array_sum(array_column($fullCagesCol[$x], 0)), true);

        }
    }

    //Use a group of cols from left to right
    $fullCagesSum = array_sum(array_column($fullCagesCol[0], 0));
    $partialCagesGroup = $partialCages[0];
    $colsGroup = $cols[0];

    for($x = 1; $x < 9; ++$x) {
        $fullCagesSum += array_sum(array_column($fullCagesCol[$x], 0)); //Add the sum of all the cages that are fully contained in the col we are working on
        $partialCagesGroup += $partialCages[$x]; //Add the new partial group from the col we are working on
        $colsGroup += $cols[$x]; //Add all the positions of the col we are working on

        foreach($partialCagesGroup as $name => $sum) {
            //This group is now fully contained in the group of col
            if(count(array_diff($cagesPositions[$name], $colsGroup)) == 0) {
                $fullCagesSum += $sum;
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

            createCage(array_diff($cagesPositions[$name], $colsGroup), reset($partialCagesGroup) - (45 * ($x + 1)) + $fullCagesSum, true);
        }
    }

    //Use a group of cols from right to left 
    $fullCagesSum = array_sum(array_column($fullCagesCol[8], 0));
    $partialCagesGroup = $partialCages[8];
    $colsGroup = $cols[8];

    for($x = 7; $x >= 0; --$x) {
        $fullCagesSum += array_sum(array_column($fullCagesCol[$x], 0)); //Add the sum of all the cages that are fully contained in the row we are working on
        $partialCagesGroup += $partialCages[$x]; //Add the new partial group from the row we are working on
        $colsGroup += $cols[$x]; //Add all the positions of the row we are working on

        foreach($partialCagesGroup as $name => $sum) {
            //This group is now fully contained in the group of cols
            if(count(array_diff($cagesPositions[$name], $colsGroup)) == 0) {
                $fullCagesSum += $sum;
                unset($partialCagesGroup[$name]);
            }
        }

        if(count($partialCagesGroup) == 1) {
            $name = array_key_first($partialCagesGroup); //Name of the only cage not fully contained in the group of cols

            createCage(array_diff($cagesPositions[$name], $colsGroup), reset($partialCagesGroup) - (45 * (9 - $x)) + $fullCagesSum, true);
        }
    }

     //Try to create more cages on regions
     $uniqueCages = [];
     $fullCagesReg = array_fill(0, 9, []);
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
            if(count(array_diff($cagesPositions[$name], $regions[$r])) == 0) {
                $fullCagesReg[$r][] = [$sum, $cagesPositions[$name]];
            }
            else $partialCages[$r][$name] = $sum;
        }

        $countFullCages = count($fullCagesReg[$r]);

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
            for($size = 1; $size <= $countFullCages; ++$size) {
                for($start = 0; $start <= $countFullCages - $size; ++$start) {
                    $usedCages = array_slice($fullCagesReg[$r], $start, $size);
                    $list = array_merge(...array_column($usedCages, 1));
                    $sum = array_sum(array_column($usedCages, 0));

                    createCage(array_diff($regions[$r], $list), 45 - $sum);

                    //We are using multiples cages, also create a new cage that's a combination of these cages
                    if($size > 1 && count($list) != 9) {
                        createCage($list, $sum);
                    }
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

            createCage(array_diff($cagesPositions[$name], $regions[$r]), reset($partialCages[$r]) - 45 + array_sum(array_column($fullCagesReg[$r], 0)), true);
        }
    }

    //Use multiples regions
    foreach([[0, 1], [1, 2], [3, 4], [4, 5], [6, 7], [7, 8], [0, 3], [1, 4], [2, 5], [3, 6], [4, 7], [5, 8]] as $regionsUsed) {
        $fullCagesSum = 0;
        $partialCagesGroup = [];
        $regionsGroup = [];

        foreach($regionsUsed as $r) {
            $fullCagesSum += array_sum(array_column($fullCagesReg[$r], 0));
            $partialCagesGroup += $partialCages[$r];
            $regionsGroup += $regions[$r];
        }

        foreach($partialCagesGroup as $name => $sum) {
            //This group is now fully contained in the group of cols
            if(count(array_diff($cagesPositions[$name], $regionsGroup)) == 0) {
                $fullCagesSum += $sum;
                unset($partialCagesGroup[$name]);
            }
        }

        if(count($partialCagesGroup) == 1) {
            $name = array_key_first($partialCagesGroup); //Name of the only cage not fully contained in the group of cols

            createCage(array_diff($cagesPositions[$name], $regionsGroup), reset($partialCagesGroup) - (45 * count($regionsUsed)) + $fullCagesSum, true);
        }
    }

    for($y = 0; $y < 9; ++$y) {

        $fullCages = array_merge($fullCagesRow[$y], $fullCagesRowCreated[$y]);
        $countFullCages = count($fullCages);

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
            for($size = 1; $size <= $countFullCages; ++$size) {
                for($start = 0; $start <= $countFullCages - $size; ++$start) {

                    $usedCages = array_slice($fullCages, $start, $size);
                    $list = array_merge(...array_column($usedCages, 1));
                    $sum = array_sum(array_column($usedCages, 0));

                    createCage(array_diff($rows[$y], $list), 45 - $sum);

                    //We are using multiples cages, also create a new cage that's a combination of these cages
                    if($size > 1 && count($list) != 9) {
                        createCage($list, $sum);
                    }
                }
            }
        }
    }

    for($x = 0; $x < 9; ++$x) {

        $fullCages = array_merge($fullCagesCol[$x], $fullCagesColCreated[$x]);
        $countFullCages = count($fullCages);

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

            for($size = 1; $size <= $countFullCages; ++$size) {
                for($start = 0; $start <= $countFullCages - $size; ++$start) {

                    $usedCages = array_slice($fullCages, $start, $size);
                    $list = array_merge(...array_column($usedCages, 1));
                    $sum = array_sum(array_column($usedCages, 0));

                    createCage(array_diff($cols[$x], $list), 45 - $sum);

                    //We are using multiples cages, also create a new cage that's a combination of these cages
                    if($size > 1 && count($list) != 9) {
                        createCage($list, $sum);
                    }
                }
            }
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

    //When we update a position we want to work on cages with the more positions first
    foreach($cagesMatch as $a => &$list) {
        uasort($list, function($a, $b) use ($cages) {
            return $cages[$b][1] <=> $cages[$a][1];
        });
    }

    //We want to start working on the positions that are linked to the less cages
    uksort($positionsToFind, function($a, $b) use ($cagesMatch) {
        return count($cagesMatch[$a]) <=> count($cagesMatch[$b]);
    });

    solve($grid, $possibleDigits, $cages, $positionsToFind);

    error_log("Grid ID $gridID took: " . (microtime(1) - $gridTime));
}

echo implode("\n", array_map(function($line) {
    return implode(" ", $line);
}, $answer)) . PHP_EOL;

error_log("Total duration: " . (microtime(1) - $startTime));
