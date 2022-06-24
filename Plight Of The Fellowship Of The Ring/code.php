<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d", $M);
fscanf(STDIN, "%d", $L);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d %d", $XS, $YS);
    $spots[] = [$XS, $YS, PHP_INT_MAX];
}

for ($i = 0; $i < $M; $i++) {
    fscanf(STDIN, "%d %d", $XO, $YO);

    //Get the distance to each node and update if this orc is the closest to the node we know
    foreach ($spots as $key => $spot) {
        $d = sqrt(pow($spot[0] - $XO, 2) + pow($spot[1] - $YO, 2));
        if($spot[2] > $d) $spots[$key][2] = $d;
    }
}

for ($i = 0; $i < $L; $i++) {
    fscanf(STDIN, "%d %d", $N1, $N2);
    $portals[$N1][] = $N2;
    $portals[$N2][] = $N1;
}

fscanf(STDIN, "%d", $S);
fscanf(STDIN, "%d", $E);

error_log(var_export("Start: " . $S . " End: " . $E, true));

$toCheck = [[$S, 1, []]];

//Test all the possible path
while(count($toCheck)) {

    list($spot, $units, $visited) = array_pop($toCheck);

    $visited[] = $spot;

    //The fellowship reached the end
    if($spot == $E) {
        if(!isset($solution) || count($visited) < count($solution)) $solution = $visited;

        continue;
    }

    //This solution can't be better
    if(isset($solution) && count($solution) <= $visited) continue;

    //Check all the possible paths from this spot
    foreach($portals[$spot] as $destination) {

        //We haven't been there already + no orc will kill you
        if($spots[$destination][2] > $units && !isset($visited[$destination])) {
            $toCheck[] = [$destination, $units + 1, $visited];
        }
    }
}

if(isset($solution)) echo implode(" ", $solution);
else echo "IMPOSSIBLE\n";
?>
