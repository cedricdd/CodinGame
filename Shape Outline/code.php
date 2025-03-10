<?php

fscanf(STDIN, "%d", $H);
fscanf(STDIN, "%d", $W);
fscanf(STDIN, "%d", $S);

for ($i = 0; $i < $H; $i++) {
    $grid[] = str_split(trim(fgets(STDIN)));
}

$d = "RIGHT";
$y = 0;
$x = array_search('#', $grid[0]);
$history = [];
$edges = [$x * $S . " 0"];

while(true) {
    if(isset($history[$y][$x][$d])) break; //We are back at the start of the shape
    else $history[$y][$x][$d] = 1;

    if($d == "RIGHT") {
        //Switching UP
        if(($grid[$y - 1][$x + 1] ?? '.') == '#') {
            $edges[] = ($x + 1) * $S . " " . $y * $S;

            ++$x;
            --$y;
            $d = "UP";
        } //We continue RIGHT
        elseif(($grid[$y][$x + 1] ?? '.') == '#') {
            ++$x;
        } //Switching DOWN
        else {
            $edges[] = ($x + 1) * $S . " " . $y * $S;

            $d = "DOWN";
        }
    } elseif($d == "DOWN") {
        //Switching RIGHT
        if(($grid[$y + 1][$x + 1] ?? '.') == '#') {
            $edges[] = ($x + 1) * $S . " " . ($y + 1) * $S;

            ++$x;
            ++$y;
            $d = "RIGHT";
        } //We continue DOWN
        elseif(($grid[$y + 1][$x] ?? '.') == '#') {
            ++$y;
        } //Switching LEFT
        else {
            $edges[] = ($x + 1) * $S . " " . ($y + 1) * $S;

            $d = "LEFT";
        }
    } elseif($d == "LEFT") {
        //Switching DOWN
        if(($grid[$y + 1][$x - 1] ?? '.') == '#') {
            $edges[] = $x * $S . " " . ($y + 1) * $S;

            --$x;
            ++$y;
            $d = "DOWN";
        } //Continue LEFT
        elseif(($grid[$y][$x - 1] ?? '.') == '#') {
            --$x;
        } //Switching UP
        else {
            $edges[] = $x * $S . " " . ($y + 1) * $S;

            $d = "UP";
        }
    } elseif($d == "UP") {
        //Switching LEFT
        if(($grid[$y - 1][$x - 1] ?? '.') == '#') {
            $edges[] = $x * $S . " " . $y * $S;

            --$x;
            --$y;
            $d = "LEFT";
        } //Continue UP
        elseif(($grid[$y - 1][$x] ?? '.') == '#') {
            --$y;
        } //Switching RIGHT
        else {
            $edges[] = $x * $S . " " . $y * $S;

            $d = "RIGHT";
        }
    }
}

array_pop($edges); //The first edge is present twice, we drop the second one

echo implode(PHP_EOL, $edges) . PHP_EOL;
