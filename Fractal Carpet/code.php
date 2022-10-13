<?php

function getPosition(int $x, int $y, int $L): string {

    $power = 3;

    for($i = 0; $i < $L; ++$i) {
        $xi = $x % $power; //X position relative to the level 
        $yi = $y % $power; //Y position relative to the level
        $min = $power * (1/3); //start of the center of the level
        $max = $power * (2/3); //end of the center of the level

        //Check if the position is at the center of the level, if so it's a "+"
        if($xi >= $min && $xi < $max && $yi >= $min && $yi < $max) return "+";

        $power *= 3;
    }

    return "0";
}

fscanf(STDIN, "%d", $L);
fscanf(STDIN, "%d %d %d %d", $x1, $y1, $x2, $y2);

for($y = $y1; $y <= $y2; ++$y) {
    $line = "";

    for($x = $x1; $x <= $x2; ++$x) {
        $line .= getPosition($x, $y, $L);
    }

    $output[] = $line;
}

echo implode("\n", $output) . PHP_EOL;
