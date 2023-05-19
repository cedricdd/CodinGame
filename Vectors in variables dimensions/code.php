<?php

$points = [];
$min = ["", INF];
$max = ["", 0.0];

fscanf(STDIN, "%d", $d);
fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    preg_match("/(.*)\((.*)\)/", trim(fgets(STDIN)), $match);

    $coordinates = explode(",", $match[2]);

    //Check this points against all the point we already know
    foreach($points as $name => $coord) {
        $vector = [];

        foreach($coordinates as $j => $value) {
            $vector[] = $value - $coord[$j];
        }

        $distance = sqrt(array_sum(array_map(function($value) { return $value ** 2; }, $vector)));

        if($distance < $min[1]) $min = [$name . $match[1], $distance, implode(",", $vector)];
        if($distance > $max[1]) $max = [$name . $match[1], $distance, implode(",", $vector)];
    }

    $points[$match[1]] = $coordinates;
}

echo $min[0] . "(" . $min[2] . ")" . PHP_EOL;
echo $max[0] . "(" . $max[2] . ")" . PHP_EOL;
