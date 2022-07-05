<?php
$towers = ["+"]; 

fscanf(STDIN, "%d", $W);
fscanf(STDIN, "%d", $H);
for ($y = 0; $y < $H; $y++) {
    $line = stream_get_line(STDIN, 30 + 1, "\n");

    preg_match_all("/[^\.#+]/", $line, $matches, PREG_OFFSET_CAPTURE);

    //We found a tower
    foreach ($matches[0] as $match) {
        $towers[] = $match[0];
        $positions[] = [array_key_last($towers), $match[1], $y];
    }

    $map[] = $line;
}

error_log(var_export($map, true));

while(count($positions)) {

    $newPositions = [];

    //Check all the positions reached last turn
    foreach($positions as $position) {
        list($t, $x, $y) = $position;

        //Check the cardinal directions
        foreach([[0, -1], [-1, 0], [0, 1], [1, 0]] as $move) {
            $ux = $x + $move[0];
            $uy = $y + $move[1];

            //We can't go there
            if($ux < 0 || $ux >= $W || $uy < 0 || $uy >= $H || $map[$uy][$ux] != ".") continue;

            //2 towers can reach this spot the same turn
            if(isset($newPositions[$uy][$ux]) && $newPositions[$uy][$ux] != $t) {
                $newPositions[$uy][$ux] = 0;
            } else $newPositions[$uy][$ux] = $t;
        }
    }

    $positions = [];

    //Update the map and get the positions to check on next loop
    foreach($newPositions as $y => $line) {
        foreach($line as $x => $t) {
            $map[$y][$x] = $towers[$t];
            $positions[] = [$t, $x, $y];
        }
    }
}

echo implode("\n", $map);
?>
