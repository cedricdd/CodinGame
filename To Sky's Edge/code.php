<?php

$start = microtime(1);

fscanf(STDIN, "%d", $Y);
fscanf(STDIN, "%d", $C);
fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d %d", $age, $number);

    $crew[$age] = $number;
}

krsort($crew); //We want them sorted from oldest to youngest


$min = INF;
$max = -INF;
$expectancy = 39; //expectancy can't be below 40 otherwise no baby will ever be added

while(true) {
    ++$expectancy;
    $limit = ($expectancy >> 1);
    $crewShip = $crew;

    for($year = 0; $year < $Y; ++$year) {
        $fertile = 0;
        $total = 0;

        foreach($crewShip as $age => $number) {
            unset($crewShip[$age]);
            
            //If they stay alive for another year
            if(++$age <= $expectancy) {
                $crewShip[$age] = $number;

                $total += $number;

                //They are in the range of getting a baby
                if($age >= 20 && $age  <= $limit) $fertile += $number;
            }
        }

        //Add babies
        if(($babies = intdiv($fertile, 10)) > 0) {
            $crewShip += [0 => $babies];
            $total += $babies;
        }

        if($total == 0) continue 2; //Everybody is dead
        if($total > $C) break 2; //Civil war
    }

    if($total >= 200) {
        $min = min($min, $expectancy);
        $max = max($max, $expectancy);
    }
}

echo $min . " " . $max . PHP_EOL;

error_log(microtime(1) - $start);
