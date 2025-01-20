<?php

fscanf(STDIN, "%d %d", $w, $h);
for ($i = 0; $i < $h; $i++) {
    $grid[] = explode(" ", trim(fgets(STDIN)));
}

for($y = 0; $y < $h; ++$y) {
    for($x = 0; $x < $w; ++$x) {
        $v = intval($grid[$y][$x]);

        if($v != 0) {
            $solutions = [];

            for($hr = min($v, $h); $hr >= 1; --$hr) {
                if($v % $hr != 0) continue; //We can't make a rectangle with that height value

                $wr = $v / $hr;

                //We check with all the starting position for the rectangle
                for($yr = max(0, $y - $hr + 1); $yr <= min($y, $h - $hr); ++$yr) {
                    for($xr = max(0, $x - $wr + 1); $xr <= min($x, $w - $wr); ++$xr) {

                        for($yi = $yr; $yi < $yr + $hr; ++$yi) {
                            for($xi = $xr; $xi < $xr + $wr; ++$xi) {
                                //The rectangle is covering another number => invalid
                                if($grid[$yi][$xi] !== "0" && !($x == $xi && $y == $yi)) continue 3;
                            }
                        }

                        $solutions[] = [$yr, $xr, $wr, $hr];
                    }
                }
            }

            if(count($solutions)) {
                echo "$y $x $v" . PHP_EOL;

                //These lines must be sorted by r, then c and then width.
                usort($solutions, function($a, $b) {
                    if($a[0] == $b[0]) {
                        if($a[1] == $b[1]) return $a[2] <=> $b[2];
                        else return $a[1] <=> $b[1];
                    } else return $a[0] <=> $b[0];
                });

                echo implode(PHP_EOL, array_map(function($line) {
                    return implode(" ", $line);
                }, $solutions)) . PHP_EOL;
            }
        }
    }
}
