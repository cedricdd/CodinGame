<?php

$gridID = 0;

for ($y = 0; $y < 5; $y++) {
    $line = stream_get_line(STDIN, 5 + 1, "\n");

    foreach (str_split($line) as $x => $c) {
        if($c != ".") {
            $pods[$c] = [$x, $y]; //Save pod position
            $gridID |= 1 << $x + $y * 5; //Update current grid ID
        }
    }
}

//We want the first solution by alphabetical order, so we test pods in alphabetical order
ksort($pods);

$toCheck[] = [$pods, [], $gridID];
$history = [];

while(true) {

    $newCheck = [];

    //We want the shortest solution
    foreach($toCheck as $info) {
        list($pods, $list, $gridID) = $info;

        //Don't check 'similar' solutions
        if(isset($history[$gridID])) continue;
        else $history[$gridID] = 1;

        //Create the grid with the current positions of the pods
        $grid = array_fill(0, 5, str_repeat(".", 5));

        foreach($pods as $c => $pod) {
            $grid[$pod[1]][$pod[0]] = $c;
        }

        //Check the 4 cardinal directions for all the pods in alphabetical order (D, L, R, U)
        foreach($pods as $c => $pod) {
            list($x, $y) = $pod;

            //Spacepod is over the Emergency Entry Port
            if($c == "X" && $x == 2 && $y == 2) {
                echo implode(" ", $list) . "\n\n";
                echo implode("\n", $grid);
                exit();
            }

            //Pod could potentially move down
            if($y < 3 && $grid[$y + 1][$x] == ".") {
                for($y2 = $y + 2; $y2 < 5; ++$y2) {
                    if($grid[$y2][$x] != ".") {
                        $updated = $pods;
                        $updated[$c][1] = $y2 - 1;

                        $newCheck[] = [$updated, array_merge($list, [$c . "D"]), $gridID ^ 1 << $x + $y * 5 | 1 << $x + ($y2 - 1) * 5];
                        break;
                    } 
                }
            }

            //Pod could potentially move left
            if($x > 1 && $grid[$y][$x - 1] == ".") {
                for($x2 = $x - 2; $x2 >= 0; --$x2) {
                    if($grid[$y][$x2] != ".") {
                        $updated = $pods;
                        $updated[$c][0] = $x2 + 1;

                        $newCheck[] = [$updated, array_merge($list, [$c . "L"]), $gridID ^ 1 << $x + $y * 5 | 1 << ($x2 + 1) + $y * 5];
                        break;
                    }
                }
            }

            //Pod could potentially move right
            if($x < 3 && $grid[$y][$x + 1] == ".") {
                for($x2 = $x + 2; $x2 < 5; ++$x2) {
                    if($grid[$y][$x2] != ".") {
                        $updated = $pods;
                        $updated[$c][0] = $x2 - 1;

                        $newCheck[] = [$updated, array_merge($list, [$c . "R"]), $gridID ^ 1 << $x + $y * 5 | 1 << ($x2 - 1) + $y * 5];
                        break;
                    }
                }
            }

            //Pod could potentially move up
            if($y > 1 && $grid[$y - 1][$x] == ".") {
                for($y2 = $y - 2; $y2 >= 0; --$y2) {
                    if($grid[$y2][$x] != ".") {
                        $updatedPods = $pods;
                        $updatedPods[$c][1] = $y2 + 1;

                        $newCheck[] = [$updatedPods, array_merge($list, [$c . "U"]), $gridID ^ 1 << $x + $y * 5 | 1 << $x + ($y2 + 1) * 5];
                        break;
                    }
                }
            }
        }
    }

    $toCheck = $newCheck;
}
?>
