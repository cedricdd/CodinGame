<?php

// $W: width of the building.
// $H: height of the building.
fscanf(STDIN, "%d %d", $W, $H);
// $N: maximum number of turns before game over.
fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d %d", $X0, $Y0);

$possibleX = range(0, $W - 1);
$possibleY = range(0, $H - 1);

$current = [$X0, $Y0];
$previous = $current;

//Get the next position of Batman
function getNextPosition($x, $y) {
    global $possibleX, $possibleY, $outside, $W, $H;

    $firstX = array_key_first($possibleX);
    $lastX = array_key_last($possibleX);
    $firstY = array_key_first($possibleY);
    $lastY = array_key_last($possibleY);

    //We know where the bomb is
    if(count($possibleX) == 1 && count($possibleY) == 1) return [$firstX, $firstY];

    //We are searching for the X position
    if(count($possibleX) != 1) {
        //We are at the edges of the map, jump to the center of remaining X positions
        if ($x == 0 || $x == ($W - 1)) $newX = floor(($firstX + $lastX) / 2);
       
        else {
            //Get the mirror X from the center of the remaining X positions
            $newX = $firstX + $lastX - $x;

            //Make sure we stay inside the map
            $newX = max(0, min($newX, $W - 1));
        }

        //Make sure we don't get stuck on current position
        if ($newX == $x) $newX++;

        return [$newX, $y];

    } //We are searching for the Y position
    else {
        //We are at the edges of the map, jump to the center of remaining Y positions
        if ($y == 0 || $y == ($H - 1)) $newY = floor(($firstY + $lastY) / 2);
       
        else {
            //Get the mirror Y from the center of the remaining Y positions
            $newY = $firstY + $lastY - $y;

            //Make sure we stay inside the map
            $newY = max(0, min($newY, $H - 1));
        }

        //Make sure we don't get stuck on current position
        if ($newY == $y) $newY++;

        return [$x, $newY];
    }
}


// game loop
while (TRUE)
{
    // $bombDir: Current distance to the bomb compared to previous distance (COLDER, WARMER, SAME or UNKNOWN)
    fscanf(STDIN, "%s", $bombDir);

    switch($bombDir) {    
        case "WARMER":
            //We moved on X axis
            if($current[0] != $previous[0]) {
                foreach ($possibleX as $px) {
                    //If previous was closer or same distance on X axis, bomb can't be there -- if it was same distance we would have gotten SAME
                    if(abs($px - $current[0]) >= abs($px - $previous[0])) unset($possibleX[$px]);
                } 
            } //We moved on Y axis 
            else {
                foreach ($possibleY as $py) {
                    //If previous was closer or same distance on Y axis, bomb can't be there 
                    if(abs($py - $current[1]) >= abs($py - $previous[1])) unset($possibleY[$py]);
                } 
            }
            break;
        case "COLDER":
            //We moved on X axis
            if($current[0] != $previous[0]) {
                foreach ($possibleX as $px) {
                    //If current is closer or same distance on X axis, bomb can't be there 
                    if(abs($px - $current[0]) <= abs($px - $previous[0])) unset($possibleX[$px]);
                } 
            } //We moved on Y axis 
            else {
                foreach ($possibleY as $py) {
                    //If current is closer or same distance on Y axis, bomb can't be there 
                    if(abs($py - $current[1]) <= abs($py - $previous[1])) unset($possibleY[$py]);
                } 
            }
            break;
        case "SAME":
            //We moved on X axis
            if($current[0] != $previous[0]) {
                foreach ($possibleX as $px) {
                    //The bomb is on the middle X position 
                    if(($current[0] + $previous[0]) / 2 != $px) unset($possibleX[$px]);
                } 
            } //We moved on Y axis 
            else {
                foreach ($possibleY as $py) {
                    //The bomb is on the middle Y position
                    if(($current[1] + $previous[1]) / 2 != $py) unset($possibleY[$py]);
                } 
            }
            break;
    }

    $previous = $current;
    $current = getNextPosition($current[0], $current[1]);

    echo $current[0] . " " . $current[1] . "\n";
}
?>
