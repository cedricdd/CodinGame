<?php
for ($i = 0; $i < 9; $i++) {
    $line = stream_get_line(STDIN, 9 + 1, "\n");

    error_log(var_export($line, true));
    $grid[] = str_split($line);
}

$toCheck = [];

//First step we get all the possibilites for the numbers we have to find
for($y = 0; $y < 9; ++$y) {
    for($x = 0; $x < 9; ++$x) {
        //This number is missing
        if($grid[$y][$x] == 0) {
            $numbers = range(1, 9);

            //Check row & column
            for($i = 0; $i < 9; ++$i) {
                if($grid[$y][$i] != 0) unset($numbers[$grid[$y][$i] - 1]);
                if($grid[$i][$x] != 0) unset($numbers[$grid[$i][$x] - 1]);
            }

            //Check the square
            for($y2 = (floor($y / 3) * 3); $y2 < ((floor($y / 3) + 1) * 3); ++$y2) {
                for($x2 = (floor($x / 3) * 3); $x2 < ((floor($x / 3) + 1) * 3); ++$x2) {
                    if($grid[$y2][$x2] !== 0) unset($numbers[$grid[$y2][$x2] - 1]); 
                }
            }

            $listPositions[$y][$x] = $numbers; //We save the possibilites
            if(count($numbers) == 1) $toCheck[$x . " " . $y] = [$x, $y]; //There's only one possibillity for this position
        }
    }
}


function setNumbers(&$grid, &$listPositions) {

    global $toCheck;

    //Setting number might leave only 1 possibility for other position
    while(count($toCheck)) {

        list($x, $y) = array_pop($toCheck);
        $value = array_pop($listPositions[$y][$x]);

        //Update the grid
        $grid[$y][$x] = $value;
        unset($listPositions[$y][$x]);

        //We can only use this number once in the row
        for($x2 = 0; $x2 < 9; ++$x2) {
            if($x2 == $x) continue; //The position we just set

            if(isset($listPositions[$y][$x2])) {
                unset($listPositions[$y][$x2][$value - 1]);

                $count = count($listPositions[$y][$x2]);

                //There are no possibilities left, invalid grid
                if($count == 0) return -1;
                //Only one possibility left
                elseif($count == 1) $toCheck[$x2 . " " . $y] = [$x2, $y];
            }
        }
         
        //We can only use this number once in the column
        for($y2 = 0; $y2 < 9; ++$y2) {
            if($y2 == $y) continue; //The position we just set

            if(isset($listPositions[$y2][$x])) {
                unset($listPositions[$y2][$x][$value - 1]);

                $count = count($listPositions[$y2][$x]);

                //There are no possibilities left, invalid grid
                if($count == 0) return -1;
                //Only one possibility left
                elseif($count == 1)  $toCheck[$x . " " . $y2] = [$x, $y2];
            }
        }
         
        //We can only use this number once in the square
        for($y2 = (floor($y / 3) * 3); $y2 < ((floor($y / 3) + 1) * 3); ++$y2) {
            for($x2 = (floor($x / 3) * 3); $x2 < ((floor($x / 3) + 1) * 3); ++$x2) {

                if($x2 == $x || $y2 == $y) continue; //Alredy checked

                if(isset($listPositions[$y2][$x2])) {
                    unset($listPositions[$y2][$x2][$value - 1]);

                    $count = count($listPositions[$y2][$x2]);

                    //There are no possibilities left, invalid grid
                    if($count == 0) return -1;
                    //Only one possibility left
                    elseif($count == 1) $toCheck[$x2 . " " . $y2] = [$x2, $y2];
                }
            }
        }
    }

    //Have we a number on all the positions
    $numbersLeft = array_sum(array_map(function($array) {
        return count($array);
    }, $listPositions));

    if($numbersLeft == 0) return 1;
    else return 0;
}

//Guess a number for the sudoku
function getGuess(&$listPositions, $fobidden, &$toCheck) {

    foreach($listPositions as $y => $line) {    
        foreach($line as $x => $possibilities) {
            foreach($possibilities as $value) {

                //We already tried, we got an invalid grid
                if(isset($fobidden[$x . " " . $y . " " . $value])) continue; 

                $listPositions[$y][$x] = [$value];
                $toCheck[$x . " " . $y] = [$x, $y];

                return [$x, $y, $value];
            }

            //All the possibilites for this position are forbidden, invalid grid
            return [];
        }

    }

}

//Check if the grid is valid
function checkGrid($grid) {

    for($y = 0; $y < 9; ++$y) {
        for($x = 0; $x < 9; ++$x) {

            if(isset($checkR[$y][$grid[$y][$x] - 1])) return false;
            else $checkR[$y][$grid[$y][$x] - 1] = 1;

            if(isset($checkC[$x][$grid[$y][$x] - 1])) return false;
            else $checkC[$x][$grid[$y][$x] - 1] = 1;

            if(isset($checkS[intval($x / 3) + (intval($y / 3) * 3)][$grid[$y][$x] - 1])) return false;
            else $checkS[intval($x / 3) + (intval($y / 3) * 3)][$grid[$y][$x] - 1] = 1;
        }
    }

    return true;
}


$backups = [];
$forbidden = [];

//Solve the sudoky
while(true) {

    //We start by setting all the position with only one possibility
    $result = setNumbers($grid, $listPositions);

    //We have filled all the missing positions
    if($result == 1) {
        if(checkGrid($grid)) break; //Solution has been found
        else $result = -1; //Invalid grid
    }

    //Until we find a guess to test
    while(true) {
        $toCheck = [];

        //Invalid grid, reload last backup
        if($result == -1) {
            list($grid, $listPositions, $forbidden, $guess) = array_pop($backups);
            $forbidden[$guess] = 1;
        }

        $temp = $listPositions;
        //We have to guess a number
        $guess = getGuess($listPositions, $forbidden, $toCheck);

        //No possible guess, invalid grid
        if(count($guess) == 0) $result == -1;
        else {
            //We have a guess, backup info
            $backups[] = [$grid, $temp, $forbidden, implode(" ", $guess)];
            break;
        }
    }
}

for ($i = 0; $i < 9; $i++) echo implode("", $grid[$i]) . "\n";
?>
