<?php
for($i = 0; $i < 4; ++$i) {
    fscanf(STDIN, "%s", $line);
    error_log(var_export($line, true));
    $grid[] = str_split($line);
}

//First step we get all the possibilites for the positions we have to find
for($y = 0; $y < 4; ++$y) {
    for($x = 0; $x < 4; ++$x) {
        //This number is missing
        if($grid[$y][$x] == 0) {
            $numbers = range(1, 4);

            //Check row & column
            for($i = 0; $i < 4; ++$i) {
                if($grid[$y][$i] != 0) unset($numbers[$grid[$y][$i] - 1]);
                if($grid[$i][$x] != 0) unset($numbers[$grid[$i][$x] - 1]);
            }

            //Check the square
            for($y2 = (floor($y / 2) * 2); $y2 < ((floor($y / 2) + 1) * 2); ++$y2) {
                for($x2 = (floor($x / 2) * 2); $x2 < ((floor($x / 2) + 1) * 2); ++$x2) {
                    if($grid[$y2][$x2] !== 0) unset($numbers[$grid[$y2][$x2] - 1]); 
                }
            }

            $listPositions[$y][$x] = $numbers; //We save the possibilites
            if(count($numbers) == 1) $toCheck[$x . " " . $y] = [$x, $y]; //There's only one possibillity for this position
        }
    }
}

while(count($toCheck)) {

    list($x, $y) = array_pop($toCheck);
    $value = array_pop($listPositions[$y][$x]);

    //Update the grid
    $grid[$y][$x] = $value;
    unset($listPositions[$y][$x]);

    //We can only use this number once in the row
    for($x2 = 0; $x2 < 4; ++$x2) {
        if($x2 == $x) continue; //The position we just set

        if(isset($listPositions[$y][$x2])) {
            unset($listPositions[$y][$x2][$value - 1]);

            //Only one possibility left
            if(count($listPositions[$y][$x2]) == 1) $toCheck[$x2 . " " . $y] = [$x2, $y];
        }
    }
     
    //We can only use this number once in the column
    for($y2 = 0; $y2 < 4; ++$y2) {
        if($y2 == $y) continue; //The position we just set

        if(isset($listPositions[$y2][$x])) {
            unset($listPositions[$y2][$x][$value - 1]);

            //Only one possibility left
            if(count($listPositions[$y2][$x]) == 1)  $toCheck[$x . " " . $y2] = [$x, $y2];
        }
    }
     
    //We can only use this number once in the square
    for($y2 = (floor($y / 2) * 2); $y2 < ((floor($y / 2) + 1) * 2); ++$y2) {
        for($x2 = (floor($x / 2) * 3); $x2 < ((floor($x / 2) + 1) * 2); ++$x2) {

            if($x2 == $x || $y2 == $y) continue; //Alredy checked

            if(isset($listPositions[$y2][$x2])) {
                unset($listPositions[$y2][$x2][$value - 1]);

                //Only one possibility left
                if(count($listPositions[$y2][$x2]) == 1) $toCheck[$x2 . " " . $y2] = [$x2, $y2];
            }
        }
    }
}

for ($i = 0; $i < 4; $i++) echo implode("", $grid[$i]) . "\n";
?>
