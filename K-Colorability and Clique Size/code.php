<?php

function findMaximumClique(int $last, array $current, array $potential) {
    global $maxClique, $links;

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

        findMaximumClique($vertex1, $current, array_intersect_key($potential, $links[$vertex1]));

        unset($current[$vertex1]);
    }
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

$minColors = 1;

//For each vertices get the min number of colors we need
foreach($vertices as $vertex => $filler) {
    $neighbors = $links[$vertex];

    $max = 0;

    foreach($neighbors as $neighbor => $filler) {
        $count = 0;

        foreach($links[$neighbor] as $vertex2 => $filler) {
            if($vertex2 == $vertex) continue;

            if(isset($neighbors[$vertex2])) ++$count; //This neighbor is also linked to another neighbor
        }

        $max = max($max, $count);
    }

    $minColors = max($minColors, $max + 2);
}

if($minColors <= $k) {
    $maxClique = 1;

    findMaximumClique(-1, [], $vertices);

    echo "YES " . $maxClique . PHP_EOL;
}
else echo "NO" . PHP_EOL;

error_log(microtime(1) - $start);
