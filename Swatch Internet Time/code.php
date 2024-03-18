<?php

preg_match("/([0-9]{2}):([0-9]{2}):([0-9]{2}) UTC([+-])([0-9]{2}):([0-9]{2})/", trim(fgets(STDIN)), $matches);

[$input, $hours, $minutes, $seconds, $timeZoneSign, $timeZoneHours, $timeZoneMinutes] = $matches;

$timezone = floatval($timeZoneSign . $timeZoneHours . "." . $timeZoneMinutes);
$given = new DateTime($input);

if($timezone >= 1.0) {
    $given->sub(new DateInterval("PT". ($timeZoneHours - 1) . "H"));
    $given->sub(new DateInterval("PT". $timeZoneMinutes . "M"));
} elseif($timezone >= 0.0) {
    $given->add(new DateInterval("PT". (60 - $timeZoneMinutes) . "M"));
} else {
    $given->add(new DateInterval("PT". $timeZoneMinutes . "M"));
    $given->add(new DateInterval("PT". ($timeZoneHours + 1) . "H"));
}

//Calculate the beats value
$beats = (3600 * $given->format("H") + 60 * $given->format("i") + $given->format("s")) / 86.4;

echo "@" . number_format($beats, 2) . PHP_EOL;
