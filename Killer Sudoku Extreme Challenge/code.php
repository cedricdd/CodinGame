<?php

const NUMBERS = 511;
const NUMBERS_BIN = [1 => 1, 2 => 2, 3 => 4, 4 => 8, 5 => 16, 6 => 32, 7 => 64, 8 => 128, 9 => 256];

$memory = [];

//Find all the ways to reach $sum by using $count numbers
function findSumPermutations(int $sum, int $count, int $numbers): int {

    global $memory;

    //error_log("$sum $count " . decbin($numbers));

    if(isset($memory[$sum][$count][$numbers])) return $memory[$sum][$count][$numbers];


    if($sum < 0 || $count == 0 || $numbers == 0) return 0;

    //We still have numbers that can be used and we haven't reached the max amount of numbers yet.
    foreach(NUMBERS_BIN as $value => $binary) {

        if($numbers & $binary) {
            if($count == 1 && $sum == $value) {
                //error_log("setting $sum $count $numbers as $binary");
                return $memory[$sum][$count][$numbers] = $binary;
            }

            $result = findSumPermutations($sum, $count, $numbers & ~$binary);
            if($solution = findSumPermutations($sum - $value, $count - 1, $numbers & ~$binary)) {
                $result |= ($solution | $binary);
            }

            return $memory[$sum][$count][$numbers] = $result;
        }
    } 

    //error_log("setting $sum $count $numbers as 0");
    return $memory[$sum][$count][$numbers] = 0;
}

//Get the all the position in the grid that are affected when we set a number
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

            unset($affected[$index][$index]);
        }
    }

    return $affected;
}

function solve(string $grid, array $possibleNumbers, array $cages, array $positionsToFind): void {
    global $cagesMatch, $affectedPositions, $answer;

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

            //error_log("for pos $index => $value");

            foreach($cagesMatch[$index] as $cageIndex) {

                //error_log("update cage $cageIndex");

                //This was the last number to find in the region
                if(--$cages[$cageIndex][1] == 0) {
                    if($value != $cages[$cageIndex][0]) return; //Sum of the cage doesn't match, invalid grid
                    else {
                        unset($cages[$cageIndex]);
                        continue;
                    }
                }

                $cages[$cageIndex][0] -= $value;
                unset($cages[$cageIndex][2][$index]);
                $cages[$cageIndex][3] &= ~NUMBERS_BIN[$value];

                $check = findSumPermutations($cages[$cageIndex][0], $cages[$cageIndex][1], $cages[$cageIndex][3]);
                //TESTING[$cages[$cageIndex][0]][$cages[$cageIndex][1]] ?? 0;

                foreach($cages[$cageIndex][2] as $index2 => $filler) {
                    if(($possibleNumbers[$index2] &= $check) == 0) 
                    {
                        //error_log("imossible!!!!!!!!!!!!");
                        return;
                    }
                }  
            }
    
            $grid[$index] = $value;

            unset($positionsToFind[$index]);
            foreach($affectedPositions[$index] as $position => $filler) $possibleNumbers[$position] &= ~NUMBERS_BIN[$value];

            $numberFound = true;
        }

        /*
        foreach($cages as $cageIndex => [$value, $count, $list]) {
            //There's only one position in this cage that is still missing
            if($count == 1) {

                //error_log("only one for cage $cageIndex");

                $index = array_key_first($list);

                //The value missing to reach the sum of the cage is not a valid value for this position => invalid grid
                if(!isset(NUMBERS_BIN[$value]) || ($possibleNumbers[$index] & NUMBERS_BIN[$value]) == 0) return;

                unset($cages[$cageIndex]); ///We are done with this cage

                $grid[$index] = $value;

                unset($positionsToFind[$index]);
                foreach($affectedPositions[$index] as $position => $filler) $possibleNumbers[$position] &= ~NUMBERS_BIN[$value];

                $numberFound = true;
            }
        }*/

    } while($numberFound); //Restart the loop as long as some number have been found

    //error_log(var_export($possibleNumbers, true));
    //exit();

    //There are some positions with multiple possibilities
    if(count($positionsToFind) > 0) {

        $position = array_key_first($positionsToFind);
        $numbers = $possibleNumbers[$position];

        //Test each values for this position
        foreach(NUMBERS_BIN as $value => $check) {
            if(($numbers & $check) != 0) {
                $possibleNumbers[$position] = $check;

                //error_log("setting $position as $value");

                solve($grid, $possibleNumbers, $cages, $positionsToFind);
            } 
        }

        return;
    } 

    //We have found the solution
    for($y = 0; $y < 9; ++$y) {
        for($x = 0; $x < 9; ++$x) {
            $answer[$y][$x] += $grid[$y * 9 + $x];
        }
    }
}

$start = microtime(1);
$answer = array_fill(0, 9, array_fill(0, 9, 0));

fscanf(STDIN, "%d", $numPuzzles);

for($i = 0; $i < $numPuzzles; ++$i) {
    $grids[] = trim(fgets(STDIN));
}
for($i = 0; $i < $numPuzzles; ++$i) {
    $cageValues[] = trim(fgets(STDIN));
}

$affectedPositions2 = generateAffectedPositions();

//error_log(var_export(decbin(findSumPermutations(37, 6, 511)), true));
//exit();

error_log(microtime(1) - $start);

for($aaa = 0; $aaa < $numPuzzles; ++$aaa) {
    $affectedPositions = $affectedPositions2;
    $possibleNumbers = array_fill(0, 81, NUMBERS);
    $grid = str_repeat("0", 81);
    $positionsToFind = range(0, 80);
    $cagesPositions = [];
    $cagesMatch = [];
    $cages = [];
    $cagesSum = [];
    $cageIndex = 0;

    for($index = 0; $index < 81; ++$index) {
        $cagesPositions[$grids[$aaa][$index]][$index] = 1;
    }

    foreach(explode(" ", $cageValues[$aaa]) as $values) {
        [$name, $sum] = explode("=", $values);
    
        $cagesSum[$name] = $sum;
    }

    //error_log(var_export($cagesSum, true));

    foreach($cagesSum as $name => $sum) {

        $list = $cagesPositions[$name];

        $size = count($list);
        $list2 = array_keys($list);
        
        for($i = 0; $i < $size; ++$i) {
            for($j = $i + 1; $j < $size; ++$j) {
                $affectedPositions[$list2[$i]][$list2[$j]] = 1;
                $affectedPositions[$list2[$j]][$list2[$i]] = 1;
            }
        }

        foreach($list as $index => $filler) {
            $cagesMatch[$index][] = $cageIndex;
        }

        //error_log("cage $cageIndex is $name");
        $cages[$cageIndex++] = [intval($sum), $size, $list];

        if(count($list) == 1) continue;

        //error_log(var_export($name, true));

        $x = [];
        $y = [];
        $r = [];

        //Are they all on the same row
        foreach($list as $index => $filler) {
            [$x1, $y1] = [$index % 9, intdiv($index, 9)];

            $x[] = $x1;
            $y[] = $y1;
            $r[] = (intdiv($y1, 3) * 3) + intdiv($x1, 3);
        }

        if(count(array_unique($x)) == 1) {
            $cageX = reset($x);
            $listX = [];

            //Create a new cage
            for($y2 = 0; $y2 < 9; ++$y2) {
                $index = $y2 * 9 + $cageX;

                if(isset($list[$index])) continue;

                $listX[$index] = 1;
                $cagesMatch[$index][] = $cageIndex;
            }

            //error_log("cage $cageIndex is inv of $name H");
            $cages[$cageIndex++] = [45 - $sum, 9 - $size, $listX];
        }

        if(count(array_unique($y)) == 1) {
            $cageY = reset($y);
            $listY = [];

            //Create a new cage
            for($x2 = 0; $x2 < 9; ++$x2) {
                $index = $cageY * 9 + $x2;

                if(isset($list[$index])) continue;

                $listY[$index] = 1;
                $cagesMatch[$index][] = $cageIndex;
            }

            //error_log("cage $cageIndex is inv of $name V");
            $cages[$cageIndex++] = [45 - $sum, 9 - $size, $listY];
        }

        if(count(array_unique($r)) == 1) {
            $cageR = reset($r);
            $listR = [];

            //Create a new cage
            for($y2 = (intdiv($cageR, 3) * 3); $y2 < ((intdiv($cageR, 3) + 1) * 3); ++$y2) {
                for($x2 = ($cageR % 3) * 3; $x2 < (($cageR % 3) + 1) * 3; ++$x2) {
                    $index = $y2 * 9 + $x2;

                    if(isset($list[$index])) continue;
    
                    $listR[$index] = 1;
                    $cagesMatch[$index][] = $cageIndex;
                }
            }

            //error_log("cage $cageIndex is inv of $name R");
            $cages[$cageIndex++] = [45 - $sum, 9 - $size, $listR];
        }
        
    }

    //error_log(var_export($cagesMatch, true));
    //error_log(var_export($cages[10], true));

    //error_log(var_export($possibleNumbers, true));
    

    foreach($cages as $cageIndex => [$sum, $count, $list]) {
        /*
        $test = 0;

        foreach($list as $index => $filler) $test |= $possibleNumbers[$index];

        */

        $numbers = findSumPermutations($sum, $count, NUMBERS);

        //error_log("$cageIndex $sum $count " . decbin($numbers));

        foreach($list as $index => $filler) {
            $possibleNumbers[$index] &= $numbers;
        }

        $cages[$cageIndex][3] = $numbers;
    }

    error_log(microtime(1) - $start);
    //error_log(var_export($possibleNumbers, true));

    //exit();

    solve($grid, $possibleNumbers, $cages, $positionsToFind);
    //error_log(var_export($possibleNumbers, true));

    error_log("end of $aaa -- " . (microtime(1) - $start));
}

echo implode("\n", array_map(function($line) {
    return implode(" ", $line);
}, $answer)) . PHP_EOL;

error_log(var_export(count($memory), true));
