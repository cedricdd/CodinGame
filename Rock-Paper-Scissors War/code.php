<?php

const BATTLE_RESULTS = [
    "R" => ["R" => 1, "P" => 0, "C" => 1, "L" => 1, "S" => 0],
    "P" => ["R" => 1, "P" => 1, "C" => 0, "L" => 0, "S" => 1],
    "C" => ["R" => 0, "P" => 1, "C" => 1, "L" => 1, "S" => 0],
    "L" => ["R" => 0, "P" => 1, "C" => 0, "L" => 1, "S" => 1],
    "S" => ["R" => 1, "P" => 0, "C" => 1, "L" => 0, "S" => 1],
];

//Returns the winner of a duel
function battle($p1, $p2) {
    return (BATTLE_RESULTS[$p1][$p2]) ? $p1 : $p2;
}

fscanf(STDIN, "%d %d %d", $w, $h, $n);
for ($i = 0; $i < $h; $i++) {
    $grid[] = stream_get_line(STDIN, 100 + 1, "\n");
}

for($i = 0; $i < $n; ++$i) {

    $fightGrid = array_fill(0, $h, str_repeat(0, $w));

    for($y = 0; $y < $h; ++$y) {
        for($x = 0; $x < $w; ++$x) {
            $winners = [];

            //Get the winners of the 4 duels
            if($x > 0) $winners[] = battle($grid[$y][$x], $grid[$y][$x - 1]);
            if($x < $w - 1) $winners[] = battle($grid[$y][$x], $grid[$y][$x + 1]);
            if($y > 0) $winners[] = battle($grid[$y][$x], $grid[$y - 1][$x]);
            if($y < $h - 1) $winners[] = battle($grid[$y][$x], $grid[$y + 1][$x]);

            //Same can win sevarel, remove duplicates
            $winners = array_unique($winners);

            //We have more than one winner, make them duel each others
            while(count($winners) > 1) {
                $winners[] = battle(array_pop($winners), array_pop($winners));
            }
            
            $fightGrid[$y][$x] = array_pop($winners);
        }
    }

    $grid = $fightGrid;
}

echo implode("\n", $grid) . PHP_EOL;
?>
