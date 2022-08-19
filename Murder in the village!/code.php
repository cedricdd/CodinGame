<?php

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $line = stream_get_line(STDIN, 1024 + 1, "\n");

    preg_match("/([a-z]+): I was in the ([a-z]+)(?:\, | with )(.+)\./i", $line, $matches);

    [, $name, $place, $with] = $matches;
    foreach(explode(" and ", $with) as $person) {
        $positions[$name][$person] = $place;
    }
}

$places = []; //List of place we know a villagers was present

//Check the alibi of each villagers
foreach($positions as $name => $info) {
    foreach($info as $person => $place) {
        //Claim to be alone in a place we know someone else was present
        if($person == "alone") {
            if(isset($places[$place])) die("$name did it!");
        } //Claim to be with someone else without the matching claim
        else {
            if(!isset($positions[$person][$name]) || $positions[$person][$name] != $place) die("$name did it!");
        }
    }

    $places[$place] = 1;
}

echo "It was me!"; //All the villagers are innocent
?>
