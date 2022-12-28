<?php

$adjacents = [[0, -1, 3], [1, -1, 4], [1, 0, 2], [1, 1, 7], [0, 1, 6], [-1, 1, 8], [-1, 0, 9], [-1, -1, 5]];

fscanf(STDIN, "%d", $imageSize);

for ($y = 0; $y < $imageSize; ++$y) {
    foreach(explode(" ", trim(fgets(STDIN))) as $x => $i) {
        $grid[$y][$x] = $i;
    }
}

for($y = 1; $y < $imageSize - 1; ++$y) {
    for($x = 1; $x < $imageSize - 1; ++$x) {
        //We can only add fractal around pixel that are filled
        if($grid[$y][$x] == 1) {
            //Try to add a fractal in all the 8 adjacents positions
            for($i = 0; $i < 8; ++$i) {
                for($j = -2; $j <= 2; ++$j) {
                    [$xm, $ym, $c] = $adjacents[($i + $j + 8) % 8];

                    $checkY = $y + $ym;
                    $checkX = $x + $xm;

                    if($grid[$checkY][$checkX] == 1) continue 2;
                    //Save info to update if the 5 positions are empty
                    if($j == 0) [$px, $py, $fractal] = [$checkX, $checkY, $c];
                }

                //We place a fractal
                $grid[$py][$px] = $fractal;
            }
        }
    }
}

echo implode("\n", array_map(function($line) {
    return implode(" ", $line);
}, $grid)) . PHP_EOL;
