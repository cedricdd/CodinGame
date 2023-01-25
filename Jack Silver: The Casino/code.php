<?php

fscanf(STDIN, "%d", $rounds);
fscanf(STDIN, "%d", $cash);
for ($i = 0; $i < $rounds; $i++) {
    $info = explode(" ", trim(fgets(STDIN)));

    $bet = ceil($cash / 4);

    switch($info[1]) {
        case "EVEN":  $cash += $bet * (($info[0] == 0 || $info[0] & 1) ? -1 : 1); break;
        case "ODD":   $cash += $bet * (($info[0] & 1) ? 1 : -1); break;
        case "PLAIN": $cash += $bet * (($info[0] == $info[2]) ? 35 : -1); break;
    }
}

echo $cash . PHP_EOL;
