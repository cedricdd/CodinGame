<?php

fscanf(STDIN, "%d", $n);
$deck = explode(" ", trim(fgets(STDIN)));

while($n-- > 0) {
    $size = count($deck) / 2;
    [$left, $right] = array_chunk($deck, ceil($size)); //Split the deck of cards
    $sorted = [];

    for($i = 0; $i < floor($size); ++$i) {
        //Picking alternatively one card from each
        array_push($sorted, array_shift($left), array_shift($right));
    }

    //The deck has a odd number of cards, we need to add the last one
    if(count($left)) array_push($sorted, array_shift($left));

    $deck = $sorted;
}

echo implode(" ", $deck) . PHP_EOL;
