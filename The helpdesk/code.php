<?php

fscanf(STDIN, "%d", $worktime);
fscanf(STDIN, "%d", $nc);
$efficiencies = explode(" ", trim(fgets(STDIN)));

foreach($efficiencies as $efficiency) {
    $counters[] = [floatval($efficiency), 0, 0, 0, 0];
}

fscanf(STDIN, "%d", $nv);
$visitors = explode(" ", trim(fgets(STDIN)));

foreach($visitors as $visitorIndex => $visitorTime) {
    $counterIndex = 0;
    $available = INF;

    foreach($counters as $index => [, $timeEndTask, $timeWorkedSinceBreak]) {
        //Check if this counter has to take a break before next visitor
        if($timeWorkedSinceBreak >= $worktime) $timeEndTask += 10;

        if($timeEndTask < $available) {
            $available = $timeEndTask;
            $counterIndex = $index;
        }
    }

    //This counter took a break before helping this visitor
    if($counters[$counterIndex][2] >= $worktime) {
        $counters[$counterIndex][1] += 10;
        $counters[$counterIndex][2] = 0;
        $counters[$counterIndex][4]++;
    }

    $counters[$counterIndex][3]++; //Increase # of visitors helped
    $counters[$counterIndex][1] += $visitorTime / $counters[$counterIndex][0]; //The time this counter will be available
    $counters[$counterIndex][2] += $visitorTime / $counters[$counterIndex][0];
}

echo implode(" ", array_column($counters, 3)) . PHP_EOL;
echo implode(" ", array_column($counters, 4)) . PHP_EOL;
