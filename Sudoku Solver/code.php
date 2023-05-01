<?php

$start = microtime(1);

$grid = "";

for ($i = 0; $i < 9; $i++) {
    $grid .= trim(fgets(STDIN));
}

$toCheck = [];

error_log($grid);

//First step we get all the possibilites for the numbers we have to find
for($y = 0; $y < 9; ++$y) {
    for($x = 0; $x < 9; ++$x) {
        $index = $y * 9 + $x;

        //This number is missing
        if($grid[$index] == 0) {
            $numbers = array_flip(range(1, 9));
            $related = [];

            //Check row & column
            for($i = 0; $i < 9; ++$i) {
                $indexRow = intval($y * 9 + $i);

                if($grid[$indexRow] == 0) $related[$indexRow] = 1;
                else unset($numbers[$grid[$indexRow]]);

                $indexCol = intval($i * 9 + $x);

                if($grid[$indexCol] == 0) $related[$indexCol] = 1;
                else unset($numbers[$grid[$indexCol]]);
            }

            //Check the square
            for($y2 = (floor($y / 3) * 3); $y2 < ((floor($y / 3) + 1) * 3); ++$y2) {
                for($x2 = (floor($x / 3) * 3); $x2 < ((floor($x / 3) + 1) * 3); ++$x2) {
                    $indexSquare = intval($y2 * 9 + $x2);

                    if($grid[$indexSquare] == 0) $related[$indexSquare] = 1;
                    else unset($numbers[$grid[$indexSquare]]);
                }
            }

            $possibilities[$index] = $numbers; //We save the possibilites
            $relations[$index] = $related;
            $counts[$index] = count($numbers);
            if(count($numbers) == 1) $toCheck[$index] = 1; //There's only one possibillity for this position
        }
    }
}


function setNumbers(&$grid, &$possibilities, &$relations, &$counts) {

    global $toCheck;

    //Setting number might leave only 1 possibility for other position
    do {
        $numberFound = false;

        foreach($counts as $index => $count) {

            if($count != 1) continue;

            $numberFound = true;

            $value = array_key_first($possibilities[$index]);
    
            //Update the grid
            $grid[$index] = $value;
            unset($possibilities[$index]);
    
            //We can only use this number once in the row
            foreach($relations[$index] as $indexToCheck => $filler) {
                if(isset($possibilities[$indexToCheck][$value])) {
                    unset($possibilities[$indexToCheck][$value]);
    
                    if(--$counts[$indexToCheck] == 0) return -1;
                }
            }
    
            unset($counts[$index]);
            unset($toCheck[$index]);
        }
    } while ($numberFound);

    if(count($possibilities) == 0) return 1;
    else return 0;
}

//Guess a number for the sudoku
function getGuess(array &$counts, array &$possibilities, array &$fobidden, array &$toCheck): bool {

    $index = array_key_first($counts);

    foreach($possibilities[$index] as $value => $filler) {

        //We already tried, we got an invalid grid
        if(isset($fobidden[$index][$value])) continue; 

        $fobidden[$index][$value] = 1;
        $possibilities[$index] = [$value => 1];
        $counts[$index] = 1;

        return true;
    }

    //All the possibilites for this position are forbidden, invalid grid
    return false;
}

$backups = [];
$forbidden = [];

//Solve the sudoky
while(true) {

    //We start by setting all the position with only one possibility
    $result = setNumbers($grid, $possibilities, $relations, $counts);

    if($result == 1) break; //Solution has been found

    //Until we find a guess to test
    while(true) {
        $toCheck = [];

        //error_log("need to guess");

        //Invalid grid, reload last backup
        if($result == -1) {
            [$grid, $possibilities, $relations, $forbidden, $counts] = array_pop($backups);
        }

        $temp = $possibilities;

        //No possible guess, invalid grid
        if(getGuess($counts, $possibilities, $forbidden, $toCheck) == false) $result == -1;
        else {
            //error_log("using guess");

            //We have a guess, backup info
            $backups[] = [$grid, $temp, $relations, $forbidden, $counts];
            break;
        }
    }
}

echo implode("\n", str_split($grid, 9)) . "\n";


error_log(microtime(1) - $start);
