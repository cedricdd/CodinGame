<?php

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $grid[] = trim(fgets(STDIN));
}

error_log(var_export($grid, true));

$island = 1;
$sizes = [];
$visited = [];

for($y = 0; $y < $n; ++$y) {
    for($x = 0; $x < $n; ++$x) {

        if($grid[$y][$x] != "~" && !isset($visited[$y][$x])) {

            $toCheck = [[$x, $y]];
            $water = [];

            while(count($toCheck)) {
                [$xc, $yc] = array_pop($toCheck);

                if($grid[$yc][$xc] == "~") {
                    $water[$yc * $n + $xc] = 1;
                    continue;
                }

                if(isset($visited[$yc][$xc])) continue;
                else $visited[$yc][$xc] = 1;

                foreach ([[0, 1], [0, -1], [1, 0], [-1, 0]] as [$xm, $ym]) {
                    $xu = $xc + $xm;
                    $yu = $yc + $ym;

                    if($xu >= 0 && $yu >= 0 && $xu < $n && $yu < $n) $toCheck[] = [$xu, $yu];
                }
            }

            $sizes[$island++] = count($water);
        }

    }
}

krsort($sizes);
asort($sizes);

echo array_key_last($sizes) . " " . end($sizes) . PHP_EOL;
?>
