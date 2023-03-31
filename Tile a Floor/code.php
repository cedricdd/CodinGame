<?php

const REP1 = ['(' => ')', '{' => '}', '[' => ']', '<' => '>'];
const REP2 = ['^' => 'v', 'A' => 'V', 'w' => 'm', 'W' => 'M', 'u' => 'n'];
const REP3 = ['/' => '\\'];

fscanf(STDIN, "%d", $N);
$size = $N * 2 - 1;

//Start with the borders of the 4 quadrants
for($y = 0; $y < 4 * $N + 1; ++$y) {
    $floor[] = str_repeat(" ", 4 * $N + 1);

    for($x = 0; $x < 4 * $N + 1; ++$x) {
        if($y % (2 * $N) == 0) $floor[$y][$x] = ($x % (2 * $N) == 0) ? "+" : "-";
        else $floor[$y][0] = $floor[$y][2 * $N] = $floor[$y][4 * $N] = "|";
    }
}

for ($y = 1; $y <= $N; $y++) {
    $line = fgets(STDIN);

    for ($x = 1; $x <= $N; $x++) {
        if($line[$x - 1] == " ") continue;

        //For the 4 quadrants, top-left, top-right, bottom-left, bottom-right
        foreach([[0, 0], [2 * $N, 0], [0, 2 * $N], [2 * $N, 2 * $N]] as [$xm, $ym]) {
            //Top left tile 
            $floor[$y + $ym][$x + $xm] = $line[$x - 1];
            //Top right tile
            if($x != $N) $floor[$y + $ym][2 * $N - $x + $xm] = strtr($line[$x - 1], array_merge(REP1, array_flip(REP1), REP3, array_flip(REP3)));
            //Bottom left tile
            if($y != $N) $floor[2 * $N - $y + $ym][$x + $xm] = strtr($line[$x - 1], array_merge(REP2, array_flip(REP2), REP3, array_flip(REP3)));
            //Bottom right tile
            if($x != $N && $y != $N) $floor[2 * $N - $y + $ym][2 * $N - $x + $xm] = strtr($line[$x - 1], array_merge(REP1, array_flip(REP1), REP2, array_flip(REP2)));
        }
    }
}

echo implode("\n", $floor) . PHP_EOL;
