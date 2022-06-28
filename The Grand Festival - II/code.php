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

$day = array_fill(0, $R + 1, [0, []]);

//Check all the prizes starting from the end
for($i = $N - 1; $i >= 0; --$i) {

    $newDay = [];

    //Check the best prizes if we reach this day with $j days since we rested
    for($j = 1; $j <= $R; ++$j) {
        //It's best to rest the current day
        if($day[0][0] > $prizes[$i] + $day[$j][0]) {
            $newDay[$j - 1] = $day[0]; 
        } //It's best to participate the current day
        else {
            $newDay[$j - 1] = [$prizes[$i] + $day[$j][0], array_merge($day[$j][1], [$i + 1])];
        }
    }
    
    $day = array_merge($newDay, [$day[0]]); //We add the case where we are forced to rest for the current day
}

echo implode(">", array_reverse($day[0][1]));
?>
