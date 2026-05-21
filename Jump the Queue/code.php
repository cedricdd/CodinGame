<?php

fscanf(STDIN, "%d %d", $g, $e);

for ($i = 0; $i < $g; $i++) {
    foreach(explode(" ", trim(fgets(STDIN))) as $ID) {
        $groups[$ID] = $i;
    }
}

$queue = [];

foreach(explode(" ", trim(fgets(STDIN))) as $test => $event) {
    //Dequeueing event
    if($event == -1) {
        $firstIndex = array_key_first($queue);

        //Next is a group
        if(is_array($queue[$firstIndex])) {
            $firstIndexInGroup = array_key_first($queue[$firstIndex]);

            echo $queue[$firstIndex][$firstIndexInGroup] . PHP_EOL;

            unset($queue[$firstIndex][$firstIndexInGroup]);

            if(count($queue[$firstIndex]) == 0) unset($queue[$firstIndex]); //Nobody is left in the group
        } //Next is a loner
        else {
            echo $queue[$firstIndex] . PHP_EOL;

            unset($queue[$firstIndex]);
        }
    } //Adding a student in the queue
    else {
        if(!isset($groups[$event])) $queue[] = $event; //It's a loner, no group friend
        else {
            foreach($queue as $i => $group) {
                //The student joins his friend group
                if(is_array($group) && $groups[reset($group)] == $groups[$event]) {
                    $queue[$i][] = $event; 

                    continue 2;
                }
            }

            $queue[] = [$event]; //Starting a new friend group
        }
    }
}
