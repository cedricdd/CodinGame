<?php

fscanf(STDIN, "%d", $N);

$ix = -1;
$iy = -1;
$columns = array_fill(0, $N, [1, 0]);

for ($y = 0; $y < $N; $y++){
    $incX = true;
    $line = stream_get_line(STDIN, $N + 1, "\n");

    foreach(str_split($line) as $x => $c) {
        if($c == ".") {
            //A new independent part of the row starts => increase id
            if($incX) {
                ++$ix;
                $incX = false;
            }

            //A new independent part of the column starts => increase id
            if($columns[$x][0]) $columns[$x] = [0, ++$iy];

            $G[$ix][] = $columns[$x][1];
        }
        else {
            $incX = true;
            $columns[$x][0] = 1;
        }
    }
}

//https://en.wikipedia.org/wiki/Hopcroft%E2%80%93Karp_algorithm
function HopcroftKarp(int $i, array &$G, array &$M, array $S): bool {

    //First test if we can directly use one of the values of G[$i]
    foreach($G[$i] as $v) {
        if(!isset($M[$v])) {
            $M[$v] = $i;
            return true;
        }
    }

    //All the values are already used, try to "liberate" one
    foreach($G[$i] as $v) {
        if(isset($S[$v])) continue; //This is one of the values we want to free

        $S[$v] = 1;
        //The value has been "liberated", it can now be used
        if(HopcroftKarp($M[$v], $G, $M, $S)) {
            $M[$v] = $i;
            return true;
        }
    }

    return false;
}

$M = array_fill(0, $iy + 1, null);

for($i = 0; $i <= $ix; ++$i) {
    HopcroftKarp($i, $G, $M, []);
}

echo count(array_filter($M, 'is_numeric')) . "\n";
?>
