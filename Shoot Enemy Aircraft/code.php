<?php

fscanf(STDIN, "%d", $n);
for ($y = 0; $y < $n; $y++) {
    foreach(str_split(trim(fgets(STDIN))) as $x => $c) {
        if($c == ">" || $c == "<") $aircrafts[] = [$x, $y];
        elseif($c == "^") $launcher = [$x, $y];
    }
}

$actions = [];

foreach($aircrafts as [$x, $y]) {
    $distanceX = abs($x - $launcher[0]); //Distance between plane & shooter on X axis
    $distanceY = abs($y - $launcher[1]); //Distance between plane & shooter on Y axis

    $actions[$distanceX - 1 - $distanceY] = "SHOOT";
}

$nbrTurns = max(array_keys($actions));

for($i = 0; $i <= $nbrTurns; ++$i) {
    echo ($actions[$i] ?? "WAIT") . PHP_EOL;
}
