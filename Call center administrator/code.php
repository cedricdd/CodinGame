<?php

$events = [];

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%s %s", $answer, $hangup);

    $events[] = [strtotime($answer), 1];
    $events[] = [strtotime($hangup), -1];
}

usort($events, function($a, $b) {
    return $a[0] <=> $b[0];
});

$solution = 0;
$count = 0;

foreach($events as [, $value]) {
    $count += $value;
    if($count > $solution) $solution = $count;
}

echo $solution . PHP_EOL;
