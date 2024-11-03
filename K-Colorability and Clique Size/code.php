<?php

function findMaximumClique(int $last, array $current, array $potential) {
    global $maxClique, $links;

    //No vertices that can still be added
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

        findMaximumClique($vertex1, $current, array_intersect_key($potential, $links[$vertex1]));

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

$vertices = [];

fscanf(STDIN, "%d %d", $n, $m);
for ($i = 0; $i < $m; $i++) {
    fscanf(STDIN, "%d %d", $u, $v);

    $links[$u][$v] = 1;
    $links[$v][$u] = 1;

    $vertices[$u] = 1;
    $vertices[$v] = 1;
}

fscanf(STDIN, "%d", $k);

$maxClique = 1;

findMaximumClique(-1, [], $vertices);

$minColors = solve($n, array_fill(0, $n, 0), 0);

if($minColors <= $k) echo "YES " . $maxClique . PHP_EOL;
else echo "NO" . PHP_EOL;

error_log(microtime(1) - $start);
