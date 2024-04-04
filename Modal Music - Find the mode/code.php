<?php

const NOTES = ['A' => 0,'A#' => 1,'Bb' => 1,'B' => 2, 'C' => 3,'C#' => 4,'Db' => 4,'D' => 5,'D#' => 6,'Eb' => 6,'E' => 7,'F' => 8,'F#' => 9,'Gb' => 9,'G' => 10,'G#' => 11,'Ab' => 11];

$modes = [
    "Ionian" => [2, 4, 5, 7, 9, 11],
    "Dorian" => [2, 3, 5, 7, 9, 10],
    "Phrygian" => [1, 3, 5, 7, 8, 10],
    "Lydian" => [2, 4, 6, 7, 9, 11],
    "Mixolydian" => [2, 4, 5, 7, 9, 10],
    "Aeolian" => [2, 3, 5, 7, 8, 10],
    "Locrian" => [1, 3, 5, 6, 8, 10],
];

$notes = explode(",", trim(fgets(STDIN)));

for($i = 1; $i < 7; ++$i) {
    $diff = (NOTES[$notes[$i]] - NOTES[$notes[0]] + 12) % 12;

    foreach($modes as $name => $list) {
        if($list[$i - 1] != $diff) unset($modes[$name]);
    }
}

echo $notes[0] . " " . array_key_first($modes) . PHP_EOL;
