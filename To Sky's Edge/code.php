<?php

$start = microtime(1);

fscanf(STDIN, "%d", $Y);
fscanf(STDIN, "%d", $C);
fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d %d", $age, $number);

    $crew[$age] = $number;
}

$min = INF;
$max = -INF;
$expectancy = 39; //expectancy can't be below 40 otherwise no baby will ever be added

while(true) {
    ++$expectancy;
    $limit = ($expectancy >> 1);
    $crewShip = $crew;

    for($i = 0; $i < $Y; $i++) {
        $updated = [];
        $total = 0;
        $fertile = 0;
       
        foreach($crewShip as $a => $n) {
            //If they stay alive for another year
            if($a++ < $expectancy) {
                $updated[$a] = $n;
                $total += $n;
            }

            //They are in the range of getting a baby
            if($a >= 20 && $a <= $limit) $fertile += $n;
        }

        //Add babies
        if(($babies = intdiv($fertile, 10)) > 0) {
            $total += $babies;
            $updated[0] = $babies;
        }

        if($total == 0) continue 2; //Everybody is dead
        if($total > $C) break 2; //Civil war

        $crewShip = $updated;
    }

    if($total >= 200) {
        $min = min($min, $expectancy);
        $max = max($max, $expectancy);
    }
}

echo $min . " " . $max . PHP_EOL;

error_log(microtime(1) - $start);
