<?php

$b = [[-INF, INF]];
$overshadow = [];

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    list(, $cmp, $n) = explode(" ", stream_get_line(STDIN, 100 + 1, "\n"));

    //We have excluded all numbers, all conditions are now overshadowed 
    if(count($b) == 0) {
        $overshadow[] = $i;
        continue;
    }

    $valid = false;

    if($cmp == ">") {
        foreach($b as $k => $limits) {
            if($limits[1] > $n) {
                //This conditions is removing all the numbers of this interval
                if($n < $limits[0]) unset($b[$k]);
                //Set the new upper value of the interval
                else $b[$k][1] = $n;

                $valid = true;
            }
        }
    } elseif($cmp == "==") {
        foreach($b as $k => $limits) {
            if($n >= $limits[0] && $limits[1] >= $n) {

                //This interval is replaced by 2 intervals: $min, $n -1 && $n + 1, $max (extra check to make sure we don't create empty ones)
                unset($b[$k]);
                if($n - 1 >= $limits[0]) $b[] = [$limits[0], $n - 1];
                if($n + 1 <= $limits[1]) $b[] = [$n + 1, $limits[1]];

                $valid = true;
            }
        }
    } elseif($cmp == "<") {
        foreach($b as $k => $limits) {
            if($limits[0] < $n) {
                 //This conditions is removing all the numbers of this interval
                if($n > $limits[1]) unset($b[$k]);
                //Set the new lower value of the interval
                else $b[$k][0] = $n;

                $valid = true;
            }
        }
    } elseif($cmp == "!=") {
        foreach($b as $k => $limits) {
            if($limits[0] != $n || $limits[1] != $n) {
                //The only number left in this interval is the number excluded
                if($n >= $limits[0] && $n <= $limits[1]) $b[$k] = [$n, $n];
                //The condition is removing all the numbers of this interval
                else unset($b[$k]);

                $valid = true;
            }
        }
    }

    if(!$valid) $overshadow[] = $i;
}

if(count($overshadow)) echo implode(" ", $overshadow) . "\n";
else echo "ok\n";
?>
