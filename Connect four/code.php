<?php

//Horizontal, Diagonal to-bottom-left, Vertical, Diagonal to-bottom-right
const PATTERN = [
    1 => "/1111|1.{6}1.{6}1.{6}1|1.{7}1.{7}1.{7}1|1.{8}1.{8}1.{8}1/", 
    2 => "/2222|2.{6}2.{6}2.{6}2|2.{7}2.{7}2.{7}2|2.{8}2.{8}2.{8}2/"
];

$grid = "";

for ($i = 0; $i < 6; ++$i) {
    $grid .= trim(fgets(STDIN)) . "#"; //For the diagonals we need to add a separator to lines
}

$winPositions = [1 => [], 2 => []];

for($x = 0; $x < 8; ++$x) {
    for($y = 5; $y >= 0; --$y) {
        $index = $y * 8 + $x;

        if($grid[$index] !== ".") continue;

        for($player = 1; $player <= 2; ++$player) {
            $grid[$index] = $player; //Simulate player adding a token here

            //Check if the player would be winning
            if(preg_match(PATTERN[$player], $grid, $match)) $winPositions[$player][] = $x;
        }

        $grid[$index] = "."; //Reset the position as empty

        continue 2;
    }
}

echo ((count($winPositions[1]) == 0) ? "NONE" : implode(" ", $winPositions[1])) . PHP_EOL;
echo ((count($winPositions[2]) == 0) ? "NONE" : implode(" ", $winPositions[2])) . PHP_EOL;
