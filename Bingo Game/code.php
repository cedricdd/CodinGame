<?php

const LINES_BY_POSITION = [
    -1 => [],
    0 => [0, 5, 10], 1 => [0, 6], 2 => [0, 7], 3 => [0, 8], 4 => [0, 9, 11], 5 => [1, 5], 6 => [1, 6, 10], 7 => [1, 7], 8 => [1, 8, 11], 9 => [1, 9], 10 => [2, 5], 11 => [2, 6],
    12 => [2, 7, 10, 11], 13 => [2, 8], 14 => [2, 9], 15 => [3, 5], 16 => [3, 6, 11], 17 => [3, 7], 18 => [3, 8, 10], 19 => [3, 9], 20 => [4, 5, 11], 21 => [4, 6], 22 => [4, 7], 23 => [4, 8], 24 => [4, 9, 10],
];

const POSITIONS_BY_LINE = [
    0 => [0, 1, 2, 3, 4], 1 => [5, 6, 7, 8, 9], 2 => [10, 11, 12, 13, 14], 3 => [15, 16, 17, 18, 19], 4 => [20, 21, 22, 23, 24],
    5 => [0, 5, 10, 15, 20], 6 => [1, 6, 11, 16, 21], 7 => [2, 7, 12, 17, 22], 8 => [3, 8, 13, 18, 23], 9 => [4, 9, 14, 19, 24],
    10 => [0, 6, 12, 18, 24], 11 => [4, 8, 12, 16, 20]
];

const DEFAULT_LINES = [0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 1, 1];

fscanf(STDIN, "%d", $numPlayers);
for ($i = 0; $i < $numPlayers; $i++) {
    [$name, ] = explode("'", trim(fgets(STDIN)));

    $lines[$name] = DEFAULT_LINES;

    fgets(STDIN);

    for ($y = 0; $y < 5; $y++) {
        foreach(explode(" ", preg_replace("/\s+/", " ", trim(fgets(STDIN)))) as $x => $number) {
            $cards[$name][$number] = $y * 5 +$x;
        }
    }

    $separator = trim(fgets(STDIN));
}

$winners = [];

foreach(explode(" ", trim(fgets(STDIN))) as $lastBall) {
    $ball = intval(substr($lastBall, 1));

    foreach($cards as $name => $card) {
        //Update all the lines on the player card that have this number
        foreach(LINES_BY_POSITION[$card[$ball] ?? -1] as $line) {
            if(++$lines[$name][$line] == 5) $winners[$name] = 1; //We have a bingo
        }
    }

    $balls[$ball] = 1;
    if(count($winners)) break; //There's at least one winner, we can stop
}

//A single winner
if(count($winners) == 1) {
    $winner = array_key_first($winners);
    $card = array_chunk(array_flip($cards[$winner]), 5, true);

    echo strtoupper("$winner wins!") . PHP_EOL . $separator . PHP_EOL . "Initially:" . PHP_EOL . "  B     I     N     G     O" . PHP_EOL;

    //Initially
    foreach($card as $line) {
        echo implode("   ", array_map(function($number) {
            return str_pad($number, 3, " ", STR_PAD_LEFT);
        }, $line)) . PHP_EOL;
    }

    echo $separator . PHP_EOL . "Just before the Bingo:" . PHP_EOL . "  B     I     N     G     O" . PHP_EOL;

    //Just before the Bingo
    foreach($card as $line) {
        echo rtrim(implode("  ", array_map(function($number) use ($balls, $lastBall) {
            //We need to ad an asterix if the ball was called unless it's the last one called
            return str_pad($number . ($number != substr($lastBall, 1) & isset($balls[$number]) ? "*" : " "), 4, " ", STR_PAD_LEFT);
        }, $line))) . PHP_EOL;
    }

    echo $separator . PHP_EOL . "The Ball that makes $winner Bingo: $lastBall" . PHP_EOL . $separator . PHP_EOL . "Final State:" . PHP_EOL . "  B     I     N     G     O" . PHP_EOL;

    //Get all the positions that are part of a full line
    foreach($lines[$winner] as $index => $count) {
        if($count != 5) continue;

        foreach(POSITIONS_BY_LINE[$index] as $position) $brackets[$position] = 1;
    }

    //Final State
    foreach($card as $line) {
        array_walk($line, function(&$number, $index) use ($brackets, $balls) { 
            if(isset($brackets[$index])) $number = "[" . str_pad($number, 2, " ", STR_PAD_LEFT) . "]";
            else $number = str_pad($number . (isset($balls[$number]) ? "*" : " "), 4, " ", STR_PAD_LEFT);
        });
        echo rtrim(implode("  ", $line)) . PHP_EOL;
    }
} //It's a tie
else echo "Tie between these players: " . implode(" ", array_keys($winners)) . PHP_EOL;
