<?php

fscanf(STDIN, "%d %d %d", $side, $M, $N);
$start = microtime(1);

for ($i = 0; $i < $M; ++$i) {
    fscanf(STDIN, "%d %d %d", $x, $y, $s);

    $squares[] = [$x, $y, $s];

    //Border Up
    $bordersU[$y - 1][] = [$x - 1, $x - 2 + $s];
    $bordersU[$y - 1 + $s][] = [$x - 1, $x - 2 + $s];

    //Border Down
    $bordersD[$y - 2][] = [$x - 1, $x - 2 + $s];
    $bordersD[$y - 2 + $s][] = [$x - 1, $x - 2 + $s];

    //Border Left
    $bordersL[$x - 1][] = [$y - 1, $y - 2 + $s];
    $bordersL[$x - 1 + $s][] = [$y - 1, $y - 2 + $s];

    //Border Right
    $bordersR[$x - 2][] = [$y - 1, $y - 2 + $s];
    $bordersR[$x - 2 + $s][] = [$y - 1, $y - 2 + $s];
}

error_log(microtime(1) - $start);

$leftCount = $side * $side;
$counts = [];

foreach($squares as [$x, $y, $s]) {
    $xs = $x - 1;
    $xe = $x + $s - 2;
    $ys = $y - 1;
    $ye = $y + $s - 2;

    for($x = $xs; $x <= $xe; ++$x) {
        for($y = $ys; $y <= $ye; ++$y) {
            if(isset($counts[$y * $side + $x])) continue;

            $count = 0;
            $indexes = [];
            $queue = [[$x, $y]];

            while($queue) {
                [$x2, $y2] = array_pop($queue);
                $index = $y2 * $side + $x2;

                if(isset($indexes[$index])) continue;

                ++$count;
                $indexes[$index] = true;

                //Move left
                if($x2 > 0) {
                    $blocked = false;

                    foreach(($bordersL[$x2] ?? []) as [$min, $max]) 
                        if($y2 >= $min && $y2 <= $max) $blocked = true;
                    
                    if(!$blocked) $queue[] = [$x2 - 1, $y2];
                }

                //Move right
                if($x2 < $side - 1) {
                    $blocked = false;

                    foreach(($bordersR[$x2] ?? []) as [$min, $max]) 
                        if($y2 >= $min && $y2 <= $max) $blocked = true;
                    
                    if(!$blocked) $queue[] = [$x2 + 1, $y2];
                }

                //Move up
                if($y2 > 0) {
                    $blocked = false;

                    foreach(($bordersU[$y2] ?? []) as [$min, $max]) 
                        if($x2 >= $min && $x2 <= $max) $blocked = true;
                    
                    if(!$blocked) $queue[] = [$x2, $y2 - 1];
                }

                //Move down
                if($y2 < $side - 1) {
                    $blocked = false;

                    foreach(($bordersD[$y2] ?? []) as [$min, $max]) 
                        if($x2 >= $min && $x2 <= $max) $blocked = true;
                    
                    if(!$blocked) $queue[] = [$x2, $y2 + 1];
                }
            }

            $leftCount -= $count;
            foreach($indexes as $index => $_) $counts[$index] = $count;
        }
    }
}

error_log(microtime(1) - $start);

// error_log(var_export(array_filter($counts), 1));

for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d %d", $x, $y);

    echo ($counts[($y - 1) * $side + $x - 1] ?? $leftCount) . PHP_EOL;
}

error_log(microtime(1) - $start);
