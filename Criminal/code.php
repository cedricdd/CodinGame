<?php

$grid = [];

fscanf(STDIN, "%d", $H);
fscanf(STDIN, "%d", $W);
for ($y = 0; $y < $H; ++$y) {
    $row = trim(fgets(STDIN));

    foreach(str_split($row) as $x => $c) {
        if($c == 'Y') {
            $mx = $x;
            $my = $y;
        }
        elseif($c == '^' || $c == '<' || $c == '>' || $c == 'v') $people[] = [$x, $y, $c];
    }

    $grid[] = $row;
}

error_log(var_export($grid, true));

$count = 0;

foreach($people as [$x, $y, $c]) {
    $i = 1;
    $field = [];

    //Looking down
    if($c == 'v') {
        //Everything in field of view
        for($y2 = $y + 1; $y2 < $H; ++$y2) {
            for($x2 = max(0, $x - $i); $x2 < min($x + $i + 1, $W); ++$x2) {
                $field[$y2][$x2] = 1;
            }

            ++$i;
        }

        //Remove everything blocked by an obstacle
        foreach($field as $y2 => $list) {
            foreach($list as $x2 => $filler) {
                if($mx == $x2 && $my == $y2) continue;

                if($grid[$y2][$x2] != '.') {
                    //Same col
                    if($x2 == $x) {
                        for($y3 = $y2 + 1; $y3 < $H; ++$y3) unset($field[$y3][$x2]);
                    }
                    //Left
                    elseif($x2 < $x) {
                        $i = 0;

                        for($x3 = $x2; $x3 >= 0; --$x3) {
                            for($y3 = $y2 + $i; $y3 < $H; ++$y3) unset($field[$y3][$x3]);

                            ++$i;
                        }
                    }
                    //Right
                    elseif($x2 > $x) {
                        $i = 0;

                        for($x3 = $x2; $x3 < $W; ++$x3) {
                            for($y3 = $y2 + $i; $y3 < $H; ++$y3) unset($field[$y3][$x3]);

                            ++$i;
                        }
                    }
                }
            }
        }
    //Looking up
    } elseif($c == '^') {
        //Everything in field of view
        for($y2 = $y - 1; $y2 >= 0; --$y2) {
            for($x2 = max(0, $x - $i); $x2 < min($x + $i + 1, $W); ++$x2) {
                $field[$y2][$x2] = 1;
            }

            ++$i;
        }

        //Remove everything blocked by an obstacle
        foreach($field as $y2 => $list) {
            foreach($list as $x2 => $filler) {
                if($mx == $x2 && $my == $y2) continue;

                if($grid[$y2][$x2] != '.') {
                    //Same col
                    if($x == $x2) {
                        for($y3 = $y2 - 1; $y3 >= 0; --$y3) unset($field[$y3][$x2]);
                    }
                    //Left
                    elseif($x2 < $x) {
                        $i = 0;

                        for($x3 = $x2; $x3 >= 0; --$x3) {
                            for($y3 = $y2 - $i; $y3 >= 0; --$y3) unset($field[$y3][$x3]);

                            ++$i;
                        }
                    }
                    //Right
                    elseif($x2 > $x) {
                        $i = 0;

                        for($x3 = $x2; $x3 < $W; ++$x3) {
                            for($y3 = $y2 - $i; $y3 >= 0;  --$y3) unset($field[$y3][$x3]);

                            ++$i;
                        }
                    }
                }
            }
        }

    //Looking left
    } elseif($c == '<') {
        //Everything in field of view
        for($x2 = $x - 1; $x2 >= 0; --$x2) {
            for($y2 = max(0, $y - $i); $y2 < min($y + $i + 1, $H); ++$y2) {
                $field[$y2][$x2] = 1;
            }

            ++$i;
        }

        //Remove everything blocked by an obstacle
        foreach($field as $y2 => $list) {
            foreach($list as $x2 => $filler) {
                if($mx == $x2 && $my == $y2) continue;

                if($grid[$y2][$x2] != '.') {
                    //Same row
                    if($y2 == $y) {
                        for($x3 = $x2 - 1; $x3 >= 0; --$x3) unset($field[$y2][$x3]);
                    }
                    //Below
                    elseif($y2 > $y) {
                        $i = 0;

                        for($y3 = $y2; $y3 < $H; ++$y3) {
                            for($x3 = $x2 - $i; $x3 >= 0; --$x3) unset($field[$y3][$x3]);

                            ++$i;
                        }
                    }
                    //Above
                    elseif($y2 < $y) {
                        $i = 0;

                        for($y3 = $y2; $y3 >= 0; --$y3) {
                            for($x3 = $x2 - $i; $x3 >= 0; --$x3) unset($field[$y3][$x3]);

                            ++$i;
                        }
                    }
                }

            }
        }
    //Looking right
    } elseif($c == '>') {
        //Everything in field of view
        for($x2 = $x + 1; $x2 < $W; ++$x2) {
            for($y2 = max(0, $y - $i); $y2 < min($y + $i + 1, $H); ++$y2) {
                $field[$y2][$x2] = 1;
            }

            ++$i;
        }

        //Remove everything blocked by an obstacle
        foreach($field as $y2 => $list) {
            foreach($list as $x2 => $filler) {
                if($mx == $x2 && $my == $y2) continue;

                if($grid[$y2][$x2] != '.') {
                    //Same row
                    if($y2 == $y) {
                        for($x3 = $x2 + 1; $x3 < $W; ++$x3) unset($field[$y2][$x3]);
                    }
                    //Below
                    elseif($y2 > $y) {
                        $i = 0;

                        for($y3 = $y2; $y3 < $H; ++$y3) {
                            for($x3 = $x2 + $i; $x3 < $W; ++$x3) unset($field[$y3][$x3]);

                            ++$i;
                        }
                    }
                    //Above
                    elseif($y2 < $y) {
                        $i = 0;

                        for($y3 = $y2; $y3 >= 0; --$y3) {
                            for($x3 = $x2 + $i; $x3 < $W; ++$x3) unset($field[$y3][$x3]);

                            ++$i;
                        }
                    }
                }
            }
        }
    }

    if(isset($field[$my][$mx])) {
        error_log("person at $x $y can see you");
        ++$count;
    }
}

echo $count . PHP_EOL;
