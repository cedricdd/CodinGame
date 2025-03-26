<?php

$start = microtime(1);

fscanf(STDIN, "%d %d %d", $c, $h, $w);

for ($i = 0; $i < $c; $i++) {
    fscanf(STDIN, "%d", $cows[]);
}

for ($i = 0; $i < $h; $i++) {
    $maze[] = explode(" ", trim(fgets(STDIN)));
}

//We traverse the maze diagonally from bottom-right to top-left
for($sum = $h + $w - 2; $sum >= 0; --$sum) {
    for($x = $w - 1; $x >= 0; --$x) {

        if($x + $h - 1 < $sum) continue 2;

        for($y = $h - 1; $y >= 0; --$y) {
            if($x + $y == $sum) {
                $neighbor = min($maze[$y + 1][$x] ?? PHP_INT_MAX, $maze[$y][$x + 1] ?? PHP_INT_MAX);

                if($neighbor != PHP_INT_MAX && $neighbor > $maze[$y][$x]) $maze[$y][$x] = $neighbor;

                continue 2;
            } 
        }
    }
}

//All the cows that can endure the difficulty level of the first cell can reach the end
$cows = array_filter($cows, function($value) use ($maze) {
    return $value >= $maze[0][0];
});

echo count($cows) . PHP_EOL;

error_log(microtime(1) - $start);
