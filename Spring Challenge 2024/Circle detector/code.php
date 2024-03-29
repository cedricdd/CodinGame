<?php

/**
*
 * @param int $nRows The height of the image.
 * @param int $nCols The width of the image.
 * @param (string)[] $image Pixels of the image, given row by row from top to bottom.
 * @return The parameters of the largest circle [centerRow, centerCol, radius].
 */
function findLargestCircle($h, $w, $image) {
    $start = microtime(1);
    $bestRadius = 0;
    $best = [0, 0, 0];
    for($i = 1; $i <= max($h >> 1, $w >> 1) + 1; ++$i) $powers[$i] = pow($i, 2);
    // Write your code here
    for($y = 1; $y < $h - 1; ++$y) {
        for($x = 1; $x < $w - 1; ++$x) {
            $maxRadius = min($y, $x, $h - $y - 1, $w - $x - 1);
            //error_log("at $x $y -- $maxRadius");
            for($r = $bestRadius + 1; $r <= $maxRadius; ++$r) {
                $color = null;
                $r1 = $powers[$r];
                $r2 = $powers[$r + 1];
                for($y2 = $y - $r; $y2 <= $y + $r; ++$y2) {
                    for($x2 = $x - $r; $x2 <= $x + $r; ++$x2) {
                        $d = pow($x - $x2, 2) + pow($y - $y2, 2);
                        if($d >= $r1 && $d < $r2) {
                            if(($color ?? ($color = $image[$y2][$x2])) != $image[$y2][$x2]) continue 3;
                        }
                    }
                }
                if($r > $bestRadius) {
                    $bestRadius = $r;
                    $best = [$y, $x, $r];
                }
            }
        }
    }
    error_log(microtime(1) - $start);
    return $best;
}
