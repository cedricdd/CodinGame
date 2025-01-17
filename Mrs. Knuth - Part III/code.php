<?php

const TIMES = ['8', '9', '10', '11', '1', '2', '3', '4'];
const LOUD = ["Trumpet" => 1, "Drums" => 1, "Trombone" => 1];
const MORNING = ['M' => 15, 'Tu' => 12, 'W' => 9, 'Th' => 6, 'F' => 3];
const AFTERNOON = ['M' => 10, 'Tu' => 8, 'W' => 6, 'Th' => 4, 'F' => 2];

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

function getScore(array $slots): array {
    // error_log(var_export($slots, 1));

    $scores = array_fill(0, 4, [0, 0, 0, 0, 0]);

    foreach(['M', 'Tu', 'W', 'Th', 'F'] as $i => $day) {
        $continuous = 0;

        foreach(['8', '9', '10', '11', '12', '1', '2', '3', '4'] as $time) {
            if(!isset($slots[$day . "-" . $time])) ++$continuous;
            else {
                if($continuous != 0) $scores[0][$i] += 2 ** $continuous;

                $continuous = 0;

                //Morning
                if($time >= 8) {
                    $scores[2][$i] += MORNING[$day];

                    //Loud instrument in the morning
                    if(preg_match("/.*\/(Trumpet|Drums|Trombone)/", $slots[$day . "-" . $time])) {
                        $scores[1][$i] += 50;
                    }
                } //Afternoon
                else {
                    $scores[2][$i] += AFTERNOON[$day];
                } 
            }
        }

        if($continuous != 0) $scores[0][$i] += 2 ** $continuous;
    }

    foreach(['M', 'Tu', 'W', 'Th', 'F'] as $i => $day) {
        $students = [];

        foreach(TIMES as $time) {
            if(isset($slots[$day . "-" . $time])) $students[] = $slots[$day . "-" . $time];
        }

        $count = count($students);

        for($j = 0; $j < $count - 1; ++$j) {
            //Students are in alphabetical order
            if(strcmp($students[$j], $students[$j + 1]) < 0) $scores[3][$i] += 15;
        }
    }

    return $scores;
}

function generatePermutations(array $timeSlots, int $count, array $current, array &$results) {
    //We need everything
    if($count == 0) {
        $results[] = $current;
        return;
    }

    if(!$timeSlots) return;

    $day = array_key_last($timeSlots);

    $slots = array_pop($timeSlots);

    //We don't use any of the slots
    generatePermutations($timeSlots, $count, $current, $results);

    //We can only use one slot per day at max
    foreach($slots as $slot => $filler) {
        //We use the current one
        $current[$day] = [$slot => 1];

        generatePermutations($timeSlots, $count - 1, $current, $results);
    }
}

function solve(array $students, array $counts, int $studentLeft, array $slots = []) {
    global $names, $instruments, $idsByInstument, $troublesome, $hoursRequested, $bestSchedule, $conflicts;

    //We have placed all the students
    if($studentLeft == 0) {
        $scores = getScore($slots);

        $total = array_sum(array_map("array_sum", $scores)); //The score of this schedule

        if($total > $bestSchedule[2]) {
            $bestSchedule = [$slots, $scores, $total];
        }

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
    $permutations = [];

    //We have more slots left than what we need
    if($lowestCount > $hoursRequested[$lowestID]) {
        generatePermutations($students[$lowestID], $hoursRequested[$lowestID], [], $permutations);
    } //We need to use all the slots left
    else {
        $permutations[] = $students[$lowestID];
    }

    foreach($permutations as $permutation) {
        $slots2 = $slots;
        $counts2 = $counts;
        $students2 = $students;

        unset($students2[$lowestID]);
        unset($counts2[$lowestID]);

        foreach($permutation as $date => $list) {
            $time = array_key_first($list); //We can't have more than one slot per day

            $slots2[$date . "-" . $time] = $name . "/" . $instrument;

            foreach(($conflicts[$lowestID][$date . "-" . $time] ?? []) as [$studentID2, $date2, $time2]) {
                if(isset($students2[$studentID2][$date2][$time2])) {
                    unset($students2[$studentID2][$date2][$time2]);
    
                    if(--$counts2[$studentID2] < $hoursRequested[$studentID2]) continue 2; //No more slots for this student => impossible
                }
            }
        }

        solve($students2, $counts2, $studentLeft - 1, $slots2);
    }
}

//Extract the availabilities from the string
function getAvailability(string $input): array {
    $availability = [];

    preg_match_all("/(?:M|Tu|W|Th|F)[0-9\s]*/", $input, $matches);

    foreach($matches[0] as $match) {
        $info = explode(" ", trim($match));
        $day = array_shift($info);
    
        foreach($info as $time) $availability[$day][$time] = 1;
    }

    return $availability;
}

$start = microtime(1);

$teacher = getAvailability(trim(fgets(STDIN)));

fscanf(STDIN, "%d", $numStudents);

for ($i = 0; $i < $numStudents; $i++) {
    preg_match("/(\w+) (\w+) ([0-9]+) (.+)/", trim(fgets(STDIN)), $matches);

    [, $name, $instrument, $hours, $calendar] = $matches;

    $slots = getAvailability($calendar);

    //Make sure the teacher is available at this time
    foreach($slots as $slot => $filler) {
        if(!isset($teacher[$slot])) unset($slots[$id]);
    }

    $students[] = $slots;
    $instruments[] = $instrument;
    $idsByInstument[$instrument][] = $i;
    $names[] = $name;
    $hoursRequested[]= $hours;
    $counts[] = count($slots, COUNT_RECURSIVE);
}

fscanf(STDIN, "%d", $pairs);

for ($i = 0; $i < $pairs; $i++) {
    [$a, $b] = explode(" ", trim(fgets(STDIN)));

    $a = array_search($a, $names);
    $b = array_search($b, $names);

    $troublesome[$a] = $b;
    $troublesome[$b] = $a;
}

$conflicts = [];

foreach($students as $studentID => $schedule) {

    $instrument = $instruments[$studentID];

    foreach($schedule as $day => $slots) {
        foreach($slots as $time => $filler) {

            foreach($students as $studentID2 => $filler2) {
                if($studentID == $studentID2) continue;

                $instrument2 = $instruments[$studentID2];

                //Both student are playing the same instrument, any slots the same day can't be used anymore
                if($instrument2 == $instrument) {
                    foreach(($students[$studentID2][$day] ?? []) as $time2 => $filler3) {
                        $conflicts[$studentID][$day . "-" . $time][] = [$studentID2, $day, $time2];
                    }
                }
                else {
                    //Nobody else can use the same slot
                    if(isset($students[$studentID2][$day][$time])) $conflicts[$studentID][$day . "-" . $time][] = [$studentID2, $day, $time];

                    //No two loudInstruments shall be scheduled in back-to-back hours.
                    if(isset(LOUD[$instrument]) && isset(LOUD[$instrument2])) {
                        if(isset($students[$studentID2][$day][$time - 1])) $conflicts[$studentID][$day . "-" . $time][] = [$studentID2, $day, $time - 1];
                        if(isset($students[$studentID2][$day][$time + 1])) $conflicts[$studentID][$day . "-" . $time][] = [$studentID2, $day, $time + 1]; 
                    }

                    //troublesomePairs shall not be scheduled back-to-back.
                    if(isset($troublesome[$studentID]) && $studentID2 = $troublesome[$studentID]) {
                        if(isset($students[$studentID2][$day][$time - 1])) $conflicts[$studentID][$day . "-" . $time][] = [$studentID2, $day, $time - 1];
                        if(isset($students[$studentID2][$day][$time + 1])) $conflicts[$studentID][$day . "-" . $time][] = [$studentID2, $day, $time + 1]; 
                    }
                }
            }
        }
    }
}

$bestSchedule = [[], [], 0];

solve($students, $counts, $numStudents);

showSchedule($bestSchedule[0]);

echo PHP_EOL;

foreach($bestSchedule[1] as $scores) {
    echo implode("+", $scores) . "=" . array_sum($scores) . PHP_EOL;
}

echo $bestSchedule[2] . PHP_EOL;

error_log(microtime(1) - $start);
