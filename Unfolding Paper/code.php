<?php

const LEFT = 1;
const RIGHT = 2;
const TOP = 4;
const BOTTOM = 8;

fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d %d", $W, $H);

for ($i = 0; $i < $H; $i++) {
    $paper[] = trim(fgets(STDIN));
}

$total = 0;

for($y = 0; $y < $H; ++$y) {
    for($x = 0; $x < $W; ++$x) {
        if($paper[$y][$x] == '#') {
            $group = 0;

            $toCheck = [[$x, $y]];

            while($toCheck) {
                [$x2, $y2] = array_pop($toCheck);

                if($paper[$y2][$x2] != '#') continue;

                if($x2 == 0) $group |= LEFT; //Left
                if($x2 == $W - 1) $group |= RIGHT; //Right
                if($y2 == 0) $group |= TOP; //Top
                if($y2 == $H - 1) $group |= BOTTOM; //Bottom

                $paper[$y2][$x2] = '.';

                foreach([[1, 0], [-1, 0], [0, 1], [0, -1]] as [$xm, $ym]) {
                    $xu = $x2 + $xm;
                    $yu = $y2 + $ym;

                    if($xu >= 0 && $xu < $W && $yu >= 0 && $yu < $H) $toCheck[] = [$xu, $yu];
                }
            }

            switch($group) {
                case 0: $total += 2 ** ($N * 2); break;
                case 1: //Left 
                case 4: //Top
                    $total += 2 * (2 ** (($N - 1) * 2)); break; 
                case 2: //Right 
                case 8: //Bottom 
                    $total += (2 ** $N) * ((2 ** ($N - 1)) + 1); break; 
                case 3: //Left & Right 
                case 12: //Top & Bottom
                    $total += 2 ** $N; break;
                case 5: $total += 2 ** (($N - 1) * 2); break; //Top & Left 
                case 6: //Top & Right 
                case 9: //Bottom & Left
                    $total += (2 ** ($N - 1)) * ((2 ** ($N - 1)) + 1); break; 
                case 7: //Top, Left & Right 
                case 13 : //Top, Bottom & Left
                    $total += 2 ** ($N - 1); break; 
                case 10: $total += ((2 ** ($N - 1)) + 1) * ((2 ** ($N - 1)) + 1); break; //Bottom & Right 
                case 11: //Bottom, Left & Right 
                case 14: //Top, Bottom & Right
                    $total += (2 ** ($N - 1)) + 1; break;
                case 15: $total += 1; break; //Top, Bottom, Left & Right
                }
        }
    }
}

echo $total . PHP_EOL;
