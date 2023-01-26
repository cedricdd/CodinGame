<?php
fscanf(STDIN, "%d", $L);

$rooms = array_flip(str_split(trim(fgets(STDIN))));

fscanf(STDIN, "%d %d", $N, $K);
for ($i = 0; $i < $N; $i++) {
    $previous = "";
    $distance = 1;

    foreach(str_split(trim(fgets(STDIN))) as $c) {
        //No info about the current room, just increase the distance
        if($c == "#") {
            ++$distance;
        } else {
            //If the min distance between the 2 rooms if greater than the time it took to the player, they are sus
            if(!empty($previous) && $previous != $c && min(($rooms[$c] - $rooms[$previous] + $L) % $L, ($rooms[$previous] - $rooms[$c] + $L) % $L) > $distance) {
                echo "SUS" . PHP_EOL;
                continue 2;
            } 

            $distance = 1;
            $previous = $c;
        }
    }

    echo "NOT SUS" . PHP_EOL;
}
