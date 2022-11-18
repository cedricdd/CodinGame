<?php

$gymnasts = explode(",", trim(fgets(STDIN)));
$categories = explode(",", trim(fgets(STDIN)));
fscanf(STDIN, "%d", $N);

for ($i = 0; $i < $N; $i++) {
    [$name, $bars, $beam, $floor] = explode(",", trim(fgets(STDIN)));

    //We just update if the score is better than the current one
    $scores[$name]["bars"] = max($scores[$name]["bars"] ?? 0, $bars);
    $scores[$name]["beam"] = max($scores[$name]["beam"] ?? 0, $beam); 
    $scores[$name]["floor"] = max($scores[$name]["floor"] ?? 0, $floor);
}

foreach($gymnasts as $gymnast) {
    $answer = [];
    foreach($categories as $category) {
        $answer[] = $scores[$gymnast][$category];
    }

    echo implode(",", $answer) . PHP_EOL;
}
