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

//Get the distance between two points
function getDistance($source, $destination) {
    return sqrt(pow($destination[0] - $source[0], 2) + pow($destination[1] - $source[1], 2));
}

//Get the closest point in an array compared to a given position
function getClosest($position, $array) {
    $best = $array[0];
    $distance = getDistance($position, $best);
    for($i = 1; $i < count($array); ++$i) {
        $checkDistance = getDistance($position, $array[$i]);
        if($distance > $checkDistance) {
            $best = $array[$i];
            $distance = $checkDistance;
        }
    }

    return $best;
}

//Get the next position of Batman
function getNextPosition($x, $y) {
    global $possibleX, $possibleY;

    $firstX = array_key_first($possibleX);
    $lastX = array_key_last($possibleX);
    $centerX = ($firstX + $lastX) / 2;

    $firstY = array_key_first($possibleY);
    $lastY = array_key_last($possibleY);
    $centerY = ($firstY + $lastY) / 2;

    //We know where the bomb is
    if(count($possibleX) == 1 && count($possibleY) == 1) {
        return [$firstX, $firstY];
    } //We want to reduce the number of possible X positions
    elseif(count($possibleX) >= count($possibleY)) {
        //We are outside the zone where the bomb is
        if($x < $firstX || $x > $lastX) 
            return getClosest([$x, $y], [[$firstX, $firstY], [$lastX, $firstY], [$firstX, $lastY], [$lastX, $lastY]]);
        //We are on the center X position, move to the start
        elseif($x == $centerX) $x = $firstX;
        //Move to the postion on the opposite side of the X center
        else $x += ($centerX - $x) * 2;
    } //We want to reduce the number of possible Y positions
    else {
        //We are outside the zone where the bomb is
        if($y < $firstY || $y > $lastY)
            return getClosest([$x, $y], [[$firstX, $firstY], [$lastX, $firstY], [$firstX, $lastY], [$lastX, $lastY]]);
        //We are on the center Y position, move to the start
        elseif($y == $centerY) $y = $firstY;
        //Move to the postion on the opposite side of the Y center
        else $y += ($centerY - $y) * 2;
    }

    return [$x, $y];
}

// game loop
while (TRUE)
{
    // $bombDir: Current distance to the bomb compared to previous distance (COLDER, WARMER, SAME or UNKNOWN)
    fscanf(STDIN, "%s", $bombDir);

    //We can only eliminate position if we only moved on 1 axis
    if($current[0] == $previous[0] || $current[1] == $previous[1]) {
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
    } 

    $previous = $current;
    $current = getNextPosition($current[0], $current[1]);

    echo $current[0] . " " . $current[1] . "\n";
}
?>
