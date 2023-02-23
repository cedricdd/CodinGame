<?php

const NUMBERS = 511;
const NUMBERS_BIN = [1 => 1, 2 => 2, 3 => 4, 4 => 8, 5 => 16, 6 => 32, 7 => 64, 8 => 128, 9 => 256];

const BIN_DIG = [1 => 1, 2 => 2, 3 => 4, 4 => 8, 5 => 16, 6 => 32, 7 => 64, 8 => 128, 9 => 256];
const BIN_INV = [1 => 510, 2 => 509, 3 => 507, 4 => 503, 5 => 495, 6 => 479, 7 => 447, 8 => 383, 9 => 255];

const REGIONS_LIMITS = [
    [0, 0, 2, 2], [3, 0, 5, 2], [6, 0, 8, 2],
    [0, 3, 2, 5], [3, 3, 5, 5], [6, 3, 8, 5],
    [0, 6, 2, 8], [3, 6, 5, 8], [6, 6, 8, 8],
];
const REGIONS_COMBI = [
    [0], [1], [2], [3], [4], [5], [6], [7], [8], 
    [0, 1], [1, 2], [3, 4], [4, 5], [6, 7], [7, 8], [0, 3], [1, 4], [2, 5], [3, 6], [4, 7], [5, 8], 
    [3, 0, 1], [1, 2, 5], [5, 8, 7], [7, 6, 3], [4, 3, 0], [4, 3, 6], [4, 1, 0], [4, 1, 2], [4, 5, 2], [4, 5, 8], [4, 7, 8], [4, 7, 6], 
    [0, 1, 3, 4], [1, 2, 4, 5], [3, 4, 6, 7], [4, 5, 7 ,8]
];

const MAX = [1 => 1, 2 => 3, 3 => 7, 4 => 15, 5 => 31, 6 => 63, 7 => 127, 8 => 255, 9 => 511];
const MIN = [1 => 511, 2 => 510, 3 => 508, 4 => 504, 5 => 496, 6 => 480, 7 => 448, 8 => 384, 9 => 256];


const DEFAULT_CAGES = [
    [0, 1, 2, 3, 4, 5, 6, 7, 8], [9, 10, 11, 12, 13, 14, 15, 16, 17], [18, 19, 20, 21, 22, 23, 24, 25, 26], [27, 28, 29, 30, 31, 32, 33, 34, 35], [36, 37, 38, 39, 40, 41, 42, 43, 44], [45, 46, 47, 48, 49, 50, 51, 52, 53], [54, 55, 56, 57, 58, 59, 60, 61, 62], [63, 64, 65, 66, 67, 68, 69, 70, 71], [72, 73, 74, 75, 76, 77, 78, 79, 80], //ROWS
    [0, 9, 18, 27, 36, 45, 54, 63, 72], [1, 10, 19, 28, 37, 46, 55, 64, 73], [2, 11, 20, 29, 38, 47, 56, 65, 74], [3, 12, 21, 30, 39, 48, 57, 66, 75], [4, 13, 22, 31, 40, 49, 58, 67, 76], [5, 14, 23, 32, 41, 50, 59, 68, 77], [6, 15, 24, 33, 42, 51, 60, 69, 78], [7, 16, 25, 34, 43, 52, 61, 70, 79], [8, 17, 26, 35, 44, 53, 62, 71, 80], //COLS
    [0, 1, 2, 9, 10, 11, 18, 19, 20], [3, 4, 5, 12, 13, 14, 21, 22, 23], [6, 7, 8, 15, 16, 17, 24, 25, 26], [27, 28, 29, 36, 37, 38, 45, 46, 47], [30, 31, 32, 39, 40, 41, 48, 49, 50], [33, 34, 35, 42, 43, 44, 51, 52, 53], [54, 55, 56, 63, 64, 65, 72, 73, 74], [57, 58, 59, 66, 67, 68, 75, 76, 77], [60, 61, 62, 69, 70, 71, 78, 79, 80], //REGIONS
];

$memory = [];
$totalCages = 0;
$totalGuess = 0;
$totalCheck = 0;

function getDispersion(array $positions): array {
    $results = [];

    foreach($positions as $position) {
        $results["x"][$position % 9] = 1;
        $results["y"][intdiv($position, 9)] = 1;
    }

    return $results;
}

//Check if a list of positions all have unique digits, if they are in a single row or a single col
function checkUniqueDigits(array $positions): bool {
    $results = [];

    foreach($positions as $position) {
        $results["x"][$position % 9] = 1;
        $results["y"][intdiv($position, 9)] = 1;
    }

    if(count($results["x"]) == 1) return true; //All the positions are on the same column
    if(count($results["y"]) == 1) return true; //All the positions are on the same row
    return false;
}

//Check if a list of positions all have unique digits, if they are in a single row or a single col
function checkUniqueDigits2(array $positions): bool {
    $results = [];

    foreach(array_keys($positions) as $position) {
        $results["x"][$position % 9] = 1;
        $results["y"][intdiv($position, 9)] = 1;
    }

    if(count($results["x"]) == 1) return true; //All the positions are on the same column
    if(count($results["y"]) == 1) return true; //All the positions are on the same row
    return false;
}


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
            $result = findSumPermutations($sum, $count, $numbers & BIN_INV[$value]);

            //If by using the current digit there's a way to reach the sum
            if($solution = findSumPermutations($sum - $value, $count - 1, $numbers & BIN_INV[$value])) {
                $result |= $solution; //All digits we used in the recursion are part of the solution
                $result |= $binary; //The current digit is part of the solution
            }

            return $memory[$sum][$count][$numbers] = $result;
        }
    } 

    return $memory[$sum][$count][$numbers] = 0;
}

$memory2 = [];

function findSumPermutations2(int $sum, int $count, int $numbers): array {

    global $memory2;

    if(isset($memory2[$sum][$count][$numbers])) return $memory2[$sum][$count][$numbers];

    //Sum is too big, we reached the max # of digits or we used all the possible digits
    if($sum < 0 || $count == 0 || $numbers == 0) return [0, 0];

    //error_log("$sum $count $numbers");

    foreach(BIN_DIG as $value => $binary) {

        //If this digit can be used
        if($numbers & $binary) {

            if($count == 1 && $sum == $value) {
                //error_log("found one: $value $binary " . BIN_INV[$value]);
                return $memory2[$sum][$count][$numbers] = [$binary, BIN_DIG[$value]];
            }

            //Case where we don't use the current digit
            [$a, $b] = findSumPermutations2($sum, $count, $numbers & BIN_INV[$value]);

            //If by using the current digit there's a way to reach the sum
            [$c, $d] = findSumPermutations2($sum - $value, $count - 1, $numbers & BIN_INV[$value]);

            //error_log("sum $sum -- count $count -- numbers $numbers -- digit $value -- a $a -- b $b -- c $c -- d $d");

            if($c != 0) {
                if($a != 0) $b &= $d;
                else $b = ($d | BIN_DIG[$value]);

                $a = $a | $c | $binary;
            }

            //error_log("returned $a $b");

            return $memory2[$sum][$count][$numbers] = [$a, $b];
        }
    } 

    return $memory2[$sum][$count][$numbers] = [0, 0];
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
    global $cagesMatch, $affectedPositions, $answer, $totalGuess, $totalCheck, $maskInfo;

    $test = 5;

    while(true) {
    
        do {
            $numberFound = false;

            foreach($positionsToFind as $index => $filler) {

                ++$totalCheck;

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
                }

                $numberFound = true;
                $test = 5;
            }
        } while($numberFound); //Restart the loop as long as some digit has been found

        if(count($positionsToFind) == 0) break;

        
        foreach($cages as $cagesIndex => [$sum2, $count2, $positions2, $uniqueDigits]) {

            if($count2 == 1) {
                if(!isset(BIN_DIG[$sum2])) return;

                $possibleDigits[array_key_first($positions2)] = BIN_DIG[$sum2];
                $numberFound = true;
                //error_log("setting unique " . array_key_first($positions2) . " to $sum2");
                continue;
            }

            //error_log(var_export($positions2, true));

            foreach($positions2 as $pos1 => $filler1) {
                $sumMin2 = $sum2;
                $sumMax2 = $sum2;

                //error_log(var_export("working on $pos1", true));

                foreach($positions2 as $pos2 => $filler2) {
                    if($pos1 == $pos2) continue;

                    $sumMin2 -= $maskInfo[$possibleDigits[$pos2]]["max"];
                    $sumMax2 -= $maskInfo[$possibleDigits[$pos2]]["min"];
                }

                if($sumMax2 < 1 ) return;
                elseif($sumMax2 < 9)  $possibleDigits[$pos1] &= MAX[$sumMax2];
                
                if($sumMin2 > 9) return;
                elseif($sumMin2 > 1) $possibleDigits[$pos1] &= MIN[$sumMin2]; 
            }

            if($uniqueDigits) {

                //if($cagesIndex == 26) error_log(var_export($positions2, true));
                
                $testing = [];
                foreach($positions2 as $index => $filler)  {
                    $mask = $possibleDigits[$index];
                    $count33 = $maskInfo[$mask]["count"];
                    $string = $maskInfo[$mask]["string"];

                    if(!isset($testing[$count33][$string])) $testing[$count33][$string] = [$mask, []];
                    
                    array_push($testing[$count33][$string][1], $index);
                }

                //error_log(var_export($testing, true));

                foreach($testing as $number => $list) {
                    if($number >= $count2) continue;
                    foreach($list as $implode => [$mask, $indexList]) {
                        if($number == count($indexList)) {
                            //error_log("!!!!!!!!!!!!!!!$number $count2 $implode");
                            //error_log(var_export($testing, true));

                            foreach($positions2 as $index => $filler) {
                                if(!in_array($index, $indexList)) {
                                    //error_log("$index can't be $implode");
                                    $possibleDigits[$index] &= ~$mask;
                                }
                            }
                            //exit();
                        }
                    }
                }

                //We get all the digits that can still be used in the cage
                $digits = 0;
                foreach($positions2 as $cagePosition => $filler) $digits |= $possibleDigits[$cagePosition];

                [$a, $b] = findSumPermutations2($sum2, $count2, $digits);

                
                if($count2 > 1 && $b != 0) {

                    //error_log("$cagesIndex -- $sum2 $count2 $digits => $a $b");
                    //error_log(var_export($positions2, true));

                    foreach(BIN_DIG as $digit => $binary) {
                        if($binary & $b) {
                            //error_log(decbin($b) . " $digit is mandatory");

                            $position3 = null;
                            
                            foreach($positions2 as $cagePosition => $filler) {
                                //If one position is set to 0, the grid is invalid

                                //error_log("$cagePosition " . decbin($possibleDigits[$cagePosition]));

                                if($possibleDigits[$cagePosition] & $binary) {
                                    //error_log("$cagePosition can be $digit");

                                    if($position3 === null) {
                                        //error_log("first possibility");
                                        $position3 = $cagePosition;
                                    }
                                    else {
                                        //error_log("second possibility");
                                        continue 2;
                                    }
                                } //else error_log("$cagePosition can't");
                            }
                            
                            //error_log("$cagesIndex -- $sum2 $count2 $digits => $a $b");
                            //error_log("setting $position3 to $digit");

                            $possibleDigits[$position3] = $binary;
                            $numberFound = true;

                            break 2;
                        }
                    }
                } 
                
                if($a != NUMBERS) {
                    //Update all the positions left in the cage
                    foreach($positions2 as $cagePosition => $filler) {
                        //If one position is set to 0, the grid is invalid
                        if(($possibleDigits[$cagePosition] &= $a) == 0) return;
                    } 
                }
            } 
        }

        if(--$test == 0) break;
        
    }

    //error_log(var_export($possibleDigits[69], true));

    /*
    foreach($cagesMatch[59] as $cageIndex) {
        [$a, $b, $c, $d] = $cages[$cageIndex];

        error_log("$cageIndex -- $a $b $d");
        foreach($c as $e => $f) error_log($e . " " . decbin($possibleDigits[$e]));
    }*/





    //error_log("total possible left $count");


    /*
    if(count($positionsToFind) > 0) {
        error_log(var_export(str_split($grid, 9), true));
        error_log(var_export(substr_count($grid, "0"), true));
        error_log(var_export(count($cages), true));
    }
    */
    
    //There are some positions with multiple possibilities
    if(count($positionsToFind) > 0) {

        $position = array_key_last($positionsToFind);
        $numbers = $possibleDigits[$position];

        //Test each values for this position
        foreach(NUMBERS_BIN as $value => $binary) {
            if(($numbers & $binary) != 0) {
                $possibleDigits[$position] = $binary;

                ++$totalGuess;

                solve($grid, $possibleDigits, $cages, $positionsToFind);
            } 
        }

        return;
    } 
    
    /*
    foreach($positionsToFind as $index => $filler) {
       
        $digits = [];
        foreach(BIN_DIG as $digit => $binary) {
            if($possibleDigits[$index] & $binary) $digits[] = $digit;
        }

        error_log($index . " " . implode("-", $digits));
    }

    [$a, $b] = findSumPermutations2(27, 4, 424);
    error_log(decbin($a) . " -- " . decbin($b));

    [$a, $b] = findSumPermutations2(39, 6, 511);
    error_log(decbin($a) . " -- " . decbin($b));
 
 */


   //error_log($gridID . " " . $grid);
  

    //We have found the solution, add it to the answer
    for($y = 0; $y < 9; ++$y) {
        for($x = 0; $x < 9; ++$x) {
            $answer[$y][$x] += $grid[$y * 9 + $x];
        }
    }
}

function createCage(array $positions, int $sum, bool $uniqueDigits = true) {
    global $cageIndex, $cages, $knownCages, $cagesMatch;

    $count = count($positions);

    if($count == 0) return;

    ksort($positions);
    $index = implode("-", array_keys($positions));

    //We don't want to create the same cage multiple times
    if(isset($knownCages[$index])) return;
    else $knownCages[$index] = 1;

    //Create a link between the position and the cage
    foreach($positions as $position => $filler) {
        $cagesMatch[$position][] = $cageIndex;
    }

    //Create a new cage
    $cages[$cageIndex++] = [$sum, $count, $positions, $uniqueDigits];
}

function generateMaskInfo(int $mask = 0, int $index = 0, int $max = 0, int $min = 0, int $count = 0, string $string = "") {
    global $maskInfo;

    //We have reach 9 bits, it's over
    if($index == 9) {
        $maskInfo[$mask] = ["count" => $count, "min" => $min, "max" => $max, "string" => $string];
        return;
    }

    $binary = 2 ** $index;
    $index += 1;

    generateMaskInfo($mask, $index, $max, $min, $count, $string); //We set this position as 0

    if($min == 0) $min = $index; //If this is the first 1, it's the min digit

    generateMaskInfo($mask + $binary, $index, $index, $min, $count + 1, $string . $index); //We set this positions as 1
}

$startTime = microtime(1);
$answer = array_fill(0, 9, array_fill(0, 9, 0));

generateMaskInfo();

fscanf(STDIN, "%d", $numPuzzles);

for($i = 0; $i < $numPuzzles; ++$i) {
    $grids[] = trim(fgets(STDIN));
}
for($i = 0; $i < $numPuzzles; ++$i) {
    $cageValues[] = trim(fgets(STDIN));
}

$affected = generateAffectedPositions();

error_log("End init: " . (microtime(1) - $startTime));

for($gridID = 0; $gridID < $numPuzzles; ++$gridID) {
    $affectedPositions = $affected;
    $possibleDigits = array_fill(0, 81, NUMBERS);
    $grid = str_repeat("0", 81);
    $positionsToFind = range(0, 80);
    $cagesPositions = [];
    $cagesPositions2 = [];
    $cagesMatch = [];
    $cages = [];
    $cagesSum = [];
    $cageIndex = 0;
    $knownCages = [];
    $gridTime = microtime(1);

    //error_log(var_export(str_split($grids[$gridID], 9), true));

    foreach(DEFAULT_CAGES as $positions) {
        createCage(array_flip($positions), 45);
    }

    //Get all the positions in each cages
    for($position = 0; $position < 81; ++$position) {
        $cageName = $grids[$gridID][$position];
        $cagesPositions[$cageName][] = $position;
        $cagesPositions2[$cageName][$position] = 1;
    }

    //Get the sum of each cages
    foreach(explode(" ", $cageValues[$gridID]) as $values) {
        [$name, $sum] = explode("=", $values);
    
        $cagesSum[$name] = $sum;
    }

    foreach($cagesSum as $cageName => $cageSum) {

        $cagePositions = $cagesPositions2[$cageName];
 
        //The cage might links positions that are in a different col/row/region
        foreach($cagePositions as $position1 => $filler1) {
            foreach($cagePositions as $position2 => $filler2) {
                if($position1 == $position2) continue;

                $affectedPositions[$position1][$position2] = 1;
                $affectedPositions[$position2][$position1] = 1;
            }
        }

        createCage($cagePositions, intval($cageSum));
    }

    //Try to create more cages by using rows
    $uniqueCages = [];
    $partialCages = array_fill(0, 9, []);
    $fullCagesRow = array_fill(0, 9, ["total" => 0, "cages" => []]);
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
        foreach($uniqueCages[$y] as $nameCage => $sumCage) {
            if(count(array_diff($cagesPositions[$nameCage], $rows[$y])) == 0) {
                $fullCagesRow[$y][] = [$sumCage, $cagesPositions[$nameCage]];
                $fullCagesRow[$y]["total"] += $sumCage;
                $fullCagesRow[$y]["cages"][] = [$sumCage, $cagesPositions2[$nameCage]];
            }
            else {
                $partialCages[$y][$nameCage] = [$sumCage, $cagesPositions2[$nameCage]];
            }
        }

        $countFullCages = count($fullCagesRow[$y]["cages"]);

        /*
        * If there is at least 2 cages that is fully contained in the row
        *
        * EX:
        * bbcccdeee
        * fbbgddhii
        * ...
        * 
        * Cages 'c' & cage 'e' are fully contained in the row, hence we can find the sum of 'bb...dee', 'bbcccd...'
        */
        if($countFullCages > 0) {
            for($size = 1; $size <= $countFullCages; ++$size) {
                for($start = 0; $start <= $countFullCages - $size; ++$start) {
                    $usedCages = array_slice($fullCagesRow[$y]["cages"], $start, $size);

                    $listPositions = [];
                    $sumCages = 0;

                    foreach($usedCages as [$cageSum, $cagePositions]) {
                        $listPositions += $cagePositions;
                        $sumCages += $cageSum;
                    }

                    createCage(array_diff_key($rows[$y], $listPositions), 45 - $sumCages);
                }
            }
        }
    }

    //Use a group of cols, first from top to bottom, then bottom to top
    foreach([[0, 8], [8, 0]] as [$minY, $maxY]) {
        //Use a group of rows from 
        $fullCagesSum = 0;
        $partialCagesGroup = [];
        $rowsGroup = [];
        $totalSum = 0;
        $i = 0;

        for($y = $minY; $y <= $maxY; ++$y) {
            $fullCagesSum += $fullCagesRow[$y]["total"];; //Add the sum of all the cages that are fully contained in the row we are working on
            $partialCagesGroup += $partialCages[$y]; //Add the new partial group from the row we are working on
            $rowsGroup += $rows[$y]; //Add all the positions of the row we are working on
            $totalSum += 45;

            foreach($partialCagesGroup as $partialName => [$partialSum, $partialPositions]) {
                //This group is now fully contained in the group of cols
                if(count(array_diff_key($partialPositions, $rowsGroup)) == 0) {
                    $fullCagesSum += $partialSum;
                    unset($partialCagesGroup[$partialName]);
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

            //There are not partial cages in the group of regions, we check the next one
            if(count($partialCagesGroup) == 0) continue;

            //All the positions of the partial cages
            $partialPositions = [];
            $partialSum = 0;
    
            foreach($partialCagesGroup as [$cageSum, $cagePositions]) {
                $partialPositions += $cagePositions;
                $partialSum += $cageSum;
            }
    
            //All the positions OUTSIDE of the group of regions
            $outsidePositions = array_diff_key($partialPositions, $rowsGroup);
            $sumOutside = $partialSum - $totalSum + $fullCagesSum;
            $uniqueDigits = count($partialCagesGroup) == 1 || checkUniqueDigits2($outsidePositions);
    
            createCage($outsidePositions, $sumOutside, $uniqueDigits);
    
            //All the positions INSIDE of the group of regions
            $insidePositions = array_diff_key($partialPositions, $outsidePositions);
            $sumInside = $totalSum - $fullCagesSum;
            $uniqueDigits = count($partialCagesGroup) == 1 || checkUniqueDigits2($insidePositions);
    
            createCage($insidePositions, $sumInside, $uniqueDigits);
        }
    }
    
    //Try to create more cages on cols
    $uniqueCages = [];
    $fullCagesCol = array_fill(0, 9, ["total" => 0, "cages" => []]);
    $partialCages = array_fill(0, 9, []);
    $cols = [];

    for($x = 0; $x < 9; ++$x) {

        //Get all the uniques cages on the col
        for($y = 0; $y < 9; ++$y) {
            $position = $y * 9 + $x;
            $name = $grids[$gridID][$position];
            $uniqueCages[$x][$name] = $cagesSum[$name];
            $cols[$x][$position] = 1;
        }

        //Check if all the positions of each cages are all in the col
        foreach($uniqueCages[$x] as $nameCage => $sumCage) {
            if(count(array_diff_key($cagesPositions2[$nameCage], $cols[$x])) == 0) {
                $fullCagesCol[$x]["total"] += $sumCage;
                $fullCagesCol[$x]["cages"][] = [$sumCage, $cagesPositions2[$nameCage]];
            }
            else $partialCages[$x][$nameCage] = [$sumCage, $cagesPositions2[$nameCage]];
        }

        $countFullCages = count($fullCagesCol[$x]["cages"]);

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
        * Cages 'f' & cage 's' are fully contained in the col, hence we can find the sum of 'b...osxBB', 'bfffo.xBB'
        * The case where we remove all the fully contained cages in the col is done when working with combinaisons of cols
        */
        if($countFullCages > 1) {
            for($size = 1; $size < $countFullCages; ++$size) {
                for($start = 0; $start <= $countFullCages - $size; ++$start) {
                    $usedCages = array_slice($fullCagesCol[$x]["cages"], $start, $size);

                    $listPositions = [];
                    $sumCages = 0;

                    foreach($usedCages as [$cageSum, $cagePositions]) {
                        $listPositions += $cagePositions;
                        $sumCages += $cageSum;
                    }

                    createCage(array_diff_key($cols[$x], $listPositions), 45 - $sumCages);
                }
            }
        }
    }

    //Use a group of cols, first from left to right, then right to left
    foreach([[0, 8], [8, 0]] as [$minX, $maxX]) {
        $fullCagesSum = 0;
        $partialCagesGroup = [];
        $colsGroup = [];
        $totalSum = 0;

        for($x = $minX; $x <= $maxX; ++$x) {
            $fullCagesSum += $fullCagesCol[$x]["total"];
            $partialCagesGroup += $partialCages[$x];
            $colsGroup += $cols[$x];
            $totalSum += 45;
    
            foreach($partialCagesGroup as $partialName => [$partialSum, $partialPositions]) {
                //This group is now fully contained in the group of cols
                if(count(array_diff_key($partialPositions, $colsGroup)) == 0) {
                    $fullCagesSum += $partialSum;
                    unset($partialCagesGroup[$partialName]);
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

            //There are not partial cages in the group of regions, we check the next one
            if(count($partialCagesGroup) == 0) continue;
    
            //All the positions of the partial cages
            $partialPositions = [];
            $partialSum = 0;
    
            foreach($partialCagesGroup as [$cageSum, $cagePositions]) {
                $partialPositions += $cagePositions;
                $partialSum += $cageSum;
            }
    
            //All the positions OUTSIDE of the group of regions
            $outsidePositions = array_diff_key($partialPositions, $colsGroup);
            $sumOutside = $partialSum - $totalSum + $fullCagesSum;
            $uniqueDigits = count($partialCagesGroup) == 1 || checkUniqueDigits2($outsidePositions);
    
            createCage($outsidePositions, $sumOutside, $uniqueDigits);
    
            //All the positions INSIDE of the group of regions
            $insidePositions = array_diff_key($partialPositions, $outsidePositions);
            $sumInside = $totalSum - $fullCagesSum;
            $uniqueDigits = count($partialCagesGroup) == 1 || checkUniqueDigits2($insidePositions);
    
            createCage($insidePositions, $sumInside, $uniqueDigits);
        }
    }


    //Try to create more cages on regions
    $uniqueCages = [];
    $fullCagesReg = array_fill(0, 9, ["total" => 0, "cages" => []]);
    $partialCages = array_fill(0, 9, []);
    $regions = [];

    for($r = 0; $r < 9; ++$r) {

        [$startX, $startY, $endX, $endY] = REGIONS_LIMITS[$r];

        //Get all the uniques cages in the region
        for($y = $startY; $y <= $endY; ++$y) {
            for($x = $startX; $x <= $endX; ++$x) {
                $position = $y * 9 + $x;
                $nameCage = $grids[$gridID][$position];
                $uniqueCages[$r][$nameCage] = $cagesSum[$nameCage];
                $regions[$r][$position] = 1;
            }
        }

        //Check if all the positions of each cages are all in the region
        foreach($uniqueCages[$r] as $nameCage => $sumCage) {
            if(count(array_diff_key($cagesPositions2[$nameCage], $regions[$r])) == 0) {
                $fullCagesReg[$r]["total"] += $sumCage;
                $fullCagesReg[$r]["cages"][] = [$sumCage, $cagesPositions2[$nameCage]];
            }
            else $partialCages[$r][$nameCage] = [$sumCage, $cagesPositions2[$nameCage]];
        }

        $countFullCages = count($fullCagesReg[$r]["cages"]);

        /*
        * If there is at least 2 cages that are fully contained in the region
        *
        * EX:
        * ..abbbf..
        * ..aaccf..
        * ..addcf..
        * ...dde...
        * 
        * Cages 'b' & cage 'c' are fully contained in the region, hence we can find the sum of '...accddc', 'bbba..dd.' 
        * The case where we remove all the fully contained cages in the region is done when working with combinaisons of regions
        */
        if($countFullCages > 1) {
            for($size = 1; $size < $countFullCages; ++$size) {
                for($start = 0; $start <= $countFullCages - $size; ++$start) {
                    $usedCages = array_slice($fullCagesReg[$r]["cages"], $start, $size);

                    $listPositions = [];
                    $sumCages = 0;

                    foreach($usedCages as [$cageSum, $cagePositions]) {
                        $listPositions += $cagePositions;
                        $sumCages += $cageSum;
                    }

                    createCage(array_diff_key($regions[$r], $listPositions), 45 - $sumCages);
                }
            }
        }
    }

    //We have the info about the regions, create cages using combinaison of regions
    foreach(REGIONS_COMBI as $regionsUsed) {
        $fullCagesSum = 0;
        $partialCagesGroup = [];
        $regionsGroup = [];
        $totalSum = 0;

        foreach($regionsUsed as $r) {
            $fullCagesSum += $fullCagesReg[$r]["total"];
            $partialCagesGroup += $partialCages[$r];
            $regionsGroup += $regions[$r];
            $totalSum += 45;
        }

        foreach($partialCagesGroup as $partialName => [$partialSum, $partialPositions]) {
            //This group is now fully contained in the group of regions
            if(count(array_diff_key($partialPositions, $regionsGroup)) == 0) {
                $fullCagesSum += $partialSum;
                unset($partialCagesGroup[$partialName]);
            }
        }

        //There are not partial cages in the group of regions, we check the next one
        if(count($partialCagesGroup) == 0) continue;

        //All the positions of the partial cages
        $partialPositions = [];
        $partialSum = 0;

        foreach($partialCagesGroup as [$cageSum, $cagePositions]) {
            $partialPositions += $cagePositions;
            $partialSum += $cageSum;
        }

        //All the positions OUTSIDE of the group of regions
        $outsidePositions = array_diff_key($partialPositions, $regionsGroup);
        $sumOutside = $partialSum - $totalSum + $fullCagesSum;
        $uniqueDigits = count($partialCagesGroup) == 1 || checkUniqueDigits2($outsidePositions);

        createCage($outsidePositions, $sumOutside, $uniqueDigits);

        //All the positions INSIDE of the group of regions
        $insidePositions = array_diff_key($partialPositions, $outsidePositions);
        $sumInside = $totalSum - $fullCagesSum;
        $uniqueDigits = count($partialCagesGroup) == 1 || count($regionsUsed) == 1 || checkUniqueDigits2($insidePositions);

        createCage($insidePositions, $sumInside, $uniqueDigits);
    }

    //For each cages try to reduce the possible digits of their positions
    foreach($cages as $cageIndex => [$cageSum, $cageCount, $cagePositions, $uniqueDigits]) {

        if(!$uniqueDigits) continue;

        [$digitsSum, ] = findSumPermutations2($cageSum, $cageCount, NUMBERS);

        //Update all the positions in the cage
        foreach($cagePositions as $position => $filler) $possibleDigits[$position] &= $digitsSum;
    }

    //We want to work on positions that are part of the less cages first
    uksort($positionsToFind, function($a, $b) use ($cagesMatch) {
        return count($cagesMatch[$a]) <=> count($cagesMatch[$b]);
    });
    

    $totalCages += count($cages);

    solve($grid, $possibleDigits, $cages, $positionsToFind);

    error_log("Grid ID $gridID took: " . (microtime(1) - $gridTime));
}

echo implode("\n", array_map(function($line) {
    return implode(" ", $line);
}, $answer)) . PHP_EOL;

error_log("Total duration: " . (microtime(1) - $startTime));
error_log("Guess: $totalGuess -- Check: $totalCheck -- Cages: $totalCages");
