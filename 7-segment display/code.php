<?php

fscanf(STDIN, "%d", $N);
$C = stream_get_line(STDIN, 1 + 1, "\n");
fscanf(STDIN, "%d", $S);

$size = ($S + 2) + 1;

$output = array_fill(0, $S * 2 + 3, str_repeat(" ", $size * strlen($N) - 1));

/**
 *  11
 * 4  2
 * 4  2
 *  33
 * 7  5
 * 7  5
 *  66
 */
foreach(str_split($N) as $i => $d) {
    for($j = 1; $j <= $S; ++$j) {
        if($d != 1 && $d != 4) $output[0][$i * $size + $j] = $C; //1
        if($d != 5 && $d != 6) $output[$j][$i * $size + $S + 1] = $C; //2
        if($d != 1 && $d != 2 && $d != 3 && $d != 7) $output[$j][$i * $size] = $C; //3
        if($d != 0 && $d != 1 && $d != 7) $output[$S + 1][$i * $size + $j] = $C; //4
        if($d != 2) $output[$S + 1 + $j][$i * $size + $S + 1] = $C; //5
        if($d != 1 && $d != 4 && $d != 7) $output[$S * 2 + 2][$i * $size + $j] = $C; //6
        if($d == 0 || $d == 2 || $d == 6 || $d == 8) $output[$S + 1 + $j][$i * $size] = $C; //7
    }
}

echo implode(PHP_EOL, array_map("rtrim", $output)) . PHP_EOL;
