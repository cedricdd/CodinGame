<?php

const VALUE = ["A" => 14, "K" => 13, "Q" => 12, "J" => 11];

foreach(explode(",", trim(fgets(STDIN))) as $input) {
    $tomDeck[] = substr($input, 0, -1);
}
foreach(explode(",", trim(fgets(STDIN))) as $input) {
    $samDeck[] = substr($input, 0, -1);
}

$turn = 0;

while(count($samDeck) && count($tomDeck)) {
    $tomCard = array_shift($tomDeck);
    $samCard = array_shift($samDeck);

    //It's not a draw
    if($tomCard != $samCard) {
        //Tom wins
        if(intval(strtr($tomCard, VALUE)) > intval(strtr($samCard, VALUE))) array_push($tomDeck, $samCard, $tomCard);
        //Sam wins
        else array_push($samDeck, $tomCard, $samCard);
    }

    ++$turn;
}

echo (count($tomDeck) ? "TOM " : (count($samDeck) ? "SAM " : "DRAW ")) . $turn . PHP_EOL;
