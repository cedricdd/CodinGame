<?php

$start = microtime(1);

$H1 = trim(fgets(STDIN));
$H2 = trim(fgets(STDIN));
$V1 = trim(fgets(STDIN));
$V2 = trim(fgets(STDIN));

$solutions = [];

foreach(str_split($H1) as $i1 => $c1) {
    //Find all the characters $c1 in V1
    foreach(str_split($V1) as $i2 => $c2) {
        if($c1 == $c2) {
            //We are crossing H1 & V1, check if we can we still cross H1 & V2
            foreach(str_split($H1) as $i3 => $c3) {
                //Words need to be at least one column apart, we can't use this character for V2
                if(abs($i1 - $i3) <= 1) continue;

                //Find all the characters $c3 in V2
                foreach(str_split($V2) as $i4 => $c4) {
                    if($c3 == $c4) {
                        $distanceV = $i3 - $i1; //Distance between V1 & V2

                        foreach(str_split($V1) as $i5 => $c5) {
                            //Words need to be at least one row apart, we can't use this character for H2
                            if(abs($i2 - $i5) <= 1) continue;

                            foreach(str_split($H2) as $i6 => $c6) {
                                if($c5 == $c6) {
                                    $i7 = $i6 + $distanceV; //The position where H2 will cross V2 on H2

                                    if($i7 < 0 || $i7 >= strlen($H2)) continue; //Invalid position
                                    else {
                                        $distanceH = $i5 - $i2; //Distance between H1 & H2

                                        $i8 = $i4 + $distanceH; //The position where H2 will cross V2 on V2

                                        //We have found a valid solution
                                        if($i8 >= 0 && $i8 < strlen($V2) && $V2[$i8] == $H2[$i7]) {
                                            //Build the grid representing the solution
                                            $solution = [];
                                            $minX = 0;
                                            $minY = 0;
                                            $maxX = 0;
                                            $maxY = 0;

                                            foreach(str_split($H1) as $i => $c) $solution[0][$i] = $c;
                                            $maxX = max($maxX, $i);

                                            foreach(str_split($V1) as $i => $c) $solution[$i - $i2][$i1] = $c;
                                            $minY = min($minY, -$i2);
                                            $maxY = max($maxY, $i - $i2);

                                            foreach(str_split($V2) as $i => $c) $solution[$i - $i4][$i3] = $c;
                                            $minY = min($minY, -$i4);
                                            $maxY = max($maxY, $i - $i4);

                                            foreach(str_split($H2) as $i => $c) $solution[$distanceH][$i1 - $i6 + $i] = $c;
                                            $minX = min($minX, $i1 - $i6);
                                            $maxX = max($maxX, $i1 - $i6 + $i);

                                            $solutions[] = [$solution, $minX, $maxX, $minY, $maxY];
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

//Only one solution, we output it
if(count($solutions) == 1) {
    [$solution, $minX, $maxX, $minY, $maxY] = $solutions[0];

    for($y = $minY; $y <= $maxY; ++$y) {
        $line = "";

        for($x = $minX; $x <= $maxX; ++$x) {
            $line .= $solution[$y][$x] ?? ".";
        }

        echo $line . PHP_EOL;
    }
}
else echo count($solutions) . PHP_EOL;

error_log(microtime(1) - $start);
