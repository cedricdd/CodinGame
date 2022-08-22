<?php

//Pos 1 has 2, 6 & 7 as neighbors => 1100010
//Pos 2 has 1, 3, 6, 7 & 8 as neighbors => 11100101
CONST NEIGHBORS = [
    0 => 98, 1 => 229, 2 => 458, 3 => 916, 4 => 776, 5 => 3139, 6 => 7335, 7 => 14670, 8 => 29340, 9 => 24856, 10 => 100448, 
    11 => 234720, 12 => 469440, 13 => 938880, 14 => 795392, 15 => 3214336, 16 => 7511040, 17 => 15022080, 18 => 30044160, 
    19 => 25452544, 20 => 2195456, 21 => 5472256, 22 => 10944512, 23 => 21889024, 24 => 9175040,
];

//Check if a number is properly placed
function checkPlacement(array &$positions, int $number): bool {
    if($number < 3) return true;

    $breakPoint = ($number + 1) >> 1; //We can stop when the sum can only be bigger
    for($i = 1; $i < $breakPoint; ++$i) {
        if(NEIGHBORS[$positions[$i]] & NEIGHBORS[$positions[$number - $i]] & (1 << $positions[$number])) return true; 
    }

    return false;
}

//Get all the place we can place a number
function getPossiblePositions(array &$positions, int $unknown, int $number): int {

    $possiblePositions = $unknown;

    if($number < 3) {
        //If 3 is already placed, we know that it's one of his neighbors
        if(isset($positions[3])) {
            $possiblePositions &= NEIGHBORS[$positions[3]];
        } 
        //If 4 is already placed, we know that it's one of his neighbors
        if($number == 1 && isset($positions[4])) {
            $possiblePositions &= NEIGHBORS[$positions[4]];
        } 

    } 
    //The number can be placed on an empty place if 2 neighbors sums to the number
    else {
        $possiblePositions = 0;
        $breakPoint = ($number + 1) >> 1; //We can stop when the sum can only be bigger
        for($i = 1; $i < $breakPoint; ++$i) {
            $possiblePositions |= NEIGHBORS[$positions[$i]] & NEIGHBORS[$positions[$number - $i]] & $unknown;
        }
    }

    return $possiblePositions;
}

$start = microtime(true);

$positions = [];
$unknown = 0;
$index = 1;

for ($y = 0; $y < 5; ++$y) {
    foreach(explode(" ", fgets(STDIN)) as $x => $value) {
        $value = intval($value);
        $position = $y * 5 + $x;

        if($value == 0) $unknown |= 1 << $position;
        else $positions[$value] = $position;
    }
}

//We have found a solution, print out the grid
function showGrid(array $positions) {
    global $start;

    $grid = array_fill(0, 25, 0);
    foreach($positions as $value => $position) {
        $grid[$position] = $value;
    }
    
    echo implode("\n", array_map(function($line) {
        return implode(" ", $line);
    }, array_chunk($grid, 5)));
    
    error_log(var_export("\n" . (microtime(true) - $start), true));
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

        //We have some spots to place the number
        if($possiblePositions) {     
            for($i = 0; $i < 25 && $possiblePositions; ++$i) {
                $power = 1 << $i;

                if($possiblePositions & $power) {
                    $positions[$index] = $i;
                    solve($positions, $unknown ^ $power, $index + 1);
                }
    
                $possiblePositions ^= $power; //We can stop the for loop when there's no possible position left
            }
        }

    }
}

solve($positions, $unknown, 1);
?>
