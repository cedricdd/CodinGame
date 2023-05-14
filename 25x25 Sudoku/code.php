<?php

$start = microtime(1);

const REMOVE = [
    1 => 33554430, 2 => 33554429, 3 => 33554427, 4 => 33554423, 5 => 33554415,
    6 => 33554399, 7 => 33554367, 8 => 33554303, 9 => 33554175, 10 => 33553919,
    11 => 33553407, 12 => 33552383, 13 => 33550335, 14 => 33546239, 15 => 33538047,
    16 => 33521663, 17 => 33488895, 18 => 33423359, 19 => 33292287, 20 => 33030143,
    21 => 32505855, 22 => 31457279, 23 => 29360127, 24 => 25165823, 25 => 16777215,
];
const VALUES = [
    1 => 1, 2 => 2, 4 => 3, 8 => 4, 16 => 5,
    32 => 6, 64 => 7, 128 => 8, 256 => 9, 512 => 10,
    1024 => 11, 2048 => 12, 4096 => 13, 8192 => 14, 16384 => 15,
    32768 => 16, 65536 => 17, 131072 => 18, 262144 => 19, 524288 => 20,
    1048576 => 21, 2097152 => 22, 4194304 => 23, 8388608 => 24, 16777216 => 25,
];
const VALUES_INV = [
    1 => 1, 2 => 2, 3 => 4, 4 => 8, 5 => 16,
    6 => 32, 7 => 64, 8 => 128, 9 => 256, 10 => 512,
    11 => 1024, 12 => 2048, 13 => 4096, 14 => 8192, 15 => 16384,
    16 => 32768, 17 => 65536, 18 => 131072, 19 => 262144, 20 => 524288,
    21 => 1048576, 22 => 2097152, 23 => 4194304, 24 => 8388608, 25 => 16777216,
];

const ALPHABET = [
    1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E',
    6 => 'F', 7 => 'G', 8 => 'H', 9 => 'I', 10 => 'J',
    11 => 'K', 12 => 'L', 13 => 'M', 14 => 'N', 15 => 'O',
    16 => 'P', 17 => 'Q', 18 => 'R', 19 => 'S', 20 => 'T',
    21 => 'U', 22 => 'V', 23 => 'W', 24 => 'X', 25 => 'Y',
];
const FULL_NUMBERS = 33554431;

$grid = "";

for ($i = 0; $i < 25; $i++) {
    $grid .= trim(fgets(STDIN));
}

//Every row, col & square contains each numbers
$cages = array_fill(0, 75, [[], VALUES_INV]);

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
            $numbers = FULL_NUMBERS;
            $affected = [];
            
            //Check row & column
            for($i = 0; $i < 25; ++$i) {
                $indexRow = intval($y * 25 + $i);
                
                if($grid[$indexRow] == ".") $affected[$indexRow] = 1; //Position to find
                else $numbers &= REMOVE[ord($grid[$indexRow]) - 64]; //Position already set
                
                $indexCol = intval($i * 25 + $x);
                
                if($grid[$indexCol] == ".") $affected[$indexCol] = 1; //Position to find
                else $numbers &= REMOVE[ord($grid[$indexCol]) - 64]; //Position already set
            }
            
            //Check the square
            for($y2 = $squareY; $y2 < $squareY + 5; ++$y2) {
                for($x2 = $squareX; $x2 < $squareX + 5; ++$x2) {
                    $indexSquare = intval($y2 * 25 + $x2);
                    
                    if($grid[$indexSquare] == ".") $affected[$indexSquare] = 1; //Position to find
                    else $numbers &= REMOVE[ord($grid[$indexSquare]) - 64]; //Position already set
                }
            }
            
            unset($affected[$index]); //Setting a position won't affect itself
            
            $possibleNumbers[$index] = $numbers; //We save the possibilities
            $positionToFind[$index] = 1; //This position we needs to be find
            $positionsAffected[$index] = array_keys($affected); //The positions to update when we set this position
            
            $cages[$rowIndex][0][$index] = 1;
            $cages[$colIndex + 25][0][$index] = 1;
            $cages[$squareIndex + 50][0][$index] = 1;
            $cagesMatch[$index] = [$rowIndex, $colIndex + 25, $squareIndex +50]; //We save the cages this position belongs to
        } else {
            //This number is already set for the cages
            $number = ord($grid[$index]) - 64;
            
            unset($cages[$rowIndex][1][$number]);
            unset($cages[$colIndex + 25][1][$number]);
            unset($cages[$squareIndex + 50][1][$number]);
        }
    }
}

//Get the number of bits set to 1 (ie the number of possible numbers) in 0(1)
function getCountNumbers(int $mask): int {
    static $counts = [];
    
    if(isset($counts[$mask])) return $counts[$mask];
    
    $uCount = $mask - (($mask >> 1) & 033333333333) - (($mask >> 2) & 011111111111);
    return $counts[$mask] = (($uCount + ($uCount >> 3)) & 030707070707) % 63;
}

function setNumbers(string &$grid, array &$positionToFind, array &$possibleNumbers, array &$cages): int {
    
    global $positionsAffected, $cagesMatch;
    
    do {
        $numberFound = false;
        
        foreach($positionToFind as $index => $filler) {
            
            if(!isset(VALUES[$possibleNumbers[$index]])) continue; //There are still multiple possibilities for this position
            
            $number = VALUES[$possibleNumbers[$index]];
            $numberFound = true;
            
            //Update the grid
            $grid[$index] = ALPHABET[$number];
            
            //We can no longer use the number in any of the possitions that are affected by the current position
            foreach($positionsAffected[$index] as $indexToCheck) {
                //If another position has no possible number left it's an invalid grid
                if(($possibleNumbers[$indexToCheck] &= REMOVE[$number]) == 0) return -1;
            }
            
            unset($positionToFind[$index]);
            
            //Update all the cages that this position is part of
            foreach($cagesMatch[$index] as $cageIndex) {
                unset($cages[$cageIndex][0][$index]); //This position has been set
                unset($cages[$cageIndex][1][$number]); //This number has been set
            }
        }
        
        if($numberFound == false) {
            
            foreach($cages as $cagesIndex => [$cagePositions, $numbersToFind]) {
                
                //We group the positions in the cage by the numbers they can use
                $groups = [];

                foreach($cagePositions as $index => $filler)  {
                    $groups[$possibleNumbers[$index]][$index] = 1;
                }
                
                //If we have X positions that can use the same X numbers, we know none of the other positions in the cage can use any of these X numbers
                foreach($groups as $mask => $listPositions) {
                    
                    if(getCountNumbers($mask) == count($listPositions)) {
                        foreach($cagePositions as $index => $filler) {
                            //For all the other postions
                            if(!isset($listPositions[$index])) {
                                //If another position has no possible number left it's an invalid grid
                                if(($possibleNumbers[$index] &= ~$mask) == 0) return -1;
                            }
                        }
                    }
                }
                
                //For each number left to find in the cage we check if there's only position where it could be set
                foreach($numbersToFind as $value => $mask) {
        
                    $indexUnique = null;

                    foreach($cagePositions as $index => $filler) {
                        if($possibleNumbers[$index] & $mask) {
                            //There are at least 2 positions for this number
                            if($indexUnique !== null) continue 2;
                
                            $indexUnique = $index;
                        }
                    }
        
                    if($indexUnique === null) return -1; //There are no position left it's an invalid grid
                    else {
                        //There is only one position, we can set the number
                        $possibleNumbers[$indexUnique] = $mask;
                        $numberFound = 1;
                    }
                }
            }
        }
        
    } while ($numberFound);
    
    if(count($positionToFind) == 0) return 1;
    else return 0;
}

//Guess a number for the sudoku
function getGuess(int $index, array $possibleNumbers): int {
    
    $numbers = $possibleNumbers[$index];

    if($numbers == 0) return 0;
    
    foreach(VALUES_INV as $value => $mask) {
        
        //This is a possible number for the position
        if($numbers & $mask) return $value;
    }
    
    //All the possibilities for this position have been eliminated, invalid grid
    return 0;
}

$backups = [];
$guessMade = 0;

//Solve the sudoku
while(true) {
    
    //We start by setting all the positions with only one possibility
    $result = setNumbers($grid, $positionToFind,$possibleNumbers, $cages);
    
    if($result == 1) break; //Solution has been found
    
    //Until we find a guess to test
    while(true) {
        //Invalid grid, reload last backup
        if($result == -1) {
            [$grid, $positionToFind, $possibleNumbers, $cages] = array_pop($backups);
        }
        
        $min = INF;
        $indexToGuess = "";
        
        //We can to make a guess on the position with the less possibilities
        foreach($positionToFind as $index => $filler) {
            $numbers = $possibleNumbers[$index];
            
            $count = getCountNumbers($numbers);
            
            if($count < $min) {
                $indexToGuess = $index;
                $min = $count;
            }
            
            if($count <= 2) break;
        }
        
        $guess = getGuess($indexToGuess, $possibleNumbers);
        ++$guessMade;
         
        if($guess == 0) $result = -1; //No possible guess, invalid grid
        else {
            $possibleNumbers[$indexToGuess] &= REMOVE[$guess]; //Remove the guess for the backup
    
            $backups[] = [$grid, $positionToFind, $possibleNumbers, $cages]; //Create a backup
    
            $possibleNumbers[$indexToGuess] = VALUES_INV[$guess]; //Use the guess
            break;
        }
    }
}

echo implode("\n", str_split($grid, 25)) . "\n";

error_log((microtime(1) - $start));
error_log("Guess Made $guessMade");
