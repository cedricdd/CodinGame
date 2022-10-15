<?php

const MOVES = ["^" => [0, -1], ">" => [1, 0], "v" => [0, 1], "<" => [-1, 0]];

fscanf(STDIN, "%d %d", $w, $h);
for ($i = 0; $i < $h; $i++) {
    fscanf(STDIN, "%s", $map[]);
}

error_log(var_export($map, true));

$visited = [];
$loops = 0;

for($y = 0; $y < $h; ++$y) {
    for($x = 0; $x < $w; ++$x) {
        if(isset($visited[$y][$x]) || $map[$y][$x] == ".") continue;

        $pathX = $x;
        $pathY = $y;
        $loop = [];
       
        //Check if current position is part of a loop
        while(true) {

            $loop[$pathY][$pathX] = 1;
            [$moveX, $moveY] = MOVES[$map[$pathY][$pathX]];

            //Moving to the closest arrow in the move direction
            do {
                $pathX += $moveX;
                $pathY += $moveY;

                //Pointing outside of the map
                if($pathX < 0 || $pathX >= $w || $pathY < 0 || $pathY >= $h) continue 3;
            } while($map[$pathY][$pathX] == ".");

            //We found a loop
            if(isset($loop[$pathY][$pathX])) {
                ++$loops;
                continue 2;
            } 
            
            if(isset($visited[$pathY][$pathX])) continue 2; //We reached a position we already checked, can't be a new loop
            else $visited[$pathY][$pathX] = 1;
        }
    }
}

echo $loops . PHP_EOL;
