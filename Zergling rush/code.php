<?php

const DIRECTIONS = [[-1, 0], [1, 0], [0, -1], [0, 1]];
const NEIGHBORS = [[-1, -1], [0, -1], [1, -1], [-1, 0], [1, 0], [-1, 1], [0, 1], [1, 1]];

fscanf(STDIN, "%d %d", $W, $H);
for ($i = 0; $i < $H; $i++) {
    $map[] = stream_get_line(STDIN, $W + 1, "\n");
}

$visited = [];
for($y = 0; $y < $H; ++$y) {
    for($x = 0; $x < $W; ++$x) {
        //zerglings might enter from this position
        if(!isset($visited[$x. "-" . $y]) && ($x == 0 || $x == $W - 1 || $y == 0 || $y == $H - 1) && $map[$y][$x] == ".") {

            $toCheck = [[$x, $y]];

            //Flood fill all the positions the zerglings can reach
            while(count($toCheck)) {
                [$x, $y] = array_pop($toCheck);

                if(isset($visited[$x . "-" . $y])) continue;
                $visited[$x . "-" . $y] = 1;

                //Zerglings can move in the 4 cardinal directions
                foreach(DIRECTIONS as [$mx, $my]) {
                    $ux = $x + $mx;
                    $uy = $y + $my;

                    if($ux < 0 || $ux == $W || $uy < 0 || $uy == $H) continue;
                    if($map[$uy][$ux] == ".") $toCheck[] = [$ux, $uy];
                }

                //Zerglings will stick if they are adjacent to a building (even diagonally)
                foreach(NEIGHBORS as [$mx, $my]) {
                    $ux = $x + $mx;
                    $uy = $y + $my;

                    if($ux < 0 || $ux == $W || $uy < 0 || $uy == $H) continue;
                    if($map[$uy][$ux] == "B") {
                        $map[$y][$x] = "z";
                        continue 2;
                    }
                }
            }
        }
    }
}

echo implode("\n", $map);
?>
