<?php

//https://www.geeksforgeeks.org/longest-subarray-with-sum-greater-than-equal-to-zero/

fscanf(STDIN, "%d %d %d", $n, $a, $b);

$s = microtime(1);

error_log("A $a -- B $b");

$total = 0;

foreach(explode(" ", trim(fgets(STDIN))) as $i => $temp) {
    if($temp >= $a && $temp <= $b) $temps[$i] = 1;
    else $temps[$i] = -1;

    $sum[$i] = $total += $temps[$i];
}

error_log(var_export(count($temps), true));
//error_log(var_export($temps, true));
//error_log(var_export($sum, true));

$queue = new SplPriorityQueue();
$queue->insert([0, $n - 1, $n, $sum], $n);

$history = [];
$checks = 0;

while(!$queue->isEmpty()) {
    [$start, $end, $size, $list] = $queue->extract();

    //error_log("S $start, E $end");
    //error_log(var_export($list, true));

    if(isset($history[$start][$end])) continue;
    else $history[$start][$end] = 1;

    error_log(++$checks);

    if(end($list) > 0) {
        $solution = ($start + 1) . " " . ($end + 1);

        break;
    } else {
        $size--;

        $new = $list;
        array_pop($new);

        $queue->insert([$start, $end - 1, $size, $new], $size);

        $new = [];
        for($i = 1; $i <= $size; ++$i) {
            $new[] = $list[$i] - $temps[$start];
        }

        $queue->insert([$start + 1, $end, $size, $new], $size);
    }
}

echo $solution . PHP_EOL;

error_log(microtime(1) - $s);
