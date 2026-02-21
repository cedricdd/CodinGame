<?php

fscanf(STDIN, "%d", $K);
fscanf(STDIN, "%d", $N);

$usage = array_fill(0, $K, 0);

fscanf(STDIN, "%d", $current);

$usage[$current]++; //This is the starting pivot

for ($i = 0; $i < $K; $i++) {
    fscanf(STDIN, "%d %d", $x, $y);

    $points[] = [$x, $y];
}

[$xp, $yp] = $points[$current];
$v1 = [1, 0];
$history = [];

for($i = 0; $i < $N; ++$i) {
    $next = [PHP_INT_MAX, null, []];

    foreach($points as $index => [$x, $y]) {
        if($index == $current) continue;

        /** We calculate the angle to this point */
        $v2 = [$x - $xp, $y - $yp];

        $dot = $v1[0] * $v2[0] + $v1[1] * $v2[1];
        $det = $v1[0] * $v2[1] - $v1[1] * $v2[0];

        $angle = atan2($det, $dot);

        if($angle < 0) $angle *= -1;
        elseif($angle != pi()) $angle = pi() - $angle;

        if($angle < $next[0]) $next = [$angle, $index, $v2];
    }

    [, $current, $v1] = $next;

    $hash = md5($current . $v1[0] . $v1[1]);

    //We are entering a loop, we know all the result up to the end
    if(isset($history[$hash])) {
        $list = array_values(array_slice($history, array_search($hash, array_keys($history)))); //All the points in the loop
        $count = count($list); 
        $left = $N - $i;

        //Increase the usage counts of all the points in the loop
        foreach($list as $j => $index) {
            $usage[$index] += intdiv($left, $count) + ($j < $left % $count);
        }

        $current = $list[(($left % $count) - 1 + $count) % $count]; //Set the point at the end of all the pivot changes

        break;
    } else $history[$hash] = $current;

    $usage[$current]++;
    [$xp, $yp] = $points[$current];
}

echo $current . PHP_EOL;
echo implode(PHP_EOL, $usage);
