<?php

const REP1 = ['(' => ')', '{' => '}', '[' => ']', '<' => '>'];
const REP2 = ['^' => 'v', 'A' => 'V', 'w' => 'm', 'W' => 'M', 'u' => 'n'];
const REP3 = ['/' => '\\'];

fscanf(STDIN, "%d", $N);
$size = $N * 2 - 1;

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

        foreach([[0, 0], [2 * $N, 0], [0, 2 * $N], [2 * $N, 2 * $N]] as [$xm, $ym]) {
            $floor[$y + $ym][$x + $xm] = $line[$x - 1];
            if($x != $N) {
                $floor[$y + $ym][2 * $N - $x + $xm] = strtr($line[$x - 1], array_merge(REP1, array_flip(REP1), REP3, array_flip(REP3)));
            }
            if($y != $N) {
                $floor[2 * $N - $y + $ym][$x + $xm] = strtr($line[$x - 1], array_merge(REP2, array_flip(REP2), REP3, array_flip(REP3)));
            }
            if($x != $N && $y != $N) {
                $floor[2 * $N - $y + $ym][2 * $N - $x + $xm] = strtr($line[$x - 1], array_merge(REP1, array_flip(REP1), REP2, array_flip(REP2)));
            }
        }
    }
}

echo implode("\n", $floor) . PHP_EOL;
