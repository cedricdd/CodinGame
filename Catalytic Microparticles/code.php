<?php

fscanf(STDIN, "%d %d %d", $L, $W, $H);

for ($y = 0; $y < $L; $y++) {
    foreach(explode(" ", trim(fgets(STDIN))) as $z => $line) {
        foreach(str_split($line) as $x => $c) $shape[$x][$y][$z] = $c;
    }
}

//We need to mark all the "holes" that are part of the 'exterior'
for($x = 0; $x < $W; ++$x) {
    for($y = 0; $y < $L; ++$y) {
        for($z = 0; $z < $H; ++$z) {
            //Any holes starting at the exterior of the cube
            if(($x == 0 || $x == $W - 1 || $y == 0 || $y == $L - 1 || $z == 0 || $z == $H - 1) && $shape[$x][$y][$z] == 'o') {
                $toCheck = [[$x, $y, $z]];

                while($toCheck) {
                    [$x2, $y2, $z2] = array_pop($toCheck);

                    if($shape[$x2][$y2][$z2] != 'o') continue;
                    else $shape[$x2][$y2][$z2] = 'E';

                    //We can move in the 3 directions
                    foreach([[1, 0, 0], [-1, 0, 0], [0, 1, 0], [0, -1, 0], [0, 0, 1], [0, 0, -1]] as [$xm, $ym, $zm]) {
                        $xu = $xm + $x2;
                        $yu = $ym + $y2;
                        $zu = $zm + $z2;

                        if($xu >= 0 && $xu < $W && $yu >= 0 && $yu < $L && $zu >= 0 && $zu < $H && $shape[$xu][$yu][$zu] == 'o') $toCheck[] = [$xu, $yu, $zu];
                    }
                }
            }
        }
    }
}

$surface = 0;
$material = 0;
$holes = 0;

for($x = 0; $x < $W; ++$x) {
    for($y = 0; $y < $L; ++$y) {
        for($z = 0; $z < $H; ++$z) {
            if($shape[$x][$y][$z] == '#') {
                ++$material;

                //For each positions we check the 6 faces (left, right, up, down, front, back), if we have an exterior piece or if we are outside this face is part of the surface area
                if(($shape[$x - 1][$y][$z] ?? 'E') == 'E') ++$surface; //Left
                if(($shape[$x + 1][$y][$z] ?? 'E') == 'E') ++$surface; //Right
                if(($shape[$x][$y - 1][$z] ?? 'E') == 'E') ++$surface; //Up
                if(($shape[$x][$y + 1][$z] ?? 'E') == 'E') ++$surface; //Down
                if(($shape[$x][$y][$z + 1] ?? 'E') == 'E') ++$surface; //Front
                if(($shape[$x][$y][$z - 1] ?? 'E') == 'E') ++$surface; //Back
            }
            if($shape[$x][$y][$z] == 'o') ++$holes;
        }
    }
}

echo number_format($surface / $material, 4) . " " . number_format($material / ($material + $holes), 4) . PHP_EOL;
