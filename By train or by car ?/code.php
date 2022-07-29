<?php

[$starting, $ending] = explode(" ", stream_get_line(STDIN, 256 + 1, "\n"));

error_log(var_export("$starting => $ending", true));

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    [$start, $end, $distance] = explode(" ", stream_get_line(STDIN, 500 + 1, "\n"));

    $links[$start] = [$end, $distance];
}

$position = $starting;
$train = 35;
$car = 0;

//There can be no loop or several path, just follow the links until we reach the destination
while($position != $ending) {
    [$end, $distance] = $links[$position];

    //Update train time
    $train += min(6, $distance) * 60/50 + max(($distance - 6), 0) * 60/284;
    $train += ($end == $ending) ? 30 : 8;

    //Update car time
    $car += min(14, $distance) * 60/50 + max(($distance - 14), 0) * 60/105;

    $position = $end;
}

//Format the duration (minutes) in hh:mm
function showTime($minutes) {
    error_log(var_export($minutes, true));
    return intdiv($minutes, 60) . ":" . str_pad($minutes % 60, 2, 0, STR_PAD_LEFT);
}

echo ($train < $car) ? ("TRAIN " . showTime($train)) : ("CAR " . showTime($car)) . "\n";
?>
