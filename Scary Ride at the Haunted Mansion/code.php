<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

 $ride = array_fill(0, 2, array_fill(0, 10, 'D'));
 $number = 1;
 $start = 0;
 $foundKid = false;

//Add a group into the ride
 function addGroup($start, $group) {
    global $ride;

    $persons = str_split($group);
    rsort($persons);

    $startR = $startL = $start;

    foreach($persons as $person) {
        if($person != "A") $ride[1][$startL++] = $person;
        else {
            if($startL < $startR) $ride[1][$startL++] = $person;
            else $ride[0][$startR++] = $person;
        }
    } 

    return $startR;
 }

fscanf(STDIN, "%d", $n);
foreach(explode(" ", stream_get_line(STDIN, 1024 + 1, "\n")) as $group) {
    //Invalid group
    if(substr_count($group, "k") > (strlen($group) / 2) || strlen($group) > 20) continue;

    //This group can't be added, we need a new ride
    if((strlen($group) / 2) + $start > 10) {
        if($foundKid) break;

        $ride = array_fill(0, 2, array_fill(0, 10, 'D'));
        ++$number; 
        $start = 0;
    }

    $start = addGroup($start, $group);

    //We are working on the ride, we can break when the ride is full
    if(strpos($group, "x") !== false) $foundKid = true;
}


echo $number . "\n";
echo "/< | " . implode(" | ", $ride[0]) . " |\n";
echo "\\< | " . implode(" | ", $ride[1]) . " |\n";
?>
