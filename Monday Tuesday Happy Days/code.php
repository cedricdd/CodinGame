<?php

$year = ["Jan" => 31, "Feb" => 28, "Mar" => 31, "Apr" => 30, "May" => 31, "Jun" => 30, "Jul" => 31, "Aug" => 31, "Sep" => 30, "Oct" => 31, "Nov" => 30, "Dec" => 31];
$week = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
$weekFlipped = array_flip($week);

//Get the number of days since the start of the year
function getDayNumber(string $month, int $day): int {
    global $year;

    $number = 0;

    foreach($year as $m => $count) {
        if($m == $month) {
            $number += $day;
            break;
        }
        else $number += $count;
    }

    return $number;
}

fscanf(STDIN, "%d", $leapYear);
fscanf(STDIN, "%s %s %d", $dayWeek, $sourceMonth, $sourceDay);
fscanf(STDIN, "%s %d", $targetMonth, $targetDay);

if($leapYear) $year["Feb"]++;

echo $week[(((getDayNumber($targetMonth, $targetDay) - getDayNumber($sourceMonth, $sourceDay)) % 7) + $weekFlipped[$dayWeek] + 7) % 7] . PHP_EOL;
