<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $M);
fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $M; $i++) {
    $map[] = stream_get_line(STDIN, 100 + 1, "\n");
}

error_log(var_export($map, true)); 

$memorization["0 0"] = 1;

function solve($x, $y) {
    global $map, $memorization;

    //Use saved value
    if(isset($memorization[$x . " " . $y])) return $memorization[$x . " " . $y];

    //We can't come from this position
    if($x < 0 || $y < 0 || $map[$y][$x] == 1) return 0;
    
    //We can only come from top or left, the number of path is the sum
    $result = solve($x, $y - 1) + solve($x - 1, $y);

    //Save the value for later
    $memorization[$x . " " . $y] = $result;
    return $result;
}

echo solve($M - 1, $N - 1);
?>
