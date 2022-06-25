<?php
//https://en.wikipedia.org/wiki/Even%E2%80%93odd_rule

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d %d", $x, $y);

    $polygon[] = [$x, $y];
}

fscanf(STDIN, "%d", $M);
for ($a = 0; $a < $M; $a++) {
    fscanf(STDIN, "%d %d", $x, $y);

    $inside = false;
    $j = count($polygon) - 1;

    for($i = 0; $i < count($polygon); ++$i) {
        //The point is one of the cornes => hit
        if($x == $polygon[$i][0] && $y == $polygon[$i][1]) {
            echo "hit\n";
            continue 2;
        }
        if(($polygon[$i][1] > $y) != ($polygon[$j][1] > $y)) {
            $slope = ($x - $polygon[$i][0]) * ($polygon[$j][1] - $polygon[$i][1]) - ($polygon[$j][0] - $polygon[$i][0]) * ($y - $polygon[$i][1]);

            //Point is on boundary => hit
            if($slope == 0) {
                echo "hit\n";
                continue 2;
            }

            //Crossing a border of the polygon
            if($slope < 0 != ($polygon[$j][1] < $polygon[$i][1])) $inside = !$inside;
        }
        $j = $i;
    }

    //If we crossed a border an odd number of time the point is inside
    echo ($inside) ? "hit\n" : "miss\n";
}
?>
