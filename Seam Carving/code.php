<?php

$magic = stream_get_line(STDIN, 3 + 1, "\n");
fscanf(STDIN, "%d %d", $W, $H);
fscanf(STDIN, "%s %d", $comment, $V);
fscanf(STDIN, "%d", $maxintensity);

for ($i = 0; $i < $H; $i++) {
    $image[] = array_map('intval', explode(" ", trim(fgets(STDIN))));
}

for($y = 0; $y < $H; ++$y) {
    for($x = 0; $x < $W; ++$x) {
        $dIdx = ($x > 0 && $x < $W - 1) ? ($image[$y][$x + 1] - $image[$y][$x - 1]) : 0;
        $dIdy = ($y > 0 && $y < $H - 1) ? ($image[$y + 1][$x] - $image[$y - 1][$x]) : 0;
        $energy[$y][$x] = abs($dIdx) + abs($dIdy);
    }

    error_log(implode(" ", array_map(function($v) {
        return str_pad($v, 3, '0', STR_PAD_LEFT);
    }, $energy[$y])));
}

for($x = 0; $x < $W; ++$x) {
    $paths[0][$x] = [$energy[0][$x], null];
}

$bestPath = [INF, null];

for($y = 1; $y < $H; ++$y) {
    for($x = 0; $x < $W; ++$x) {
        $best = [INF, ""];

        for($i = -1; $i <= 1; ++$i) {
            if($x + $i >= 0 && $x + $i < $W && $paths[$y - 1][$x + $i][0] < $best[0]) $best = [$paths[$y - 1][$x + $i][0], $i];
        }

        $paths[$y][$x] = [$energy[$y][$x] + $best[0], $best[1]];

        if($y == $H - 1 && $paths[$y][$x][0] < $bestPath[0]) $bestPath = [$paths[$y][$x][0], $x];
    }
}

echo $bestPath[0] . PHP_EOL;

error_log(var_export($bestPath, 1));

$x = $bestPath[1];
$y = $H - 1;

while(true) {
    // error_log("$x $y - {$paths[$y][$x][0]}");

    if($paths[$y][$x][1] === null) break;

    $x += $paths[$y][$x][1];
    $y--;
}
