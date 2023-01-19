<?php

const NUMBERS = 511;
const NUMBERS_BIN = [1 => 1, 2 => 2, 3 => 4, 4 => 8, 5 => 16, 6 => 32, 7 => 64, 8 => 128, 9 => 256];


//Find all the ways to reach $sum by using $count numbers
function findSumPermutations(int $sum, int $count, array $numbers, array $list, array &$cage): void {

    //We reached the sum we want
    if($sum == 0 && $count == count($list)) {
        //We mark all the numbers we can use
        foreach($list as $number) $cage[2] |= NUMBERS_BIN[$number];

        /*
         * Save all the numbers associations for this cage.
         * If we use the number X in any positions of the cage, we know that the other positions in the cage have to be a number 
         * that is associated with X in one of the solutions that reaches the sum.
         */
        for($i = 0; $i < $count; ++$i) {
            for($j = 0; $j < $count; ++$j) {
                if($i == $j) continue;

                $cage[3][$list[$i]] |= NUMBERS_BIN[$list[$j]];
            }
        } 

        return;
    }

    //We still have numbers that can be used and we haven't reached the max amount of numbers yet.
    if($count > 0 && count($numbers) > 0) {

        $number = array_pop($numbers); //The next number to test

        //We don't use it
        findSumPermutations($sum, $count, $numbers, $list, $cage);

        //We use this number
        if($sum >= $number) {
            $list[] = $number;
            findSumPermutations($sum - $number, $count, $numbers, $list, $cage);
        }
    } 
}

//Get the all the position in the grid that are affected when we set a number
function generateAffectedPositions(): array {
    $affected = [];

    for($y = 0; $y < 9; ++$y) {
        for($x = 0; $x < 9; ++$x) {
            $index = $y * 9 + $x;

            for($i = 0; $i < 9; ++$i) {
                //The position on the same row
                $affected[$index][] = $i * 9 + $x;
                //The position on the same col
                $affected[$index][] = $y * 9 + $i;
            }
        
            //The positions in the same region
            for($y2 = (floor($y / 3) * 3); $y2 < ((floor($y / 3) + 1) * 3); ++$y2) {
                for($x2 = (floor($x / 3) * 3); $x2 < ((floor($x / 3) + 1) * 3); ++$x2) {
                    $affected[$index][] = intval($y2 * 9 + $x2);
                }
            }

            $affected[$index] = array_unique($affected[$index]);
        }
    }

    return $affected;
}

function solve(string $grid, array $possibleNumbers, array $cages, array $positionsToFind): void {
    global $cagesMatch, $affectedPositions;

    do {
        $numberFound = false;

        foreach($positionsToFind as $index => $filler) {
            //There are no number left for this position, invalid grid
            if($possibleNumbers[$index] == 0) return;

            //There is only only possible number for this position
            switch($possibleNumbers[$index]) {
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

            $cageName = $cagesMatch[$index];
    
            //This was the last number to find in the region
            if(count($cages[$cageName][1]) == 1) {
                if($value != $cages[$cageName][0]) return; //Sum of the cage doesn't match, invalid grid
                else unset($cages[$cageName]);
            }
            else {
                if(($cages[$cageName][0] -= $value) <= 0) return; //Update the value of the sum & check if the sum is already too big
                unset($cages[$cageName][1][$index]); //Update the positions left to find in this cage

                foreach($cages[$cageName][1] as $position => $filler) $possibleNumbers[$position] &= $cages[$cageName][3][$value];
            }

            $grid[$index] = $value;

            unset($positionsToFind[$index]);
            foreach($affectedPositions[$index] as $position) $possibleNumbers[$position] &= ~NUMBERS_BIN[$value];

            $numberFound = true;
        }

        foreach($cages as $name => [$value, $list]) {
            //There only one position in this cage that is still missing
            if(count($list) == 1) {
                $index = array_key_first($list);

                //The value missing to reach the sum of the cage is not a valid value for this position => invalid grid
                if(!isset(NUMBERS_BIN[$value]) || ($possibleNumbers[$index] & NUMBERS_BIN[$value]) == 0) return;

                unset($cages[$name]); ///We are done with this cage

                $grid[$index] = $value;

                unset($positionsToFind[$index]);
                foreach($affectedPositions[$index] as $position) $possibleNumbers[$position] &= ~NUMBERS_BIN[$value];

                $numberFound = true;
            }
        }

    } while($numberFound); //Restart the loop as long as some number have been found

    //There are some positions with multiple possibilities
    if(count($positionsToFind) > 0) {

        $position = array_key_first($positionsToFind);
        $numbers = $possibleNumbers[$position];

        //Test each values for this position
        foreach(NUMBERS_BIN as $value => $check) {
            if(($numbers & $check) != 0) {
                $possibleNumbers[$position] = $check;

                solve($grid, $possibleNumbers, $cages, $positionsToFind);
            } 
        }

        return;
    } 

    //We have found the solution
    echo implode("\n", str_split($grid, 9)) . PHP_EOL;
}

$start = microtime(1);

$possibleNumbers = array_fill(0, 81, NUMBERS);
$grid = str_repeat("0", 81);
$affectedPositions = generateAffectedPositions();
$positionsToFind = [];

for ($y = 0; $y < 9; ++$y) {
    fscanf(STDIN, "%s %s", $gridLine, $gridCages);

    for($x = 0; $x < 9; ++$x) {
        $index = $y * 9 + $x;
        $value = intval($gridLine[$x]);

        if($value != 0) {
            $grid[$index] = $value;

            foreach($affectedPositions[$index] as $position) $possibleNumbers[$position] &= ~NUMBERS_BIN[$value];
        } else $positionsToFind[$index] = 1;

        $name = $gridCages[$x];
        
        //We need to create this cage
        if(!isset($cages[$name])) $cages[$name] = [0, []];
        
        $cages[$name][1][$index] = $value; //Save all the positions in this cage
        $cagesMatch[$index] = $name; //keep track of which cage is associated with each positions
    }
}

foreach(explode(" ", trim(fgets(STDIN))) as $values) {
    [$name, $value] = explode("=", $values);

    $cages[$name][0] = $value;
}

foreach($cages as $name => [$sum, $listPositions]) {

    $listNumbers = range(1, 9); //All the numbers that can be used for the sum

    foreach($listPositions as $index => $number) {
        //We have a number that's already set
        if($number != 0) {
            $sum -= $number;
            unset($listPositions[$index]);
            unset($listNumbers[$number - 1]);
        } 
    }

    //Update info of the cage
    $cages[$name] = [$sum, $listPositions, 0, range(0, 9)];

    findSumPermutations($sum, count($listPositions), $listNumbers, [], $cages[$name]);

    //Update the possible numbers for all the positions inside the cage
    foreach($listPositions as $index => $number) {
        $possibleNumbers[$index] &= $cages[$name][2];
    }
}

solve($grid, $possibleNumbers, $cages, $positionsToFind);

error_log(microtime(1) - $start);
