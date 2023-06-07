<?php

$start = microtime(1);

const REMOVE = [
    1 => 65534, 2 => 65533, 3 => 65531, 4 => 65527, 5 => 65519, 6 => 65503, 7 => 65471, 8 => 65407, 9 => 65279, 10 => 65023, 11 => 64511, 12 => 63487, 13 => 61439, 14 => 57343, 15 => 49151, 16 => 32767
];
const VALUES = [
    1 => 1, 2 => 2, 4 => 3, 8 => 4, 16 => 5, 32 => 6, 64 => 7, 128 => 8, 256 => 9, 512 => 10, 1024 => 11, 2048 => 12, 4096 => 13, 8192 => 14, 16384 => 15, 32768 => 16
];
const VALUES_INV = [
    1 => 1, 2 => 2, 3 => 4, 4 => 8, 5 => 16, 6 => 32, 7 => 64, 8 => 128, 9 => 256, 10 => 512, 11 => 1024, 12 => 2048, 13 => 4096, 14 => 8192, 15 => 16384, 16 => 32768
];

const ALPHABET = [
    1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E', 6 => 'F', 7 => 'G', 8 => 'H', 9 => 'I', 10 => 'J', 11 => 'K', 12 => 'L', 13 => 'M', 14 => 'N', 15 => 'O', 16 => 'P'
];

const FULL_NUMBERS = 65535;

$grid = "";

for ($i = 0; $i < 16; $i++) $grid .= trim(fgets(STDIN));

//Every row, col & square contains each numbers
$cages = array_fill(0, 48, [[], VALUES_INV]);

//First step we get all the possibilites for the numbers we have to find
for($y = 0; $y < 16; ++$y) {
    for($x = 0; $x < 16; ++$x) {
        
        $index = $y * 16 + $x;
        $colIndex = $x;
        $rowIndex = $y;
        $squareIndex = (intdiv($y, 4) * 4) + intdiv($x, 4);
        $squareY = intdiv($squareIndex, 4) * 4;
        $squareX = ($squareIndex % 4) * 4;
        
        //This number is missing
        if($grid[$index] == ".") {
            $numbers = FULL_NUMBERS;
            $affected = [];
            
            //Check row & column
            for($i = 0; $i < 16; ++$i) {
                $indexRow = intval($y * 16 + $i);
                
                if($grid[$indexRow] == ".") $affected[$indexRow] = 1; //Position to find
                else $numbers &= REMOVE[ord($grid[$indexRow]) - 64]; //Position already set
                
                $indexCol = intval($i * 16 + $x);
                
                if($grid[$indexCol] == ".") $affected[$indexCol] = 1; //Position to find
                else $numbers &= REMOVE[ord($grid[$indexCol]) - 64]; //Position already set
            }
            
            //Check the square
            for($y2 = $squareY; $y2 < $squareY + 4; ++$y2) {
                for($x2 = $squareX; $x2 < $squareX + 4; ++$x2) {
                    $indexSquare = intval($y2 * 16 + $x2);
                    
                    if($grid[$indexSquare] == ".") $affected[$indexSquare] = 1; //Position to find
                    else $numbers &= REMOVE[ord($grid[$indexSquare]) - 64]; //Position already set
                }
            }
            
            unset($affected[$index]); //Setting a position won't affect itself
            
            $possibleNumbers[$index] = $numbers; //We save the possibilities
            $positionToFind[$index] = 1; //This position we needs to be find
            $positionsAffected[$index] = array_keys($affected); //The positions to update when we set this position
            
            $cages[$rowIndex][0][$index] = 1;
            $cages[$colIndex + 16][0][$index] = 1;
            $cages[$squareIndex + 32][0][$index] = 1;
            $cagesMatch[$index] = [$rowIndex, $colIndex + 16, $squareIndex + 32]; //We save the cages this position belongs to
        } else {
            //This number is already set for the cages
            $number = ord($grid[$index]) - 64;
            
            unset($cages[$rowIndex][1][$number]);
            unset($cages[$colIndex + 16][1][$number]);
            unset($cages[$squareIndex + 32][1][$number]);
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
            
            $numbers = $possibleNumbers[$index];
            
            if(($numbers & ($numbers - 1))) continue; //It's not a power of 2
            
            $number = VALUES[$numbers];
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
        
        //We want to make a guess on the position with the less possibilities
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

echo implode("\n", str_split($grid, 16)) . "\n";

error_log((microtime(1) - $start));
error_log("Guess Made $guessMade");
