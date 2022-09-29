<?php

function sequence(int $i): int {
    if($i & 1) return ceil($i / 2) * -1;
    else return $i >> 1;
}

function placeGroup(int $size, int $row, int $col, int $numPersons): bool {

    global $w, $h, $cinema, $groupSuccess, $personSuccess;

    $groupString = str_repeat("0", $size);
    $maxJ = (max($row, $h - $row - 1) * 2) + 1;
    $maxI = (max($col, $w - $col - $size) * 2) + 1;

    for($y = 0; $y < $maxJ; ++$y) {
        $seqY = sequence($y); //Shift on top/bottom

        if($row + $seqY >= 0 && $row + $seqY < $h) {

            for($x = 0; $x < $maxI; ++$x) {
                $seqX = sequence($x); //Shift on left/right

                if($col + $seqX >= 0 && $col + $seqX <= $w - $size) {

                    //Check if we can add the group at the current position
                    if(substr($cinema[$row + $seqY], $col + $seqX, $size) === $groupString) {
                        //Mark all the seats as occupied
                        $cinema[$row + $seqY] = substr($cinema[$row + $seqY], 0, $col + $seqX) . str_repeat("1", $size) . substr($cinema[$row + $seqY], $col + $seqX + $size);
                        
                        //If we are on the initial row of the group, update success scores
                        if($seqY == 0) {
                            if($seqX < 0 && $col + $seqX + $size >= $col) $personSuccess += $size + $seqX;
                            elseif($seqX > 0 && $col + $seqX <= $col + $numPersons) $personSuccess += min($size, $numPersons - $seqX);
                            elseif($seqX == 0) {
                                if($size == $numPersons) $groupSuccess++; 
                                $personSuccess += $size;
                            }
                        }

                        return true;
                    }
                }
            }
        }
    }

    return false;
}

fscanf(STDIN, "%d %d", $h, $w);

$cinema = array_fill(0, $h, str_repeat("0", $w));
$groupSuccess = 0;
$personSuccess = 0;

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%d %d %d", $numPersons, $row, $col);

    $toPlace = [$numPersons];
        
    while(count($toPlace)) {
        $size = array_pop($toPlace);

        //Try to place the group
        $success = placeGroup($size, $row, $col, $numPersons);

        //Impossible to place the group, split it
        if($success == false) {
            array_push($toPlace, floor($size / 2), ceil($size / 2));
        } 
    }
}

echo $groupSuccess . " " . $personSuccess . PHP_EOL;
?>
