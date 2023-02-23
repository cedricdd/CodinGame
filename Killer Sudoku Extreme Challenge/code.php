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



const POS_REG = [
    0 => 0, 1 => 0, 2 => 0, 9 => 0, 10 => 0, 11 => 0, 18 => 0, 19 => 0, 20 => 0,
    3 => 1,
    4 => 1,
    5 => 1,
    12 => 1,
    13 => 1,
    14 => 1,
    21 => 1,
    22 => 1,
    23 => 1,
    6 => 2,
    7 => 2,
    8 => 2,
    15 => 2,
    16 => 2,
    17 => 2,
    24 => 2,
    25 => 2,
    26 => 2,
    27 => 3,
    28 => 3,
    29 => 3,
    36 => 3,
    37 => 3,
    38 => 3,
    45 => 3,
    46 => 3,
    47 => 3,
    30 => 4,
    31 => 4,
    32 => 4,
    39 => 4,
    40 => 4,
    41 => 4,
    48 => 4,
    49 => 4,
    50 => 4,
    33 => 5,
    34 => 5,
    35 => 5,
    42 => 5,
    43 => 5,
    44 => 5,
    51 => 5,
    52 => 5,
    53 => 5,
    54 => 6,
    55 => 6,
    56 => 6,
    63 => 6,
    64 => 6,
    65 => 6,
    72 => 6,
    73 => 6,
    74 => 6,
    57 => 7,
    58 => 7,
    59 => 7,
    66 => 7,
    67 => 7,
    68 => 7,
    75 => 7,
    76 => 7,
    77 => 7,
    60 => 8,
    61 => 8,
    62 => 8,
    69 => 8,
    70 => 8,
    71 => 8,
    78 => 8,
    79 => 8,
    80 => 8,
];

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
        $results["r"][POS_REG[$position]] = 1;
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
    global $cagesMatch, $affectedPositions, $answer, $totalGuess, $totalCheck, $checkSolutions, $gridID;

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
                    //if($position == 21) error_log("21 can't be $value because of $index");
                    
                    if(($possibleDigits[$position] &= ~NUMBERS_BIN[$value]) == 0) {
                        //error_log("return now 0 $position");
                        return;
                    }
                }

                //Update all the cages that this position is part of
                foreach($cagesMatch[$index] as $cageIndex) {

                    //This was the last position to find in the region
                    if(--$cages[$cageIndex][1] == 0) {
                        if($value != $cages[$cageIndex][0]) {
                            //error_log("return bad sum $cageIndex");
                            return; //Sum of the cage doesn't match, invalid grid
                        }
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
                $sumMin = $sum2;
                $sumMax = $sum2;
                $test22 = [];

                //error_log(var_export("working on $pos1", true));

                foreach($positions2 as $pos2 => $filler2) {
                    if($pos1 == $pos2) continue;

                    $min = INF;
                    $max = -INF;

                    foreach(BIN_DIG as $digit => $binary) {
                        if($possibleDigits[$pos2] & $binary) {
                            if($digit < $min) $min = $digit;
                            if($digit > $max) $max = $digit;
                            $test22[$digit] = 1;
                        }
                    }

                    $sumMin -= $max;
                    $sumMax -= $min;
                }

                if(1==2) {
                    $test22 = array_keys($test22);
                    sort($test22);
                    //error_log(var_export($test22, true));

                    //$max = array_sum(array_slice($test22, -($count2 - 1)));

                    //error_log(var_export(array_slice($test22, -($count2 - 1)), true));
                    $min = $sum2 - array_sum(array_slice($test22, -($count2 - 1)));

                    if($min > 1) {
                        
                    //error_log(var_export("$sum2 $count2", true));
                    //error_log(var_export($test22, true));
                    //error_log(var_export(array_slice($test22, -($count2 - 1)), true));
                    //error_log(var_export("$pos1 can't be less than $min", true));

                    $possibleDigits[$pos1] &= MIN[$min];
                    //exit();
                    }

                    //error_log(var_export("$pos1 can't be less than $min", true));

                    $max = $sum2 - array_sum(array_slice($test22, 0, ($count2 - 1)));

                    if($max < 9) {
                        
                        //error_log(var_export("$sum2 $count2", true));
                        //error_log(var_export($test22, true));
                        //error_log(var_export(array_slice($test22, 0, ($count2 - 1)), true));
                        //error_log(var_export("$pos1 can't be more than $max", true));

                        $possibleDigits[$pos1] &= MAX[$max];
                    }

                    

                } else {
                    if($sumMax < 1 ) return;
                    elseif($sumMax < 9) {
                        //error_log("$sum2 $count2");
                        //error_log(var_export($positions2, true));
                        //error_log("$pos1 can't be more than $sumMax");

                        //error_log(var_export(decbin($possibleDigits[$pos1]), true));

                        $possibleDigits[$pos1] &= MAX[$sumMax];
                        
                        //error_log(var_export(decbin($possibleDigits[$pos1]), true));
                        //exit();
                    } 
                    
                    if($sumMin > 9) return;
                    elseif($sumMin > 1) {
                        //error_log("$sum2 $count2");
                        //error_log(var_export($positions2, true));
                        //error_log(var_export(decbin($possibleDigits[$pos1]), true));

                        $possibleDigits[$pos1] &= MIN[$sumMin];
                        
                        //error_log("$pos1 needs to be at least $sumMin -- " . MIN[$sumMin]);

                        //error_log(var_export(decbin($possibleDigits[$pos1]), true));
                        //exit();
                    }
                }
            }

            if($uniqueDigits) {
                if($count2 == 2) {
                    $pos1 = array_key_first($positions2);
                    $pos2 = array_key_last($positions2);
                    //error_log(var_export("$sum2 for $pos1 & $pos2", true));

                    foreach(BIN_DIG as $digit => $binary) {
                        if($possibleDigits[$pos1] & $binary) {
                            $updatedSum = $sum2 - $digit;
                            if($updatedSum < 1 || $updatedSum > 9 || ($possibleDigits[$pos2] & BIN_DIG[$updatedSum]) == false) {
                                //error_log("$pos1 can't be $digit");
                                $possibleDigits[$pos1] &= BIN_INV[$digit];
                            }
                        }
                        if($possibleDigits[$pos2] & $binary) {
                            $updatedSum = $sum2 - $digit;
                            if($updatedSum < 1 || $updatedSum > 9 || ($possibleDigits[$pos1] & BIN_DIG[$updatedSum]) == false) {
                                //error_log("$pos2 can't be $digit");
                                $possibleDigits[$pos2] &= BIN_INV[$digit];
                            }
                        }
                    }
                }

                if($count2 > 2) {
                    foreach($positions2 as $pos1 => $f1) {
                        $otherDigits = 0;
                        foreach($positions2 as $pos2 => $f2) {
                            if($pos2 == $pos1) continue;
                            $otherDigits |= $possibleDigits[$pos2];
                        }

                        foreach(BIN_DIG as $digit => $binary) {
                            if($possibleDigits[$pos1] & $binary) {
                                if(findSumPermutations($sum2 - $digit, $count2 - 1, $otherDigits) == 0) {
                                    //error_log("$pos1 can't be $digit");
                                    $possibleDigits[$pos1] &= BIN_INV[$digit];
                                }
                            }
                        }
                    }
                }

                //if($cagesIndex == 26) error_log(var_export($positions2, true));
                
                
                $testing = [];
                foreach($positions2 as $index => $filler) {
                    $digits = [];
                    $mask = NUMBERS;
                    foreach(NUMBERS_BIN as $value => $binary) {
                        if($possibleDigits[$index] & $binary) {
                            $digits[] = $value;  
                            $mask &= BIN_INV[$value];
                        }
                    }
                    if(!isset($testing[count($digits)][implode("-", $digits)])) $testing[count($digits)][implode("-", $digits)] = [$mask, []];
                    
                    array_push($testing[count($digits)][implode("-", $digits)][1], $index);
            
                    //error_log("$index " . implode("-", $digits));
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
                                    $possibleDigits[$index] &= $mask;
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

    $count = 0;
    foreach($positionsToFind as $index => $filler) {
        $digits = [];
        foreach(NUMBERS_BIN as $value => $binary) {
            if($possibleDigits[$index] & $binary) {
                $digits[] = $value;
                ++$count;
            }
        }

        error_log("$index " . implode("", $digits));
    }



    //error_log("total possible left $count");


    /*
    if(count($positionsToFind) > 0) {
        error_log(var_export(str_split($grid, 9), true));
        error_log(var_export(substr_count($grid, "0"), true));
        error_log(var_export(count($cages), true));
    }
    */
    /*
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

    sort($positions);
    $index = implode("-", $positions);

    //We don't want to create the same cage multiple times
    if(isset($knownCages[$index])) return;
    else $knownCages[$index] = 1;

    //Create a link between the position and the cage
    foreach($positions as $position) {
        $cagesMatch[$position][] = $cageIndex;
    }

    //Create a new cage
    $cages[$cageIndex++] = [$sum, $count, array_flip($positions), $uniqueDigits];
}

function createCage2(array $positions, int $sum, bool $uniqueDigits = true) {
    global $cageIndex, $cages, $knownCages, $cagesMatch;

    $count = count($positions);

    if($count == 0) return;

    sort($positions);
    $index = implode("-", $positions);

    //We don't want to create the same cage multiple times
    if(isset($knownCages[$index])) return;
    else $knownCages[$index] = 1;

    //Create a link between the position and the cage
    foreach($positions as $position) {
        $cagesMatch[$position][] = $cageIndex;
    }

    //Create a new cage
    $cages[$cageIndex++] = [$sum, $count, $positions, $uniqueDigits];
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
    $cagesPositions2 = [];
    $cagesMatch = [];
    $cages = [];
    $cagesSum = [];
    $cageIndex = 0;
    $knownCages = [];
    $gridTime = microtime(1);

    //error_log(var_export(str_split($grids[$gridID], 9), true));

    foreach(DEFAULT_CAGES as $positions) {
        createCage($positions, 45);
    }

    //Get all the positions in each cages
    for($position = 0; $position < 81; ++$position) {
        $cageName = $grids[$gridID][$position];
        $cagesPositions[$cageName][] = $position;
        $cagesPositions2[$cageName][$position] = $position;
    }

    //Get the sum of each cages
    foreach(explode(" ", $cageValues[$gridID]) as $values) {
        [$name, $sum] = explode("=", $values);
    
        $cagesSum[$name] = $sum;
    }

    foreach($cagesSum as $name => $sum) {

        $list = $cagesPositions[$name];
        $size = count($list);
        
        //The cage might links positions that are in a different col/row/region
        for($i = 0; $i < $size; ++$i) {
            for($j = $i + 1; $j < $size; ++$j) {
                $affectedPositions[$list[$i]][$list[$j]] = 1;
                $affectedPositions[$list[$j]][$list[$i]] = 1;
            }
        }

        createCage($list, intval($sum));
    }

    //Try to create more cages by using rows
    $uniqueCages = [];
    $fullCagesRow = array_fill(0, 9, []);
    $partialCages = array_fill(0, 9, []);
    $partialCages2 = array_fill(0, 9, []);
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
            else {
                $partialCages2[$y][$name] = [$sum, $cagesPositions[$name]];
                $partialCages[$y][$name] = $sum;
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
    }



    for($i = 0; $i < 9; ++$i) {

        //Use a group of rows from top to bottom
        $fullCagesSum = 0;
        $partialCagesGroup = [];
        $rowsGroup = [];

        for($y = $i; $y < 9; ++$y) {
            $fullCagesSum += array_sum(array_column($fullCagesRow[$y], 0)); //Add the sum of all the cages that are fully contained in the row we are working on
            $partialCagesGroup += $partialCages2[$y]; //Add the new partial group from the row we are working on
            $rowsGroup += $rows[$y]; //Add all the positions of the row we are working on

            foreach($partialCagesGroup as $name => [$sum, $positions]) {
                //This group is now fully contained in the group of col
                if(count(array_diff($positions, $rowsGroup)) == 0) {
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

                createCage(array_diff($cagesPositions[$name], $rowsGroup), $partialCagesGroup[$name][0] - (45 * ($y - $i + 1)) + $fullCagesSum);
                createCage(array_intersect($cagesPositions[$name], $rowsGroup), (45 * ($y - $i + 1)) - $fullCagesSum);
            } elseif(count($partialCagesGroup) > 1) { 
            
                //error_log(var_export($partialCages2[$x], true));

                $test = [];
                foreach($partialCagesGroup as $name => [$sum, $positions]) {
                    foreach($positions as $pos) $test[$pos] = $pos;
                }

                $inside = array_intersect($test, $rowsGroup);
                $di = getDispersion($inside);

                
                //error_log(var_export($test, true));
                //error_log(var_export($inside, true));
                //error_log(var_export($di, true));


                
                if(count($di["x"]) == 1 || count($di["y"]) == 1 ) {
                    //error_log(var_export($inside, true));
                    //error_log(var_export($di, true));

                    //error_log("before " . count($cages));
                    createCage($inside, (45 * ($y - $i + 1)) - $fullCagesSum);
                    //error_log("after " . count($cages));
                    //exit();
                } else {
                    createCage($inside, (45 * ($y - $i + 1)) - $fullCagesSum, false);
                }

                $outside = array_diff($test, $rowsGroup);
                $do = getDispersion($outside);

                if(count($do["x"]) == 1 || count($do["y"]) == 1 ) {
                    //error_log(var_export($outside, true));
                    //error_log(var_export($do, true));

                    
                    createCage($outside, array_sum(array_column($partialCagesGroup, 0)) - (45 * ($y - $i + 1)) + $fullCagesSum);
                    //error_log(var_export($outside, true));
                    //error_log(var_export(array_sum(array_column($partialCagesGroup, 0)) - (45 * ($x + 1)) + $fullCagesSum, true));
                }else {
                    createCage($outside, array_sum(array_column($partialCagesGroup, 0)) - (45 * ($y - $i + 1)) + $fullCagesSum, false);
                }
            }
        }
    }
    
    //Try to create more cages on cols
    $uniqueCages = [];
    $fullCagesCol = array_fill(0, 9, []);
    $partialCages2 = array_fill(0, 9, []);
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
            else {
                $partialCages2[$x][$name] = [$sum, $cagesPositions[$name]];
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
    }

    for($i = 0; $i < 9; ++$i) {
        //Use a group of cols from left to right
        $fullCagesSum = 0;
        $partialCagesGroup = [];
        $colsGroup = [];

        for($x = $i; $x < 9; ++$x) {
            $fullCagesSum += array_sum(array_column($fullCagesCol[$x], 0)); //Add the sum of all the cages that are fully contained in the col we are working on
            $partialCagesGroup += $partialCages2[$x]; //Add the new partial group from the col we are working on
            $colsGroup += $cols[$x]; //Add all the positions of the col we are working on

            foreach($partialCagesGroup as $name => [$sum, $positions]) {
                //This group is now fully contained in the group of col
                if(count(array_diff($positions, $colsGroup)) == 0) {
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
                //error_log(var_export($partialCagesGroup, true));

                $name = array_key_first($partialCagesGroup); //Name of the only cage not fully contained in the group of cols

                createCage(array_diff($cagesPositions[$name], $colsGroup), $partialCagesGroup[$name][0] - (45 * ($x - $i + 1)) + $fullCagesSum);
                createCage(array_intersect($cagesPositions[$name], $colsGroup), (45 * ($x - $i + 1)) - $fullCagesSum);
            } elseif(count($partialCagesGroup) > 1) { 
                //error_log(var_export("X is $x", true));
                //error_log(var_export($partialCages2[$x], true));

                $test = [];
                foreach($partialCagesGroup as $name => [$sum, $positions]) {
                    foreach($positions as $pos) $test[$pos] = $pos;
                }

                $inside = array_intersect($test, $colsGroup);
                $di = getDispersion($inside);

                
                //error_log(var_export($test, true));
                //error_log(var_export($inside, true));
                //error_log(var_export($di, true));


                
                if(count($di["x"]) == 1 || count($di["y"]) == 1 ) {
                    //error_log(var_export($inside, true));
                    //error_log(var_export($di, true));

                    //error_log("before " . count($cages));
                    createCage($inside, (45 * ($x - $i + 1)) - $fullCagesSum);
                    //error_log("after " . count($cages));
                    //exit();

                    //error_log(var_export((45 * ($x + 1)) - $fullCagesSum, true));
                    //error_log(var_export($inside, true));
                } else {
                    createCage($inside, (45 * ($x - $i + 1)) - $fullCagesSum, false);
                }

                $outside = array_diff($test, $colsGroup);
                $do = getDispersion($outside);

                if(count($do["x"]) == 1 || count($do["y"]) == 1 ) {
                    //error_log(var_export($outside, true));
                    //error_log(var_export($do, true));

                    
                    createCage($outside, array_sum(array_column($partialCagesGroup, 0)) - (45 * ($x - $i + 1)) + $fullCagesSum);
                    //error_log(var_export($outside, true));
                    //error_log(var_export(array_sum(array_column($partialCagesGroup, 0)) - (45 * ($x + 1)) + $fullCagesSum, true));

                    //exit();
                } else {
                    //error_log(var_export($cageIndex, true));
                    createCage($outside, array_sum(array_column($partialCagesGroup, 0)) - (45 * ($x - $i + 1)) + $fullCagesSum, false);

                    //error_log(var_export($outside, true));
                    //error_log(var_export(array_sum(array_column($partialCagesGroup, 0)) - (45 * ($x - $i + 1)) + $fullCagesSum, true));
                }
            }
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
                $regions[$r][$position] = $position;
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
    }

    //We have the info about the regions, create cages using combinaison of regions
    foreach(REGIONS_COMBI as $regionsUsed) {
        $fullCagesSum = 0;
        $partialCagesGroup = [];
        $regionsGroup = [];

        foreach($regionsUsed as $r) {
            $fullCagesSum += $fullCagesReg[$r]["total"];
            $partialCagesGroup += $partialCages[$r];
            $regionsGroup += $regions[$r];
        }

        foreach($partialCagesGroup as $partialName => [$partialSum, $partialPositions]) {
            //This group is now fully contained in the group of regions
            if(count(array_diff($partialPositions, $regionsGroup)) == 0) {
                $fullCagesSum += $partialSum;
                unset($partialCagesGroup[$partialName]);
            }
        }

        //There are not partial cages in the group of regions, we check next one
        if(count($partialCagesGroup) == 0) continue;

        //All the positions of the partial cages
        $partialPositions = array_merge(...array_column($partialCagesGroup, 1));

        //All the positions OUTSIDE of the group of regions
        $outsidePositions = array_diff($partialPositions, $regionsGroup);
        $sumOutside = array_sum(array_column($partialCagesGroup, 0)) - (45 * count($regionsUsed)) + $fullCagesSum;
        $uniqueDigits = count($partialCagesGroup) == 1 || checkUniqueDigits($outsidePositions);

        createCage($outsidePositions, $sumOutside, $uniqueDigits);

        //All the positions INSIDE of the group of regions
        $insidePositions = array_diff($partialPositions, $outsidePositions);
        $sumInside = (45 * count($regionsUsed)) - $fullCagesSum;
        $uniqueDigits = count($partialCagesGroup) == 1 || count($regionsUsed) == 1 || checkUniqueDigits($insidePositions);

        createCage($insidePositions, $sumInside, $uniqueDigits);
    }

    for($r = 0; $r < 9; ++$r) {
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
        */
        if($countFullCages > 1) {
            for($size = 1; $size < $countFullCages; ++$size) {
                for($start = 0; $start <= $countFullCages - $size; ++$start) {
                    $usedCages = array_slice($fullCagesReg[$r]["cages"], $start, $size);

                    $listPositions = array_merge(...array_column($usedCages, 1));
                    $sumCages = array_sum(array_column($usedCages, 0));

                    createCage(array_diff($regions[$r], $listPositions), 45 - $sumCages);
                }
            }
        }
    }

    for($y = 0; $y < 9; ++$y) {

        //$fullCages = array_merge($fullCagesRow[$y], $fullCagesRowCreated[$y]);
        $fullCages = array_merge($fullCagesRow[$y]);
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
                    $list = [];

                    foreach(array_column($usedCages, 1) as $testlist) {
                        foreach($testlist as $test) {
                            if(isset($list[$test])) continue 3;
                            $list[$test] = $test;
                        }
                    }

                    $sum = array_sum(array_column($usedCages, 0));

                    createCage(array_diff($rows[$y], $list), 45 - $sum);

                    //We are using multiples cages, also create a new cage that's a combination of these cages
                    if($size > 1 && count($list) != 9) {
                        //createCage($list, $sum);
                    }
                }
            }
        }
    }

    for($x = 0; $x < 9; ++$x) {

        //$fullCages = array_merge($fullCagesCol[$x], $fullCagesColCreated[$x]);
        $fullCages = array_merge($fullCagesCol[$x]);
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
                    $list = [];

                    foreach(array_column($usedCages, 1) as $testlist) {
                        foreach($testlist as $test) {
                            if(isset($list[$test])) continue 3;
                            $list[$test] = $test;
                        }
                    }

                    $sum = array_sum(array_column($usedCages, 0));

                    createCage(array_diff($cols[$x], $list), 45 - $sum);

                    //We are using multiples cages, also create a new cage that's a combination of these cages
                    if($size > 1 && count($list) != 9) {
                        //createCage($list, $sum);
                    }
                }
            }
        }
    }

    //For each cages try to reduce the possible digits of their positions
    foreach($cages as $cageIndex => [$sum, $count, $list, $isUnique]) {

        if(!$isUnique) continue;

        $digitsSum = findSumPermutations($sum, $count, NUMBERS);

        //Update all the positions in the cage
        foreach($list as $position => $filler) {
            $possibleDigits[$position] &= $digitsSum;
        }
    }

    //error_log(var_export($possibleDigits, true));

    /*
    //When we update a position we want to work on cages with the less positions first
    foreach($cagesMatch as $a => &$list) {
        uasort($list, function($a, $b) use ($cages) {
            return $cages[$a][1] <=> $cages[$b][1];
        });
    }
    //We want to work on positions that are part of the less cages first
    uksort($positionsToFind, function($a, $b) use ($cagesMatch) {
        return count($cagesMatch[$a]) <=> count($cagesMatch[$b]);
    });
    */

    $totalCages += count($cages);

    solve($grid, $possibleDigits, $cages, $positionsToFind);

    //error_log("Grid ID $gridID -- $totalGuess -- took: " . (microtime(1) - $gridTime));
}

echo implode("\n", array_map(function($line) {
    return implode(" ", $line);
}, $answer)) . PHP_EOL;

error_log("Total duration: " . (microtime(1) - $startTime));
error_log("Guess: $totalGuess -- Check: $totalCheck -- Cages: $totalCages");
