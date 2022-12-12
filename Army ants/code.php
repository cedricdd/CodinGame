<?php

fscanf(STDIN, "%d %d", $N1, $N2);

foreach(str_split(trim(fgets(STDIN))) as $c) {
    $ants[] = [$c, "R"];
}
$ants = array_reverse($ants); //The first group needs to be reversed

foreach(str_split(trim(fgets(STDIN))) as $c) {
    $ants[] = [$c, "L"];
}

$T = trim(fgets(STDIN));
$turn = 0;

while(++$turn <= $T) {
    for($i = 0; $i < count($ants) - 1; ++$i) {
        //Two ants are jumping over each others
        if($ants[$i][1] == "R" && $ants[$i + 1][1] == "L") {
            [$ants[$i], $ants[$i + 1]] = [$ants[$i + 1], $ants[$i]]; //Swap the ants
            ++$i;
        }
    }
}

echo implode("", array_column($ants, 0)) . PHP_EOL;
