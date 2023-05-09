<?php

const CARDS = ["A", 2, 3, 4, 5, 6, 7, 8, 9, "T", "J", "Q", "K"];

function getScore(array $cards): int {
    $score = 0;

    $values = array_map(function($card) {
        return is_numeric($card[0]) ? intval($card[0]) : ($card[0] == "A" ? 1 : 10);
    }, $cards);
    $suits = array_map(function($card) {
        return $card[1];
    }, $cards);
    $cards = array_map(function($card) {
        return $card[0];
    }, $cards);

    //His nobs
    for($i = 0; $i < 4; ++$i) {
        if($cards[$i] == "J" && $suits[$i] == $suits[4]) ++$score;
    }

    //Flushes
    if(count(array_unique(array_slice($suits, 0, 4))) == 1) $score += 4 + ($suits[0] == $suits[4] ? 1 : 0);

    //Pairs
    $distinct = count_chars(implode("", $cards), 1);

    foreach($distinct as $value) {
        switch($value) {
            case 2: $score += 2;    break;
            case 3: $score += 6;    break;
            case 4: $score += 12;   break;
        }
    }

    //Sort cards
    usort($cards, function($a, $b) {
        return array_search($a, CARDS) <=> array_search($b, CARDS); 
    });

    //Runs
    $dp = [];

    for($i = 0; $i < 5; ++$i) {
        $cardIndex = array_search($cards[$i], CARDS);

        for($j = 1; $j <= 5; ++$j) {
            $dp[$cardIndex][$j] = ($dp[$cardIndex][$j] ?? 0) + ($dp[$cardIndex - 1][$j - 1] ?? 0);
        }

        $dp[$cardIndex][1]++;
    }

    for($i = 5; $i >= 3; --$i) {
        foreach($dp as $list) {
            if($list[$i] > 0) {
                $score += $list[$i] * $i;
                break 2;
            }
        }
    }

    //Fifteens
    $additions = [0 => 1];

    for($i = 0; $i < 5; ++$i) {
        foreach($additions as $v => $c) {
            $additions[$v + $values[$i]] = ($additions[$v + $values[$i]] ?? 0) + $c;
        }
    }

    $score += ($additions[15] ?? 0) * 2;

    return $score;
}

$n = trim(fgets(STDIN));
for ($i = 0; $i < $n; ++$i) {
    echo getScore(explode(" ", fgets(STDIN))) . PHP_EOL;
}
