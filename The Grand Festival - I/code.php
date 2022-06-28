<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d", $R);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d", $prizes[]);
}

error_log(var_export($R, true));
error_log(var_export(implode(' ', $prizes), true));

$day = array_fill(0, $R + 1, 0);

//Check all the prizes starting from the end
for($i = $N - 1; $i >= 0; --$i) {

    $newDay = [];

    //Check the best prizes if we reach this day with $j days since we rested
    for($j = 1; $j <= $R; ++$j) {
        $newDay[$j - 1] = max($day[0], $prizes[$i] + $day[$j]); //Compare resting today even if we are not forced to vs not resting
    }
    
    $day = array_merge($newDay, [$day[0]]); //We add the case where we are forced to rest for the current day
}

echo max($day);
?>
