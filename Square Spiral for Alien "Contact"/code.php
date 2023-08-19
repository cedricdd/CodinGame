<?php

const DIRECTION = [[1, 0], [0, 1], [-1, 0], [0, -1]];

preg_match("/([0-9]+) ([a-zA-Z]+) (clockwise|counter\-clockwise) ([A-Z])([0-9]+) ([A-Z])([0-9]+)/", trim(fgets(STDIN)), $instructions);

$alphabet = range("A", "Z");
$size = $instructions[1];
$spiral = array_fill(0, $size, str_repeat(" ", $size));

switch($instructions[2]) {
    case "topLeft": 
        $x = 0;
        $y = 0;
        $direction = 0;
        break;
    case "topRight": 
        $x = $size - 1;
        $y = 0;
        $direction = 1;
        break;
    case "bottomRight": 
        $x = $size - 1;
        $y = $size - 1;
        $direction = 2;
        break;
    case "bottomLeft": 
        $x = 0;
        $y = $size - 1;
        $direction = 3;
        break;
}

if($instructions[3] != "clockwise") $direction = ($direction + 1) % 4;
$positionCharacter = ord($instructions[4]) - 65;
$jumpCharacter = ord($instructions[6]) - ord($instructions[4]);
$directiontionChanges = -1;
$length = $size - 1;
$characterUsage = 0;
$limitCharacter = $instructions[5];

while(true) {
    for($i = 0; $i < $length; ++$i) {
        $spiral[$y][$x] = $alphabet[$positionCharacter];

        //We need to change the character that's gonna be displayed
        if(++$characterUsage == $limitCharacter) {
            $positionCharacter += $jumpCharacter;

            //We reached the end of the alphabet
            if($positionCharacter > 25 || $positionCharacter < 0) break 2;

            $characterUsage = 0;
            $limitCharacter += $instructions[7] - $instructions[5]; //Update the # of characters based on instructions
        }

        $x += DIRECTION[$direction][0];
        $y += DIRECTION[$direction][1];
    }

    //We are changing direction
    $direction = ($direction + ($instructions[3] == "clockwise" ? 1 : -1) + 4) % 4;

    //The length is updating
    if(++$directiontionChanges && $directiontionChanges % 2 == 0) {
        //We have reached the center of the spiral
        if(($length -= 2) < 1) {
            $spiral[$y][$x] = $alphabet[$positionCharacter];
            break;
        }
    }
}

//We limit the output to the first 31 lines and the first 31 characters per lines
echo implode("\n", array_map(function($line) {
    return substr($line, 0, 31);
}, array_slice($spiral, 0, 31))) . PHP_EOL;
