<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $R);
fscanf(STDIN, "%d", $C);
fscanf(STDIN, "%d", $T);

error_log(var_export($R . " " .$C, true));
error_log(var_export("Threshold: " . $T, true));

$visited = [];

$toCheck = [[0, 0]];

while(count($toCheck)) {

    list($x, $y) = array_pop($toCheck);

    if(array_sum(str_split($x . $y)) > $T) continue;

    if(isset($visited[$x . " " . $y])) continue;
    else $visited[$x . " " . $y] = 1;

    foreach ([[0, -1], [-1, 0], [0, 1], [1, 0]] as $move) {
        $ux = $x + $move[0];
        $uy = $y + $move[1];

        if($ux < 0 || $ux == $R || $uy < 0 || $uy == $C) continue;

        $toCheck[] = [$ux, $uy]; 
    }
}

echo count($visited);
?>
