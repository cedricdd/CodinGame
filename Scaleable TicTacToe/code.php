<?php

fscanf(STDIN, "%d %d", $n, $g);
for ($i = 0; $i < $n; $i++) {
    $game[] = stream_get_line(STDIN, $n + 1, "\n");
}

$directions = [
    [0, $n, 0, $n - $g, 0, 1, '|'], // Vertical
    [0, $n - $g, 0, $n, 1, 0, '-'], // Horizontal
    [0, $n - $g, 0, $n - $g, 1, 1, '\\'], // Diagonal from left top to right bottom
    [$g - 1, $n, 0, $n - $g, -1, 1, '/'], // Diagonal from left bottom to right top
];

$start = microtime(1);

$finished = true;

for($y = 0; $y < $n; ++$y) {
    for($x = 0; $x < $n; ++$x) {
        $cell = $game[$y][$x];

        if($cell == ' ') {
            $finished = false;
            continue;
        }

        foreach($directions as [$dxin, $dxax, $dyin, $dyax, $dx, $dy, $character]) {
            //Starting at this position we could have a winning path
            if($x >= $dxin && $x <= $dxax && $y >= $dyin && $y <= $dyax) {
                $winning = true;
    
                for($i = 0; $i < $g; ++$i) {
                    // It's not a winning path
                    if($game[$y + ($dy * $i)][$x + ($dx * $i)] != $cell) {
                        $winning = false;
                        break;
                    }
                }
    
                //We found a winning path
                if($winning) {
                    for($i = 0; $i < $g; ++$i) {
                        $game[$y + ($dy * $i)][$x + ($dx * $i)] = $character;
                    }

                    echo implode(PHP_EOL, $game) . PHP_EOL;
                    exit("The winner is $cell.");
                }
            } 
        }
    }
}

error_log(microtime(1) - $start);

echo implode(PHP_EOL, $game) . PHP_EOL;
echo ($finished ? "The game ended in a draw!" : "The game isn't over yet!") . PHP_EOL;
