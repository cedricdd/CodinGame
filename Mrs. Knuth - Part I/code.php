<?php

const TIMES = ['8', '9', '10', '11', '1', '2', '3', '4'];

function showSchedule(array $slots) {
    $schedule = [
        "       Monday        Tuesday       Wednesday       Thursday        Friday    ",
        " 8 -------------- -------------- -------------- -------------- --------------",
        " 9 -------------- -------------- -------------- -------------- --------------",
        "10 -------------- -------------- -------------- -------------- --------------",
        "11 -------------- -------------- -------------- -------------- --------------",
        "       LUNCH          LUNCH          LUNCH          LUNCH          LUNCH     ",
        " 1 -------------- -------------- -------------- -------------- --------------",
        " 2 -------------- -------------- -------------- -------------- --------------",
        " 3 -------------- -------------- -------------- -------------- --------------",
        " 4 -------------- -------------- -------------- -------------- --------------",
    ];

    foreach($slots as $slot => $info) {
        [$date, $time] = explode("-", $slot);

        switch($time) {
            case '8': $line = 1; break;
            case '9': $line = 2; break;
            case '10': $line = 3; break;
            case '11': $line = 4; break;
            case '1': $line = 6; break;
            case '2': $line = 7; break;
            case '3': $line = 8; break;
            case '4': $line = 9; break;
        }

        switch($date) {
            case 'M': $offset = 3; break;
            case 'Tu': $offset = 18; break;
            case 'W': $offset = 33; break;
            case 'Th': $offset = 48; break;
            case 'F': $offset = 63; break;
        }

        $schedule[$line] = substr_replace($schedule[$line], str_pad($info, 14, " ", STR_PAD_BOTH), $offset, 14);
    }

    echo implode(PHP_EOL, array_map("rtrim", $schedule)) . PHP_EOL;
}

function solve(array $students, int $left, array $slots = []) {
    global $names, $instruments, $idsByInstument, $start;

    if($left == 0) {
        showSchedule($slots);
        return;
    }

    //Find the student with the less possibilties
    $lowestCount = PHP_INT_MAX;
    $lowestID = 0;

    foreach($students as $id => $availability) {
        $count = count($availability);

        if($count == 0) return;

        if($count < $lowestCount) {
            $lowestCount = $count;
            $lowestID = $id;
        }
    }

    // error_log("lowest: $lowestID - $lowestCount");

    foreach($students[$lowestID] as $timeSlot => $filler) {
        [$date, $time] = explode("-", $timeSlot);


        $students2 = $students;

        unset($students2[$lowestID]);

        //Nobody else can use this slot
        foreach($students2 as $studentID => $filler2) unset($students2[$studentID][$timeSlot]);

        //Nobody else playing the same instrument
        foreach($idsByInstument[$instruments[$lowestID]] as $studentID) {
            foreach(TIMES as $time) {
                unset($students2[$studentID][$date . "-" . $time]);
            }
        }

        solve($students2, $left - 1, $slots + [$timeSlot => $names[$lowestID] . "/" . $instruments[$lowestID]]);
    }
}

function getAvailability(string $input): array {
    $availability = [];

    preg_match_all("/(?:M|Tu|W|Th|F)[0-9\s]*/", $input, $matches);

    foreach($matches[0] as $match) {
        $info = explode(" ", trim($match));
        $day = array_shift($info);
    
        foreach($info as $time) $availability[$day . "-" . $time] = 1;
    }

    return $availability;
}

$start = microtime(1);

$teacher = getAvailability(trim(fgets(STDIN)));

fscanf(STDIN, "%d", $numStudents);
for ($i = 0; $i < $numStudents; $i++) {
    preg_match("/(\w+) (\w+) (.+)/", trim(fgets(STDIN)), $matches);

    [, $name, $instrument, $calendar] = $matches;

    $slots = getAvailability($calendar);

    //Make sure the teacher is available at this time
    foreach($slots as $slot => $filler) {
        if(!isset($teacher[$slot])) unset($slots[$id]);
    }

    $students[] = $slots;
    $instruments[] = $instrument;
    $idsByInstument[$instrument][] = $i;
    $names[] = $name;
}

solve($students, $numStudents);

// error_log(var_export($teacher, 1));
// error_log(var_export($students, 1));

error_log(microtime(1) - $start);
