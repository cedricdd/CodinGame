<?php

fscanf(STDIN, "%d", $w);
fscanf(STDIN, "%d", $h);
for ($i = 0; $i < $h; $i++){
    $line = trim(fgets(STDIN));

    error_log($line);

    $sheet[] = str_split($line);
}

$zoneIndex = 0;

//Assign a zone ID to each blank space
for($y = 0; $y < $h; ++$y) {
    for($x = 0; $x < $w; ++$x) {
        if($sheet[$y][$x] != ' ' || isset($zone[$y][$x])) continue;

        $toCheck = [[$x, $y]];

        while($toCheck) {
            [$x2, $y2] = array_pop($toCheck);

            if(isset($zone[$y2][$x2])) continue;

            $zone[$y2][$x2] = $zoneIndex;

            foreach([[1, 0], [-1, 0], [0, 1], [0, -1]] as [$xm, $ym]) {
                $x3 = $x2 + $xm;
                $y3 = $y2 + $ym;

                if(($sheet[$y3][$x3] ?? '*') == ' ') $toCheck[] = [$x3, $y3];
            }
        }

        ++$zoneIndex;
    }
}

$nbrColors = 1;

//For each characters that can be a seperator between zones, check how many zones we have.
for($y = 1; $y < $h - 1; ++$y) {
    for($x = 1; $x < $w - 1; ++$x) {
        if($sheet[$y][$x] != ' ') {
            $zones = [];

            if(isset($zone[$y - 1][$x - 1])) $zones[] = $zone[$y - 1][$x - 1];
            if(isset($zone[$y - 1][$x + 1])) $zones[] = $zone[$y - 1][$x + 1];
            if(isset($zone[$y + 1][$x - 1])) $zones[] = $zone[$y + 1][$x - 1];
            if(isset($zone[$y + 1][$x + 1])) $zones[] = $zone[$y + 1][$x + 1];

            $zones = array_unique($zones);
            $count = count($zones);

            if($count == 4) $count >>= 1; //Touching diagonally is not adjacent, if we have 4 we only need 2 colors.

            $nbrColors = max($nbrColors, $count);
        }
    }
}

echo $nbrColors . PHP_EOL;
