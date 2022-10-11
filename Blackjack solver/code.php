<?php

const VALUES = [2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 'J' => 10, 'Q' => 10, 'K' => 10];

function getScore(array $cards): array {
    //We have to check the aces last
    usort($cards, function($a, $b) { return ($a == "A" ? 1 : 0) <=> ($b == "A" ? 1 : 0); });

    $score = 0;

    foreach($cards as $card) {
        if($card === "A") $score += ($score + 11 > 21) ? 1 : 11;
        else $score += VALUES[$card];
    }

    return [$score, $score == 21 && count($cards) == 2];
}

[$bankScore, $bankBlackjack] = getScore(explode(" ", trim(fgets(STDIN))));
[$playerScore, $playerBlackjack] = getScore(explode(" ", trim(fgets(STDIN))));

if($playerBlackjack && !$bankBlackjack) echo "Blackjack!" . PHP_EOL;
elseif($playerScore > 21 || ($bankScore > $playerScore && $bankScore <= 21)) echo "Bank" . PHP_EOL;
elseif($playerScore == $bankScore) echo "Draw" . PHP_EOL;
else echo "Player" . PHP_EOL;
?>
