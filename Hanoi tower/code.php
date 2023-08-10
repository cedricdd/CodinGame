<?php

function printState(array $state, int $N) {
    $empty = str_repeat(" ", $N) . "|" . str_repeat(" ", $N);
    $output = array_fill(0, $N, "");

    for($y = 0; $y < $N; ++$y) {
        for($x = 0; $x < 3; ++$x) {
            if(isset($state[$x][$N - $y - 1])) $output[$y] .= str_pad(str_repeat("#", $state[$x][$N - $y - 1] * 2 + 1), $N * 2 + 1, " ", STR_PAD_BOTH) . " ";
            else $output[$y] .= $empty . " ";
        }
    }
    
    echo implode("\n", array_map("rtrim", $output)) . PHP_EOL;
}

fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d", $T);

$disks = range($N, 1);
$state = [$disks, [], []];
$turn = 0;
$positionSmallest = 0;

while($state[2] != $disks) {
    if($turn % 2 == 0) {
        //Move the smallest disk one axis to the right
        if($N % 2 == 0) {
            array_push($state[($positionSmallest + 1) % 3], array_pop($state[$positionSmallest]));
            
            $positionSmallest = ($positionSmallest + 1) % 3;
        } //Move the smallest disk one axis to the left
        else {
            array_push($state[($positionSmallest + 2) % 3], array_pop($state[$positionSmallest]));
            
            $positionSmallest = ($positionSmallest + 2) % 3;
        }
    } //Make the single other possible move not involving the smallest disk
    else {
        for($i = 0; $i < 3; ++$i) {
            if($i == $positionSmallest) continue;

            $disk = end($state[$i]) ?: INF; //Size of the disk we try to move

            //Try to move it to the axe on the right
            if((end($state[($i + 1) % 3]) ?: INF) > $disk) {
                array_push($state[($i + 1) % 3], array_pop($state[$i]));
                break;
            }//Try to move it to the axe on the left
             elseif((end($state[($i + 2) % 3]) ?: INF) > $disk) {
                array_push($state[($i + 2) % 3], array_pop($state[$i]));
                break;
            }
        }
    }

    if(++$turn == $T) printState($state, $N);
}

echo $turn . PHP_EOL;
