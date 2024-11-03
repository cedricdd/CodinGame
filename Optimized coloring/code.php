<?php

//Find the maximum clique in the graph
function findMaximumClique(int $last, array $current, array $potential) {
    global $links, $maxClique;

    //no vertices that can still be added
    if(count($potential) == 0) {
        $maxClique = max($maxClique, count($current));
 
        return;
    }

    foreach($potential as $vertex1 => $filler) {
        if($last >= $vertex1) continue; //No need to test the same vertices in different orders

        foreach($current as $vertex2 => $filler) {
            if(!isset($links[$vertex1][$vertex2])) continue 2; //By using this vertex it's no longer a clique
        }

        $current[$vertex1] = 1; //We can add this vertex

        findMaximumClique($vertex1, $current, array_intersect_key($potential, ($links[$vertex1] ?? [])));

        unset($current[$vertex1]);
    }
}


function solve(int $count, array $colors, int $vertices): int {
    global $links, $maxClique;
    
    if($vertices == $count) return max($colors);

    $minColors = $count;

    for($i = 0; $i < $count; ++$i) {
        if($colors[$i] != 0) continue;

        //Working on vertex $i
        $possibleColors = array_fill(1, $count + 1, 1);

        foreach(($links[$i] ?? []) as $neighbor => $filler) {
            unset($possibleColors[$colors[$neighbor]]);
        }

        $color = array_key_first($possibleColors); //The color we are going to use for this vertex

        $colors[$i] = $color;

        $minColors = min($minColors, solve($count, $colors, $vertices + 1));

        if($minColors == $maxClique) break; //We know maxClique is the lower bound, we can't find a solution any lower

        $colors[$i] = 0;
    }

    return $minColors;
}

$start = microtime(1);

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

$maxClique = 0;
$nbrColors = 1;
$links = [];

//For each characters that can be a seperator between zones.
for($y = 1; $y < $h - 1; ++$y) {
    for($x = 1; $x < $w - 1; ++$x) {
        if($sheet[$y][$x] != ' ') {
            if($x > 1 && $x < $w - 2) {
                if($sheet[$y][$x - 1] == ' ' && $sheet[$y][$x + 1] == ' ') {
                    $z1 = $zone[$y][$x - 1];
                    $z2 = $zone[$y][$x + 1];

                    //We have different zones on the left & right
                    if($z1 != $z2) {
                        $links[$z1][$z2] = 1;
                        $links[$z2][$z1] = 1;
                    }
                }
            }
            if($y > 1 && $y < $h - 1) {
                if($sheet[$y - 1][$x] == ' ' && $sheet[$y + 1][$x] == ' ') {
                    $z1 = $zone[$y - 1][$x];
                    $z2 = $zone[$y + 1][$x];

                    //We have different zones on the top & bottom
                    if($z1 != $z2) {
                        $links[$z1][$z2] = 1;
                        $links[$z2][$z1] = 1;
                    }
                }  
            }
        }
    }
}


if($zoneIndex == 0) echo "1" . PHP_EOL;
else {
    findMaximumClique(-1, [], array_fill(0, $zoneIndex, 1));
    echo solve($zoneIndex, array_fill(0, $zoneIndex, 0), 0) . PHP_EOL;
}

error_log(microtime(1) - $start);
