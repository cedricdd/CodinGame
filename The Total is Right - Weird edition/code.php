<?php

$start = microtime(1);

fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d", $a);

$list[1][$a] = 1;
$count = 2;
$history = [$a => 1];

while(true) {
    for($i = 1; $i <= ($count >> 1); ++$i) {
        foreach($list[$i] as $value1 => $filler) {
            foreach($list[$count - $i] as $value2 => $filler) {
                //Order of addition doesn't matter
                $value = $value1 + $value2;
                if(!isset($history[$value])) {
                    $list[$count][$value] = 1;
                    $history[$value] = 1;
                }

                //Order of multiplication doesn't matter
                $value = $value1 * $value2;
                if(!isset($history[$value])) {
                    $list[$count][$value] = 1;
                    $history[$value] = 1;
                }

                //Substraction
                $value = abs($value1 - $value2);
                if(!isset($history[$value])) {
                    $list[$count][$value] = 1;
                    $history[$value] = 1;
                }

                //We can't divide by 0 and the result needs to be an integer
                if ($value2 != 0 && $value1 % $value2 == 0) {
                    $value = $value1 / $value2;
                    if(!isset($history[$value])) {
                        $list[$count][$value] = 1;
                        $history[$value] = 1;
                    }
                }
                if ($value1 != 0 && $value2 % $value1 == 0) {
                    $value = $value2 / $value1;
                    if(!isset($history[$value])) {
                        $list[$count][$value] = 1;
                        $history[$value] = 1;
                    }
                }
            }

            if(isset($list[$count][$N])) break 3; //We have found the goal
        }         
    }

    ++$count;
}

echo $count . PHP_EOL;
error_log(microtime(1) - $start);
