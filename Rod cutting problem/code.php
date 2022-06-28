<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $L);

error_log(var_export($L, true));

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d %d", $length, $value);
    if($length <= $L )$lenghts[$length] = $value;
}

$memoization = [];

function solve($L) {
    global $lenghts, $memoization;

    if($L <= 0) return 0;
    if(isset($memoization[$L])) return $memoization[$L];

    $best = 0;

    foreach($lenghts as $length => $value) {
        //We checked all the lenght that can still be used
        if($length > $L) break;

        //Get the result if we use this length
        $result = solve($L - $length) + $value;

        //Check if we found a better solution
        if($result > $best) $best = $result;
    }

    //Save the solution for later
    $memoization[$L] = $best;

    return $best;
}

echo solve($L);
?>
