<?php

$index = 0;

fscanf(STDIN, "%d %d", $h, $w);

$start = microtime(1);

for ($y = 0; $y < $h; ++$y) {
    $line = stream_get_line(STDIN, $w + 1, "\n");

    foreach(str_split($line) as $x => $c) {
        if($c == '.') {
            $values[$y * $w + $x] = 2 ** $index;
            ++$index;
        }
    }   

    $grid[] = $line;
}

error_log(var_export($grid, 1));
// error_log(var_export($values, 1));
// error_log(count($values));

$checked = ['.' => 1];

for($y = 0; $y < $h; ++$y) {
    for($x = 0; $x < $w; ++$x) {
        if(!isset($checked[$grid[$y][$x]])) {
            // error_log("starting at $x $y with " . $grid[$y][$x]);

            $toCheck = [[$x, $y, [], 0]];
            $solutions = [];

            while($toCheck) {
                $newCheck = [];

                foreach($toCheck as [$x2, $y2, $positions, $hash]) {
                    $index = $y2 * $w + $x2;

                    // error_log("at $x2 $y2 - $index");
                    
                    if(isset($positions[$index])) continue;
                    
                    $positions[$index] = 1;
                    $hash |= $values[$index] ?? 0;

                    if($grid[$y2][$x2] == $grid[$y][$x]) {
                        if(($y2 != $y || $x2 != $x)) {
                            $solutions[] = [$positions, $hash];
                            continue;
                        }
                    } elseif($grid[$y2][$x2] != '.') continue;

                    foreach([[0, 1], [0, -1], [1, 0], [-1, 0]] as [$xm, $ym]) {
                        $xu = $x2 + $xm;
                        $yu = $y2 + $ym;

                        if($xu >= 0 && $xu < $w && $yu >= 0 && $yu < $h) $newCheck[] = [$xu, $yu, $positions, $hash];
                    }
                }

                $toCheck = $newCheck;
            }

            // error_log(var_export($solutions, 1));
            $checked[$grid[$y][$x]] = 1;
        }
    }
}

error_log(microtime(1) - $start);

$list = [];

// game loop
while (TRUE) {
    echo array_pop($list) . PHP_EOL;
}
