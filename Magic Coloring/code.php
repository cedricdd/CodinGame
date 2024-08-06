<?php

fscanf(STDIN, "%d %d", $w, $h);
for ($i = 0; $i < $h; $i++) {
    $grid[] = trim(fgets(STDIN));
}

$colors = array_fill(1, 9, 0);

for($y = 0; $y < $h; ++$y) {
    for($x = 0; $x < $w; ++$x) {
        if($grid[$y][$x] == 0) continue;

        $value = $grid[$y][$x];
        $toCheck = [[$x, $y]];

        while($toCheck) {
            [$x2, $y2] = array_pop($toCheck);

            if($grid[$y2][$x2] == $value) {
                $grid[$y2][$x2] = '0';

                foreach([[0, 1], [0, -1], [1, 0], [-1, 0]] as [$xm, $ym]) {
                    $xu = $x2 + $xm;
                    $yu = $y2 + $ym;

                    if($xu >= 0 && $xu < $w && $yu >= 0 && $yu < $h) $toCheck[] = [$xu, $yu];
                }
            }
        }

        $colors[$value] += 1;
    }
}

$colors = array_filter($colors);

if(count($colors) == 0) echo "No coloring today" . PHP_EOL;
else array_walk($colors, function ($value, $key) {
    echo "$key -> $value" . PHP_EOL;
});
