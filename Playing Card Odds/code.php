<?php

//The starting deck
$cards = [
    "AC" => 1, "2C" => 1, "3C" => 1, "4C" => 1, "5C" => 1, "6C" => 1, "7C" => 1, "8C" => 1, "9C" => 1, "TC" => 1, "JC" => 1, "QC" => 1, "KC" => 1,
    "AD" => 1, "2D" => 1, "3D" => 1, "4D" => 1, "5D" => 1, "6D" => 1, "7D" => 1, "8D" => 1, "9D" => 1, "TD" => 1, "JD" => 1, "QD" => 1, "KD" => 1,
    "AH" => 1, "2H" => 1, "3H" => 1, "4H" => 1, "5H" => 1, "6H" => 1, "7H" => 1, "8H" => 1, "9H" => 1, "TH" => 1, "JH" => 1, "QH" => 1, "KH" => 1,
    "AS" => 1, "2S" => 1, "3S" => 1, "4S" => 1, "5S" => 1, "6S" => 1, "7S" => 1, "8S" => 1, "9S" => 1, "TS" => 1, "JS" => 1, "QS" => 1, "KS" => 1,
];

fscanf(STDIN, "%d %d", $N, $M);
//Remove all the cards that have been taken
for ($i = 0; $i < $N; $i++) {
    $removed = stream_get_line(STDIN, 15 + 1, "\n");

    preg_match("/^([0-9TJQKA]+)?([CDHS]+)?$/", $removed, $matches);

    foreach(str_split($matches[1] ?: "A23456789TJQK") as $r) {
        foreach(str_split($matches[2] ?? "CDHSS") as $s) {
            unset($cards[$r . $s]);
        }
    }
}


$cardsAvailable = [];
//Get all the cards we sought that still are available
for ($i = 0; $i < $M; $i++) {
    $sought = stream_get_line(STDIN, 15 + 1, "\n");

    preg_match("/^([0-9TJQKA]+)?([CDHS]+)?$/", $sought, $matches);

    foreach(str_split($matches[1] ?: "A23456789TJQK") as $r) {
        foreach(str_split($matches[2] ?? "CDHSS") as $s) {
            if(isset($cards[$r . $s])) $cardsAvailable[$r . $s] = 1; //Don't count the same card multiple times
        }
    }
}

echo round(count($cardsAvailable) / count($cards) * 100) . "%" . PHP_EOL;
