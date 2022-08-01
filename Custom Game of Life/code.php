<?php

fscanf(STDIN, "%d %d %d", $h, $w, $n);

$alive = stream_get_line(STDIN, 9 + 1, "\n");
$dead = stream_get_line(STDIN, 9 + 1, "\n");

for ($i = 0; $i < $h; $i++){
    $grid[] = strtr(stream_get_line(STDIN, $w + 1, "\n"), ".O", "01"); //We use 0 for dead and 1 for alive to be able to directly do additions
}

for($i = 0; $i < $n; ++$i) {
    $stepGrid = $grid;

    for($y = 0; $y < $h; ++$y) {
        for($x = 0; $x < $w; ++$x) {
            //Get the count of neighbors
            $neighbors = -$grid[$y][$x]; //If cell is alive don't count it in neighbors
            for($y2 = max(0, $y - 1); $y2 < min($h, $y + 2); ++$y2) {
                for($x2 = max(0, $x - 1); $x2 < min($w, $x + 2); ++$x2) {
                    $neighbors += $grid[$y2][$x2];
                }
            }

            //Cell dies
            if($grid[$y][$x] && !$alive[$neighbors]) $stepGrid[$y][$x] = "0";
            //Cell is brought back to life
            elseif(!$grid[$y][$x] && $dead[$neighbors]) $stepGrid[$y][$x] = "1"; 
        }
    }

    $grid = $stepGrid;
}

//Revert back to '.' for dead and 'O' for alive and print result
echo implode("\n", array_map(function($line) {
    return strtr($line, "01", ".O");
}, $grid)) . "\n";
?>
