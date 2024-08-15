<?php

function evolve(string $grid): string {
    global $size, $neighbors;

    $gridUpdated = $grid;

    for($i = 0; $i < $size; ++$i) {
        $count = 0;

        //Count how many neighbors are alive
        foreach($neighbors[$i] as $neighbor) {
            if($grid[$neighbor] == "#") ++$count;
        }

        if($grid[$i] == " " && $count == 3) $gridUpdated[$i] = "#"; //Cell turns alive
        elseif($grid[$i] == "#" && ($count < 2 || $count > 3)) $gridUpdated[$i] = " "; //Cell dies
    }

    return $gridUpdated;
}

fscanf(STDIN, "%d %d", $W, $H);

$turn = 0;
$grid = "";
$history = [];
$size = $W * $H;

for ($i = 0; $i < $H; $i++) {
    $grid .= stream_get_line(STDIN, $W + 1, "\n");
}

//Pre-calculate all the neighbors of each positions
for($y = 0; $y < $H; ++$y) {
    for($x = 0; $x < $W; ++$x) {

        $index = $y * $W + $x;

        for($y2 = $y - 1; $y2 <= $y + 1; ++$y2) {
            for($x2 = $x - 1; $x2 <= $x + 1; ++$x2) {
                if(($x != $x2 || $y != $y2) && $x2 >= 0 && $x2 < $W && $y2 >= 0 && $y2 < $H) {
                    $neighbors[$index][] = $y2 * $W + $x2;
                }
            }
        }
    }
}

while(true) {
    if(strpos($grid, '#') === false) exit("Death"); //Everything is dead

    if(isset($history[$grid])) { //It's a state we had previously
        if($history[$grid] == $turn - 1) exit("Still");
        else exit("Oscillator " . ($turn - $history[$grid]));
    }
    else $history[$grid] = $turn;

    $grid = evolve($grid);
    ++$turn;
}
