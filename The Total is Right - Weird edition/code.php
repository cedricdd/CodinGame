<?php

$start = microtime(1);

fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d", $a);

$list[1][$a] = 1;
$count = 2;
$history = [$a => 1];

while(true) {
    for($i = 1; $i < $count; ++$i) {
        foreach($list[$i] as $value1 => $filler) {
            foreach($list[$count - $i] as $value2 => $filler) {
                //Addition
                $value = $value1 + $value2;
                if(!isset($history[$value])) {
                    $history[$value] = 1;
                    $list[$count][$value] = 1;
                }
                //Substraction
                $value = $value1 - $value2;
                if(!isset($history[$value])) {
                    $history[$value] = 1;
                    $list[$count][$value] = 1;
                }
                //Multiplication
                $value = $value1 * $value2;
                if(!isset($history[$value])) {
                    $history[$value] = 1;
                    $list[$count][$value] = 1;
                }
                //Division, can't divide by 0 and we an integer result
                if($value2 != 0 && $value1 % $value2 == 0) {
                    $value = $value1 / $value2;
                    if(!isset($history[$value])) {
                        $history[$value] = 1;
                        $list[$count][$value] = 1;
                    }
                }
            }
        }         
    }

    //We reach the goal
    if(isset($list[$count][$N])) {
        error_log(microtime(1) - $start);
        exit("$count");
    }
    else ++$count;
}
