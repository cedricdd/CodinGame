<?php

fscanf(STDIN, "%d %d", $W, $H);
for ($i = 0; $i < $H; $i++) {
    $city[] = stream_get_line(STDIN, 100 + 1, "\n");
}

$buildings = [];

for($y = 0; $y < $H; ++$y) {
    //It's the first line with a part of a building
    if(!empty(trim($city[$y]))) {
        while(($pos = strpos($city[$y], '#')) !== false) {
            //Flood-fill the building
            $building = [];
            $minX = INF;
            $maxX = 0;
            $toCheck = [[$pos, $y]];

            while($toCheck) {
                [$x2, $y2] = array_pop($toCheck);

                $city[$y2][$x2] = " ";

                $building[$y2][] = $x2;

                if($x2 < $minX) $minX = $x2;
                if($x2 > $maxX) $maxX = $x2;

                foreach([[1, 0], [-1, 0], [0, 1], [0, -1]] as [$xm, $ym]) {
                    $xu = $x2 + $xm;
                    $yu = $y2 + $ym;

                    if($xu >= 0 && $xu < $W && $yu >= 0 && $yu < $H && $city[$yu][$xu] == "#") $toCheck[] = [$xu, $yu];
                }
            }

            //We have found all the parts of the building
            foreach($building as $y2 => $list) {
                $line = str_repeat(" ", $maxX - $minX + 1);
                
                foreach($list as $x2) $line[$x2 - $minX] = "#";

                $building[$y2] = rtrim($line);
            }

            $buildings[] = implode("\n", $building);
        }

        break; //We only want the highest buildings
    }
}

echo implode("\n\n", $buildings) . PHP_EOL;
