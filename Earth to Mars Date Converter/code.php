<?php

//Amount of sec per day on Earth vs Marth
$factorDiff = 86400/88775.244;

$sDate = stream_get_line(STDIN, 256 + 1, "\n");
$eDate = stream_get_line(STDIN, 256 + 1, "\n");

$diff = strtotime($eDate) - strtotime($sDate); //The number of seconds between the two dates on Earth

$date = new DateTime($sDate);
$date->modify("+ " . intval($diff * $factorDiff) . "seconds"); //To find the date on Mars we add the seconds corrected by the diff factor

echo $date->format("Y-m-d H:i:s");
