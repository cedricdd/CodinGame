<?php

const REP1 = ['b' => 'd', 'd' => 'b', 'p' => 'q', 'q' => 'p', '/' => '\\', '\\' => '/'];
const REP2 = ['b' => 'p', 'd' => 'q', 'p' => 'b', 'q' => 'd', '/' => '\\', '\\' => '/'];
const REP3 = ['b' => 'q', 'd' => 'p', 'p' => 'd', 'q' => 'b'];

fscanf(STDIN, "%d", $N);
$size = $N * 2 - 1;

//Start with the borders of the 4 quadrants
for($y = 0; $y < 4 * $N + 3; ++$y) {
    $floor[] = str_repeat(" ", 4 * $N + 3);

    for($x = 0; $x < 4 * $N + 3; ++$x) {
        if($y % (2 * $N + 1) == 0) $floor[$y][$x] = ($x % (2 * $N + 1) == 0) ? "+" : "-";
        else $floor[$y][0] = $floor[$y][2 * $N + 1] = $floor[$y][4 * $N + 2] = "|";
    }
}

for ($y = 1; $y <= $N; $y++) {
    $line = fgets(STDIN);

    for ($x = 1; $x <= $N; $x++) {
        if($line[$x - 1] == " ") continue;

        //Top left tile 
        $floor[$y][$x] = $floor[$y][$N * 2 + 1 + $x] = $floor[$N * 2 + 1 + $y][$x] = $floor[$N * 2 + 1 + $y][$N * 2 + 1 + $x] = $line[$x - 1];
        //Top right tile
        $floor[$y][$N * 2 - $x + 1] = $floor[$y][4 * $N + 2 - $x] = $floor[$N * 2 + 1 + $y][$N * 2 - $x + 1] = $floor[$N * 2 + 1 + $y][4 * $N + 2 - $x] = strtr($line[$x - 1], REP1);
        //Bottom left tile
        $floor[$N * 2 + 1 - $y][$x] = $floor[$N * 2 + 1 - $y][$N * 2 + 1 + $x] = $floor[$N * 4 + 2 - $y][$x] = $floor[$N * 4 + 2 - $y][$N * 2 + 1 + $x] = strtr($line[$x - 1], REP2);
        //Bottom right tile
        $floor[$N * 2 + 1 - $y][$N * 2 - $x + 1] = $floor[$N * 2 + 1 - $y][4 * $N + 2 - $x] = $floor[$N * 4 + 2 - $y][$N * 2 - $x + 1] = $floor[$N * 4 + 2 - $y][4 * $N + 2 - $x] = strtr($line[$x - 1], REP3);
    }
}

echo implode("\n", $floor) . PHP_EOL;
