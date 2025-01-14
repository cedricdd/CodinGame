<?php

const LOUD = ["Trumpet" => 1, "Drums" => 1, "Trombone" => 1];

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

function solve(array $students, array $counts, int $studentLeft, array $slots = []) {
    global $names, $instruments, $idsByInstument, $troublesome;

    //We have placed all the students
    if($studentLeft == 0) {
        showSchedule($slots);
        return;
    }

    //Find the student with the less possibilties
    $lowestCount = 40;
    $lowestID = 0;

    foreach($counts as $id => $count) {
        if($count < $lowestCount) {
            $lowestCount = $count;
            $lowestID = $id;
        }
    }

    $instrument = $instruments[$lowestID];
    $name = $names[$lowestID];

    foreach($students[$lowestID] as $timeSlot => $filler) {
        [$date, $time] = explode("-", $timeSlot);

        $counts2 = $counts;
        $students2 = $students;

        unset($students2[$lowestID]);
        unset($counts2[$lowestID]);

        //Nobody else can use this slot
        foreach($students2 as $studentID => $filler2) {
            if(isset($students2[$studentID][$timeSlot])) {
                unset($students2[$studentID][$timeSlot]);

                if(--$counts2[$studentID] == 0) continue 2; //No more slots for this student => impossible
            }
        }

        //Nobody else playing the same instrument can use any slot the same day
        foreach($idsByInstument[$instrument] as $studentID) {
            foreach(['8', '9', '10', '11', '1', '2', '3', '4'] as $time2) {
                if(isset($students2[$studentID][$date . "-" . $time2])) {
                    unset($students2[$studentID][$date . "-" . $time2]);

                    if(--$counts2[$studentID] == 0) continue 3; //No more slots for this student => impossible
                }
            }
        }

        $nextSlot = $date . "-" . ($time + 1);
        $prevSlot = $date . "-" . ($time - 1);

        //We can't have two loud instruments following each other
        if(isset(LOUD[$instrument])) {
            foreach($students2 as $studentID => $filler2) {
                //This student is also using a loud instrument
                if(isset(LOUD[$instruments[$studentID]])) {
                    //The student can't use the next slot
                    if(isset($students2[$studentID][$nextSlot])) {
                        unset($students2[$studentID][$nextSlot]);
        
                        if(--$counts2[$studentID] == 0) continue 2; //No more slots for this student => impossible
                    }

                    //The student can't use the prev slot
                    if(isset($students2[$studentID][$prevSlot])) {
                        unset($students2[$studentID][$prevSlot]);
        
                        if(--$counts2[$studentID] == 0) continue 2; //No more slots for this student => impossible
                    }
                }
            }  
        }
        
        //Pair of troublesome students can't be placed together
        foreach(($troublesome[$name] ?? []) as $studentID => $studentName) {
            //The student can't use the next slot
            if(isset($students2[$studentID][$nextSlot])) {
                unset($students2[$studentID][$nextSlot]);

                if(--$counts2[$studentID] == 0) continue 2; //No more slots for this student => impossible
            }

            //The student can't use the prev slot
            if(isset($students2[$studentID][$prevSlot])) {
                unset($students2[$studentID][$prevSlot]);

                if(--$counts2[$studentID] == 0) continue 2; //No more slots for this student => impossible
            }
        }
        
        solve($students2, $counts2, $studentLeft - 1, $slots + [$timeSlot => $name . "/" . $instrument]);
    }
}

//Extract the availabilities from the string
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
    $counts[] = count($slots);
}

fscanf(STDIN, "%d", $pairs);

for ($i = 0; $i < $pairs; $i++) {
    [$a, $b] = explode(" ", trim(fgets(STDIN)));

    $troublesome[$a][array_search($b, $names)] = $b;
    $troublesome[$b][array_search($a, $names)] = $a;
}

solve($students, $counts, $numStudents);

error_log(microtime(1) - $start);
