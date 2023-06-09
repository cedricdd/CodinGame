<?php

$F = trim(fgets(STDIN));
[$L, $C, $R, $O] = str_split(trim(fgets(STDIN)));
$B = trim(fgets(STDIN));

foreach(str_split(trim(fgets(STDIN))) as $command) {
    switch($command) {
        case "U": [$F, $L, $C, $R, $O, $B] = [$O, $L, $F, $R, $B, $C]; break;
        case "L": [$F, $L, $C, $R, $O, $B] = [$O, $B, $L, $F, $R, $C]; break;
        case "R": [$F, $L, $C, $R, $O, $B] = [$O, $F, $R, $B, $L, $C]; break;
        case "D": [$F, $L, $C, $R, $O, $B] = [$O, $R, $B, $L, $F, $C]; break;
    }
}

echo $C . PHP_EOL;
