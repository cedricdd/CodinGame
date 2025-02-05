<?php

function solve(array $rows, int $size) {
    $limit = $size * $size;

    for($i = 0; $i < $limit; ++$i) {

        // error_log("searching for $i");
        $start = microtime(1);

        $pivotID = null;
        $pivotValue = PHP_INT_MAX;

        for($j = $i; $j < $limit; ++$j) {
            if($rows[$j][$i] != 0) {
                $pivotID = $j;
                $pivotValue = $rows[$j][$i];

                break;
            }
        }

        if($pivotID === null) {
            // continue;
            error_log(var_export($rows, 1));
            exit("null pivot");
        }

        // error_log("using pivot ID $pivotID - $pivotValue");

        if($i != $pivotID) {
            [$rows[$i], $rows[$pivotID]] = [$rows[$pivotID], $rows[$i]];
        }

        if($pivotValue != 1) {
            // error_log(var_export($rows[$i], 1));

            for($k = $i; $k <= $limit; ++$k) {
                $rows[$i][$k] /= $pivotValue;
            } 

            // error_log(var_export($rows[$i], 1));

            // exit();
        }

        for($j = 0; $j < $limit; ++$j) {
            if($j != $i && $rows[$j][$i] != 0) {
                $sign = $rows[$j][$i] * -1;

                for($k = $i; $k <= $limit; ++$k) {
                    $rows[$j][$k] += $rows[$i][$k] * $sign;
                }
            }
        }

        // error_log("finished $i " . (microtime(1) - $start));
    }

    // error_log(var_export($rows, 1));

    $solution = "";

    foreach($rows as $values) {
        if(round($values[$limit]) == 1) $solution .= "O";
        else $solution .= ".";
    }

    echo implode(PHP_EOL, str_split($solution, $size)) . PHP_EOL;
}

$start = microtime(1);

$counts = array_flip(str_split("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"));

// error_log(var_export($counts, true));

fscanf(STDIN, "%d", $size);

$empty = array_fill(0, $size * $size + 1, 0);
$rows = array_fill(0, $size * $size, $empty);

for ($y = 0; $y < $size; ++$y) {
    foreach(str_split(trim(fgets(STDIN))) as $x => $c) {
        $index = $y * $size + $x;

        // error_log("at " . ($y * $size + $x) . " $c");
        $rows[$index][$size * $size] = $counts[$c];

        for($i = 0; $i < $size; ++$i) {
            $rows[$y * $size + $i][$index] = 1;
            $rows[$i * $size + $x][$index] = 1;
        }
    }
}

solve($rows, $size);

// error_log(var_export($rows, true));

error_log(microtime(1) - $start);
