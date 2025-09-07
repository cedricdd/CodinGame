<?php

fscanf(STDIN, "%d", $h);
for ($i = 0; $i < $h; $i++) {
    $grid[] = explode(" ", trim(fgets(STDIN)));
}

$w = count($grid[0]);

$peaks = [];
$valleys = [];

for($y = 0; $y < $h; ++$y) {
    for($x = 0; $x < $w; ++$x) {
        $peak = true;
        $valley = true;

        foreach([[-1, -1], [0, -1], [1, -1], [-1, 0], [1, 0], [-1, 1], [0, 1], [1, 1]] as [$xm, $ym]) {
            $xu = $x + $xm;
            $yu = $y + $ym;

            if($xu >= 0 && $xu < $w && $yu >= 0 && $yu < $h) {
                if($grid[$yu][$xu] >= $grid[$y][$x]) $peak = false;
                if($grid[$yu][$xu] <= $grid[$y][$x]) $valley = false;
            }
        }

        if($peak) $peaks[] = "($x, $y)";
        if($valley) $valleys[] = "($x, $y)";
    }
}

echo ($peaks ? implode(", ", $peaks) : "NONE") . PHP_EOL;
echo ($valleys ? implode(", ", $valleys) : "NONE") . PHP_EOL;
