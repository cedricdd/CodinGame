<?php

$start = microtime(1);

fscanf(STDIN, "%d %d", $n, $k);

$answer = 0;
$food = [];

foreach(explode(" ", trim(fgets(STDIN))) as $input) {
    $value = $input >= $k ? 1 : -1;
    --$n;

    foreach($food as $i => [&$sum, &$count]) {

        ++$count;
        $sum += $value;

        //We have a new best feast
        if($sum > 0 && $count > $answer) $answer = $count; 

        //Even if all the food that's left is sweet it won't be enough
        if($sum + $n <= 0) unset($food[$i]);
    }

    //Starting here can't create a bigger feast than the best one
    if($n > $answer) $food[] = [$value, 1];

    //In case the only sweet food is the last one
    if($answer == 0 && $value == 1) $answer = 1; 
}

echo $answer . PHP_EOL;

error_log(microtime(1) - $start);
