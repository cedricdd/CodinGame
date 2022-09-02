<?php

const VALUES = [2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 'J' => 10, 'Q' => 10, 'K' => 10];

$bank = 0;
$bankCards = fgetcsv(STDIN, 0, " ");
//We have to check the aces last
usort($bankCards, function($a, $b) {
    return ($a == "A" ? 1 : 0) <=> ($b == "A" ? 1 : 0);
});

//Bank score
foreach($bankCards as $card) {
    if($card === "A") {
        $bank += ($bank + 11 > 21) ? 1 : 11;
    } else $bank += VALUES[$card];
}

$player = 0;
$playerCards = fgetcsv(STDIN, 0, " ");
//We have to check the aces last
usort($playerCards, function($a, $b) {
    return ($a == "A" ? 1 : 0) <=> ($b == "A" ? 1 : 0);
});

//Player score
foreach($playerCards as $card) {
    if($card === "A") {
        $player += ($player + 11 > 21) ? 1 : 11;
    } else $player += VALUES[$card];
}

if($player > 21) {
    if($bank > 21) echo "Draw\n";
    else echo "Bank\n";
} elseif($player < 21) {
    if($bank == $player) echo "Draw\n";
    elseif($bank > $player && $bank <= 21) echo "Bank\n";
    else echo "Player";
} else {
    if($bank == 21) {
        if(count($playerCards) == 2) {
            if(count($bankCards) == 2) echo "Draw\n";
            else echo "Blackjack!\n"; 
        } else {
            if(count($bankCards) == 2) echo "Blackjack!\n"; 
            else echo "Draw\n";
        }
    } else {
        if(count($playerCards) == 2) echo "Blackjack!\n";
        else "Player\n";
    } 
}
?>
