<?php

const N = [[-1, -1], [0, -1], [1, -1], [1, 0], [1, 1], [0, 1], [-1, 1], [-1, 0]];

fscanf(STDIN, "%d %d", $H, $W);

for ($i = 0; $i < $H; $i++) {
    fscanf(STDIN, "%s", $map[]);
}

fscanf(STDIN, "%d %d", $y, $x);

$overload = [];
$toCheck[] = [$x, $y];

while($toCheck) {
    [$x, $y] = array_pop($toCheck);

    if(isset($overload[$y * $W + $x])) continue; //Already overloaded, do nothing

    $d = intval($map[$y][$x]);

    if($d < 9) $map[$y][$x] = $d + 1; //Just increase by 1
    else {
        $map[$y][$x] = '0';
        $overload[$y * $W + $x] = true;

        //Update 8 neighboring cells
        foreach(N as [$xm, $ym]) {
            $xu = $x + $xm;
            if($xu < 0 || $xu >= $W) continue;

            $yu = $y + $ym;
            if($yu < 0 || $yu >= $H) continue;

            $toCheck[] = [$xu, $yu];
        }
    }
}

foreach($map as $line) echo $line . PHP_EOL;
