<?php

CONST POWER = [
    1 => 0, 2 => 1, 4 => 2, 8 => 3, 16 => 4, 32 => 5, 64 => 6, 128 => 7, 256 => 8, 512 => 9, 1024 => 10, 2048 => 11, 4096 => 12, 8192 => 13, 16384 => 14, 
    32768 => 15, 65536 => 16, 131072 => 17, 262144 => 18, 524288 => 19, 1048576 => 20, 2097152 => 21, 4194304 => 22, 8388608 => 23, 16777216 => 24,
];

//Pos 1 has 2, 6 & 7 has neighbors => 1100010
//Pos 2 has 1, 3, 6, 7 & 8 has neighbors => 11100101
CONST NEIGHBORS = [
    1 => 98, 2 => 229, 4 => 458, 8 => 916, 16 => 776, 32 => 3139, 64 => 7335, 128 => 14670, 256 => 29340, 512 => 24856, 1024 => 100448, 
    2048 => 234720, 4096 => 469440, 8192 => 938880, 16384 => 795392, 32768 => 3214336, 65536 => 7511040, 131072 => 15022080, 262144 => 30044160, 
    524288 => 25452544, 1048576 => 2195456, 2097152 => 5472256, 4194304 => 10944512, 8388608 => 21889024, 16777216 => 9175040,
];

//The possibles ways to sum with two distinct values
CONST SUMS = [
    3  => [[1, 2]],
    4  => [[1, 3]],
    5  => [[1, 4], [2, 3]],
    6  => [[1, 5], [2, 4]],
    7  => [[1, 6], [2, 5], [3, 4]],
    8  => [[1, 7], [2, 6], [3, 5]],
    9  => [[1, 8], [2, 7], [3, 6], [4, 5]],
    10 => [[1, 9], [2, 8], [3, 7], [4, 6]],
    11 => [[1, 10], [2, 9], [3, 8], [4, 7], [5, 6]],
    12 => [[1, 11], [2, 10], [3, 9], [4, 8], [5, 7]],
    13 => [[1, 12], [2, 11], [3, 10], [4, 9], [5, 8], [6, 7]],
    14 => [[1, 13], [2, 12], [3, 11], [4, 10], [5, 9], [6, 8]],
    15 => [[1, 14], [2, 13], [3, 12], [4, 11], [5, 10], [6, 9], [7, 8]],
    16 => [[1, 15], [2, 14], [3, 13], [4, 12], [5, 11], [6, 10], [7, 9]],
    17 => [[1, 16], [2, 15], [3, 14], [4, 13], [5, 12], [6, 11], [7, 10], [8, 9]],
    18 => [[1, 17], [2, 16], [3, 15], [4, 14], [5, 13], [6, 12], [7, 11], [8, 10]],
    19 => [[1, 18], [2, 17], [3, 16], [4, 15], [5, 14], [6, 13], [7, 12], [8, 11], [9, 10]],
    20 => [[1, 19], [2, 18], [3, 17], [4, 16], [5, 15], [6, 14], [7, 13], [8, 12], [9, 11]],
    21 => [[1, 20], [2, 19], [3, 18], [4, 17], [5, 16], [6, 15], [7, 14], [8, 13], [9, 12], [10, 11]],
    22 => [[1, 21], [2, 20], [3, 19], [4, 18], [5, 17], [6, 16], [7, 15], [8, 14], [9, 13], [10, 12]],
    23 => [[1, 22], [2, 21], [3, 20], [4, 19], [5, 18], [6, 17], [7, 16], [8, 15], [9, 14], [10, 13], [11, 12]],
    24 => [[1, 23], [2, 22], [3, 21], [4, 20], [5, 19], [6, 18], [7, 17], [8, 16], [9, 15], [10, 14], [11, 13]],
    25 => [[1, 24], [2, 23], [3, 22], [4, 21], [5, 20], [6, 19], [7, 18], [8, 17], [9, 16], [10, 15], [11, 14], [12, 13]],
];

//Check if a number is properly placed
function checkPlacement(array &$positions, int $number): bool {
    if($number < 3) return true;

    foreach(SUMS[$number] as [$a, $b]) {
        if(NEIGHBORS[$positions[$a]] & NEIGHBORS[$positions[$b]] & $positions[$number]) return true; 
    }

    return false;
}

//Get all the place we can place a number
function getPossiblePositions(array &$positions, int $unknown, int $number): int {

    if($number < 3) {
        //If 3 is already placed, we know that it's one of his neighbors
        if(isset($positions[3])) {
            $possiblePositions = NEIGHBORS[$positions[3]] & $unknown;
        } else {
            $possiblePositions = $unknown;
        }
    } 
    //The number can be placed on an empty place if 2 neighbors sums to the number
    else {
        $possiblePositions = 0;
        foreach(SUMS[$number] as [$a, $b]) {
            $possiblePositions |= NEIGHBORS[$positions[$a]] & NEIGHBORS[$positions[$b]] & $unknown;
        }
    }

    return $possiblePositions;
}

$positions = [];
$unknown = 0;
$index = 1;

for ($y = 0; $y < 5; ++$y) {
    foreach(explode(" ", fgets(STDIN)) as $x => $value) {
        $value = intval($value);
        $position = 1 << ($y * 5 + $x);

        if($value == 0) $unknown |= $position;
        else $positions[$value] = $position;
    }
}

//We have found a solution, print out the grid
function showGrid(array $positions) {
    global $start;

    $grid = array_fill(0, 25, 0);
    foreach($positions as $value => $position) {
        $grid[POWER[$position]] = $value;
    }
    
    echo implode("\n", array_map(function($line) {
        return implode(" ", $line);
    }, array_chunk($grid, 5)));
    
    exit();
}

function solve(array $positions, int $unknown, int $index) {

    if($index > 25) showGrid($positions); //All the numbers have been placed

    //The placement of the number has to be checked
    if(isset($positions[$index])) {
        if(checkPlacement($positions, $index)) {
            solve($positions, $unknown, $index + 1);
        }
    } //We have to place the number on an empty place
    else {
        $possiblePositions = getPossiblePositions($positions, $unknown, $index);

        for($i = 0; $i < 25; ++$i) {
            $position = 1 << $i;

            if($position & $possiblePositions) {
                $positions[$index] = $position;
                solve($positions, $unknown ^ $position, $index + 1);
            }
        }
    }
}

solve($positions, $unknown, 1);
?>
