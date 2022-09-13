<?php

const MASKS = [1 => 432, 2 => 448, 3 => 216, 4 => 292, 5 => 186, 6 => 73, 7 => 54, 8 => 7, 9 => 27];
const WINNING_STATE = 495; //111101111

$state = str_replace(" ", "", trim(fgets(STDIN)) . trim(fgets(STDIN)) . trim(fgets(STDIN)));
$state = bindec(strtr($state, "~*", "01"));

//Apply all the changes already made
foreach(str_split(trim(fgets(STDIN))) as $digit) $state ^= MASKS[$digit];

//Search for the final button to reach the winning state
foreach(MASKS as $d => $mask) {
    if(($mask ^ $state) == WINNING_STATE) die("$d");
}
?>
