<?php

fscanf(STDIN, "%d", $n);
$path[0] = stream_get_line(STDIN, $n + 1, "\n");
$path[1] = stream_get_line(STDIN, $n + 1, "\n");
$blank = str_repeat("o", $n);

error_log($path[0] . "\n" . $path[1] . "\n");

$turn = 0;

while(true) {
    if($path[0] == $blank && $path[1] == $blank) break;

    $moves = [1 => [], 2 => [], 3 => []];

    for($i = 0; $i < $n; ++$i) {
        if($path[0][$i] == 'R') {
            //The first move is going right
            $moves[1][] = [0, $i, 0, $i + 1];
        } elseif($path[0][$i] == 'L') {
            //The first move is going down
            $moves[2][] = [0, $i, 1, $i];

            //The fallback is going left
            $moves[3][] = [0, $i, 0, $i - 1];
        }

        if($path[1][$i] == 'L') {
            //The first move is going left
            $moves[1][] = [1, $i, 1, $i - 1];
        } elseif($path[1][$i] == 'R') {
            //The first move is going up
            $moves[2][] = [1, $i, 0, $i];

            //The fallback is going right
            $moves[3][] = [1, $i, 1, $i + 1];
        }
    }

    // error_log(var_export($moves, 1));

    while(true) {

        for($i = 1; $i <= 3; ++$i) {
            $moved = false;

            foreach($moves[$i] as $index => [$l1, $i1, $l2, $i2]) {
                //We are moving out of the path
                if($i2 < 0 || $i2 >= $n) {
                    $path[$l1][$i1] = 'o';
                    unset($moves[$i][$index]);
                    $moved = true;
                }
                //Nobody can move there anymore this turn
                elseif($path[$l2][$i2] == 'l' || $path[$l2][$i2] == 'r') {
                    unset($moves[$i][$index]);
                }
                //The person there has already moved
                elseif($path[$l1][$i1] != 'L' && $path[$l1][$i1] != 'R') {
                    unset($moves[$i][$index]);
                }
                //The move is possible, the spot is open
                elseif($path[$l2][$i2] == 'o') {
                    $path[$l2][$i2] = strtolower($path[$l1][$i1]);
                    $path[$l1][$i1] = 'o';
                    unset($moves[$i][$index]);
                    $moved = true;
                }
                //Swapping up and down
                elseif($i == 2) {
                    if($path[$l1][$i1] == 'L' && $path[$l2][$i2] == 'R') {
                        $path[$l1][$i1] = 'r';
                        $path[$l2][$i2] = 'l';

                        unset($moves[$i][$index]);
                        $moved = true;
                    } elseif($path[$l1][$i1] == 'R' && $path[$l2][$i2] == 'L') {
                        $path[$l1][$i1] = 'l';
                        $path[$l2][$i2] = 'r';
                        
                        unset($moves[$i][$index]);
                        $moved = true;
                    }
                }
            }

            if($moved) continue 2;
        }

        break;
    }

    error_log($path[0] . "\n" . $path[1] . "\n");

    $path[0] = strtr($path[0], "lr", "LR");
    $path[1] = strtr($path[1], "lr", "LR");

    if(++$turn > 1001) exit("Congestion");
}

echo $turn . PHP_EOL;
