<?php

$start = microtime(1);

fscanf(STDIN, "%d", $n);
$s = trim(fgets(STDIN));

$longest = 0;
$positions = array_fill(-1, $n, 0);

for($i = 0; $i < $n; ++$i) {
    $count = 0; //A substring is balanced when the count is 0

    //Find the smallest balanced substring ending at position $i
    for($j = $i; $j >= 0; --$j) {
        //Increase/Decrease the count
        if($s[$j] == '0') --$count;
        else ++$count;

        //We found a balanced substring
        if($count == 0) {
            //The number of balanced substring ending at $i is the number of balanced substring ending at ($j - 1) plus one
            $positions[$i] = $positions[$j - 1] + 1;

            $longest = max($longest, $positions[$i]);

            break;
        }
    }
}

echo $longest . PHP_EOL;

error_log(microtime(1) - $start);
