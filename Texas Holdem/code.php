<?php

const HANDS = ["HIGH_CARD" => 0, "PAIR" => 1, "TWO_PAIR" => 2, "THREE_OF_A_KIND" => 3, "STRAIGHT" => 4,
    "FLUSH" => 5, "FULL_HOUSE" => 6, "FOUR_OF_A_KIND" => 7, "STRAIGHT_FLUSH" => 8];

const VALUES = ['A' => 14, 'K' => 13, 'Q' => 12, 'J' => 11, 'T' => 10, 
    '9' => 9, '8' => 8, '7' => 7, '6' => 6, '5' => 5, '4' => 4, '3' => 3, '2' => 2];

function checkForStraight(array $cards): string {
    //Get the values
    $values = array_unique(array_map(function($card) { return $card[0]; }, $cards));

    //Not enough different cards for a straight
    if(count($values) < 5) return "";

    //Sort the values
    usort($values, function($a, $b) {
        return VALUES[$b] <=> VALUES[$a];
    });

    //Search for a straight - 5 consecutive cards
    for($i = 0; $i <= count($values) - 5; ++$i) {
        if(VALUES[$values[$i]] - VALUES[$values[$i + 4]] == 4) {
            return implode("", array_slice($values, $i, 5));  
        }
    }

    //Straight with low A -- if 5 is the 4th value from the end and A is the first
    if($values[count($values) - 4] == 5 && $values[0] == 'A') {
        return "5432A";  
    }

    return ""; //No straight
}

function evaluateHand(array $cards): array {

    for($i = 0; $i < count($cards); ++$i) {
        $values[$cards[$i][0]] = ($values[$cards[$i][0]] ?? 0) + 1;
        $suits[$cards[$i][1]] = ($suits[$cards[$i][1]] ?? 0) + 1;
    }

    //Sort by # of similar values DESC, value DESC
    $keys = array_keys($values);
    array_multisort($values, SORT_DESC, array_map(function($value) { return VALUES[$value]; }, $keys), SORT_DESC, $keys);
    $values = array_combine($keys, $values);

    arsort($suits);

    //Straight flush
    if(reset($suits) >= 5) {
        //Filter cards to only keep the ones from the good suit
        $flushCards = filterBySuit($cards, key($suits));

        if(!empty($straight = checkForStraight($flushCards))) {
            return ["hand" => "STRAIGHT_FLUSH", "cards" => $straight];  
        }
    }

    //Four of a kind
    if(reset($values) == 4) {
        return ["hand" => "FOUR_OF_A_KIND", "cards" => str_repeat(key($values), 4) . getHighestCards($cards, 1, [key($values)])];
    }

    //Full house
    if(reset($values) == 3 && next($values) >= 2) {
        return ["hand" => "FULL_HOUSE", "cards" => str_repeat(array_key_first($values), 3) . str_repeat(key($values), 2)];
    }

    //Flush
    if(reset($suits) >= 5) {
        return ["hand" => "FLUSH", "cards" => getHighestCards($flushCards, 5)];  
    }

    //Straight
    if(!empty($straight = checkForStraight($cards))) {
        return ["hand" => "STRAIGHT", "cards" => $straight];  
    }

    //Three of a kind
    if(reset($values) == 3) {
        return ["hand" => "THREE_OF_A_KIND", "cards" => str_repeat(key($values), 3) . getHighestCards($cards, 2, [key($values)])];
    }

    //At least a pair
    if(reset($values) == 2) {
        //Check if the player has a second pair
        if(next($values) == 2) {
            return ["hand" => "TWO_PAIR", "cards" => str_repeat(array_key_first($values), 2) . str_repeat(key($values), 2) . getHighestCards($cards, 1, [array_key_first($values), key($values)])];
        }

        return ["hand" => "PAIR", "cards" => str_repeat(array_key_first($values), 2) . getHighestCards($cards, 3, [array_key_first($values)])];
    }

    //High card
    return ["hand" => "HIGH_CARD", "cards" => getHighestCards($cards, 5)];
}

//Filter cards, only returns the ons of a given suit
function filterBySuit(array $cards, string $suit): array {
    $filtered = [];

    foreach($cards as $card) {
        if($card[1] == $suit) $filtered[] = $card;
    }

    return $filtered;
}

//Get the highest cards left to complete the hand
function getHighestCards(array $cards, int $count, array $excluded = []): string {
    $highest = "";

    usort($cards, function($a, $b) {
        return VALUES[$b[0]] <=> VALUES[$a[0]];
    });

    foreach($cards as $card) {
        if(!in_array($card[0], $excluded)) $highest .= $card[0];
        if(strlen($highest) == $count) break;
    }

    return $highest;
}

$holeCardsPlayer1 = explode(" ", stream_get_line(STDIN, 256 + 1, "\n"));
$holeCardsPlayer2 = explode(" ", stream_get_line(STDIN, 256 + 1, "\n"));
$communityCards = explode(" ", stream_get_line(STDIN, 256 + 1, "\n"));

$players[1] = evaluateHand(array_merge($holeCardsPlayer1, $communityCards));
$players[2] = evaluateHand(array_merge($holeCardsPlayer2, $communityCards));

//Both players have the same hand
if(HANDS[$players[1]["hand"]] == HANDS[$players[2]["hand"]]) {
    for($i = 0; $i < 5; ++$i) {
        if(VALUES[$players[1]["cards"][$i]] > VALUES[$players[2]["cards"][$i]]) {
            $winner = 1;    break;
        }
        elseif(VALUES[$players[1]["cards"][$i]] < VALUES[$players[2]["cards"][$i]]) {
            $winner = 2;    break;
        }
    }
}
else $winner = ((HANDS[$players[1]["hand"]] <=> HANDS[$players[2]["hand"]]) == 1) ? 1 : 2;

if(isset($winner)) echo $winner . " " . implode(" ", $players[$winner]) . PHP_EOL;
else echo "DRAW" . PHP_EOL;
