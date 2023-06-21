<?php

fscanf(STDIN, "%d", $H);
fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $map[] = explode(" ", trim(fgets(STDIN)));
}

$answer = [0, 0];

for($y = 0; $y < $N; ++$y) {
    for($x = 0; $x < $N; ++$x) {
        if($map[$y][$x] > $H || isset($visited[$y][$x])) continue;

        //Simple floodfill
        $toExplore = [[$x, $y]];
        $size = 0;
        $deepest = INF;

        while(count($toExplore)) {
            [$xv, $yv] = array_pop($toExplore);

            if(isset($visited[$yv][$xv])) continue;
            else $visited[$yv][$xv] = 1;

            $size++;
            $deepest = min($deepest, $map[$yv][$xv]);

            foreach([[1, 0], [-1, 0], [0, 1], [0, -1]] as [$xm, $ym]) {
                $xu = $xv + $xm;
                $yu = $yv + $ym;

                if($xu >= 0 && $xu < $N && $yu >= 0 && $yu < $N && $map[$yu][$xu] <= $H) $toExplore[] = [$xu, $yu];
            }
        }

        //The valley is bigger or has the same size with a deepest part
        if($size > $answer[0] || ($size == $answer[0] && $deepest < $answer[1])) $answer = [$size, $deepest];
    }
}

echo $answer[1] . PHP_EOL;
