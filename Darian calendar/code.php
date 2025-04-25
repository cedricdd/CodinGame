<?php

const SOL = 88775.244147;
const MONTHS = ["", "Sagittarius", "Dhanus", "Capricornus", "Makara", "Aquarius", "Khumba", "Pisces", "Mina", "Aries", "Mesha", "Taurus", "Rishabha", "Gemini", "Mithuna", "Cancer", "Karka", "Leo", "Simha", "Virgo", "Kanya", "Libra", "Tula", "Scorpius", "Vrishika"];

$start = strtotime("March 11 1609 18:40:34");
preg_match("/([0-9]{4}) (.*), (.*)/", trim(fgets(STDIN)), $matches);

$current = strtotime($matches[2] . " " . $matches[1] . " " . $matches[3]);

$seconds = $current - $start;
$days = intval($seconds / SOL);

$seconds -= $days * 88775.244147;
$seconds *= 86400/SOL;
$hours = intdiv($seconds, 60 * 60);
$seconds -= $hours * 60 * 60;
$minutes = intdiv($seconds, 60);
$seconds -= $minutes * 60;

$year = 0;

while(true) {
    $leap = (($year & 1) || (($year % 10 == 0) && !($year % 100 == 0 && !($year % 1000 == 0))));
    $daysCurrentYear = $leap ? 669 : 668;

    if($daysCurrentYear < $days) {
        ++$year;
        $days -= $daysCurrentYear;
    } else break;
}

for($i = 1; $i <= 24; ++$i) {
    $daysCurrentMonth = (($i % 6 == 0) ? 27 : 28);

    if($daysCurrentMonth < $days) {
        $days -= $daysCurrentMonth;
    } else {
        if($i != 24 && $daysCurrentMonth == $days) {
            ++$i;
            $days = 0;
        }

        break;
    }
}

echo $year . " " . MONTHS[$i] . " " . ($days + 1) . ", " . sprintf('%02d', $hours) . ":" . sprintf('%02d', $minutes) . ":" . sprintf('%02d', intval($seconds)) . PHP_EOL; 
