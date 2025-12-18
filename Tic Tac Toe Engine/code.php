<?php

const WIN = [[0,1,2], [3,4,5], [6,7,8], [0,3,6], [1,4,7], [2,5,8], [0,4,8], [2,4,6]];

function simulate(string $grid, string $player):array {
    global $engine;

    //Check is a player has won
    foreach(WIN as [$i1, $i2, $i3]) {
        if($grid[$i1] == $grid[$i2] && $grid[$i2] == $grid[$i3] && $grid[$i3] != '.') {
            if($grid[$i1] == 'X') return [1, 0, 0, $grid];
            else return [0, 1, 0, $grid];
        }
    }

    if(strpos($grid, ".") === false) return [0, 0, 1, $grid]; //Grid is full, it's a draw
    
    if($grid == ".........") return [0, 0, 1, "...." . $player . "...."]; //Gris is completly empty, best is center

    //Try to add based on cells value
    foreach([4, 0, 2, 6, 8, 1, 3, 5, 7] as $index) {
        if($grid[$index] != '.') continue;

        $grid[$index] = $player;

        //We want X to win
        if($player == 'X') {
            $result = simulate($grid, 'O');

            //It's the first result or X will win  or it will be a draw
            if(!isset($best) || ($result[0] > $best[0] || ($result[0] == $best[0] && $result[2] > $best[2]))) {
                $best = [$result[0], $result[1], $result[2], $grid];
            }
        } //We want Y to win
        else {
            $result = simulate($grid, 'X');

            //It's the first result or Y will win  or it will be a draw
            if(!isset($best) || ($result[1] > $best[1] || ($result[1] == $best[1] && $result[2] > $best[2]))) {
                $best = [$result[0], $result[1], $result[2], $grid];
            }
        }
        
        $grid[$index] = '.';
    }

    return $best;
}

$engine = stream_get_line(STDIN, 1 + 1, "\n");
$grid = "";
$start = microtime(1);

for ($i = 0; $i < 3; $i++) {
    $grid .= stream_get_line(STDIN, 3 + 1, "\n");
}

[, , , $grid] = simulate($grid, $engine);

echo implode(PHP_EOL, str_split($grid, 3)) . PHP_EOL;

error_log(microtime(1) - $start);
