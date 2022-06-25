<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d %d", $M, $S);

error_log(var_export("stations " . $M, true));
error_log(var_export("wireless " . $S, true));

$groups = $M;
$stations = [];

for ($i = 0; $i < $M; $i++) {
    fscanf(STDIN, "%d %d", $x, $y);

    //We calculate the distance between this station and the existing stations
    foreach ($stations as $key => $station) {
        $links[$key . " " . $i] = sqrt( pow($x - $station[0], 2) + pow($y - $station[1], 2) );
    }

    $stations[] = [$x, $y, $i];
}

asort($links);

foreach($links as $key => $value) {
    list($s1, $s2) = explode(" ", $key);

    $g1 = $stations[$s1][2];
    $g2 = $stations[$s2][2];

    //Both stations are already on the same group, move to next link
    if($g1 == $g2) continue;

    //Two groups have been linked, we switched all the members of group #2 to group #1
    foreach($stations as $key => $station) {
        if($station[2] == $g2) $stations[$key][2] = $g1;
    }

    //We have enough wireless to link all the remaining groups, we are done
    if(--$groups == $S) break;
}

echo number_format($value, 2, '.', '');
?>
