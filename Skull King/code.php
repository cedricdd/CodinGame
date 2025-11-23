<?php

function isBetterCard(string $c1, string $c2): bool {
    if($c1 == $c2) return false;
    elseif($c1 == 'S') return $c2 == 'M';
    elseif($c1 == 'P') return $c2 == 'S';
    elseif($c1 == 'M') return $c2 == 'P';
    elseif($c1 == 'F') return $c2 != 'F';
    else {
        preg_match("/([BYPG])([0-9]+)/", $c1, $m1);
        preg_match("/([BYPG])([0-9]+)/", $c2, $m2);

        if(count($m2) == 0) return $c2 != 'F';

        if($m1[1] == $m2[1]) return intval($m2[2]) > intval($m1[2]);
        else return $m2[1] == 'B';
    }
}

$start = microtime(1);
$cards = explode(" ", trim(fgets(STDIN)));
$cardIndex = 0;
$playerIndex = 0;

fscanf(STDIN, "%d", $nbPlayers);
fscanf(STDIN, "%d", $nbGames);

$players = array_fill(0, $nbPlayers, [0, null]);
$round = 1;

while($round <= $nbGames) {
    for($k = 0; $k < $round; ++$k) {
        //Give a card to each player
        for($i = 0; $i < $nbPlayers; ++$i) {
            $players[($playerIndex + $i) % $nbPlayers][1] = $cardIndex++ % 71;
        }

        $pirate = null;
        $mermaid = null;
        $king = null;
        $whale = null;

        for($i = 0; $i < $nbPlayers; ++$i) {
            $pIndex = ($playerIndex + $i) % $nbPlayers;
            $card = $cards[$players[$pIndex][1]];

            error_log("Player $pIndex has $card");

            //Check if any player has the Squid
            if($card == "Sq") continue 2;

            elseif($card == "P") $pirate = $pIndex;
            elseif($card == "M" && $mermaid === null) $mermaid = $pIndex;
            elseif($card == "S") $king = $pIndex;
            elseif($card == "W") $whale = $pIndex;
        }

        //Case #2 - at least one Pirate, at least one Mermaid and the Skull King are all played
        if($pirate !== null && $mermaid !== null && $king !== null) {
            $players[$mermaid][0]++;
            $playerIndex = $mermaid;
        } //Case #3 - the Whale is played
        elseif($whale !== null) {
            $winner = $playerIndex;
            $value = 0;

            for($j = 0; $j < $nbPlayers; ++$j) {
                preg_match("/[BYPG]([0-9]+)/", $cards[$players[($playerIndex + $j) % $nbPlayers][1]], $match);

                if($match && $match[1] > $value) {
                    $winner = ($playerIndex + $j) % $nbPlayers;
                    $value = $match[1];
                }
            }

            $players[$winner][0]++;
            $playerIndex = $winner;
        } //Case #4
        else {
            $winner = $playerIndex;
            $card = $cards[$players[$playerIndex][1]];

            for($i = 1; $i < $nbPlayers; ++$i) { 
                $pIndex = ($playerIndex + $i) % $nbPlayers;
                $pCard = $cards[$players[$pIndex][1]];

                if(isBetterCard($card, $pCard)) {
                    $winner = $pIndex;
                    $card = $pCard;
                }
            }

            $players[$winner][0]++;
            $playerIndex = $winner;
        }
    }

    ++$round;
}

echo implode(PHP_EOL, array_column($players, 0)) . PHP_EOL;

error_log(microtime(1) - $start);
