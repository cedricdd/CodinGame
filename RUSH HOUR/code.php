<?php

// $n: Number of vehicles
fscanf(STDIN, "%d", $n);

$moves = [];

// game loop
while (TRUE)
{
    $cars = [];
    $state = 0;

    for ($i = 0; $i < $n; $i++) {
        fscanf(STDIN, "%d %d %d %d %s", $id, $x, $y, $length, $axis);

        $position = $x + $y * 6;

        //Save car info
        if($axis == "H") $carsH[$id] = [$position, $length, $y * 6, $y * 6 + (6 - $length)];
        else $carsV[$id] = [$position, $length, $x, (6 - $length) * 6 + $x];

        //Update the state with all the positions occupied by this car
        for($c = 0; $c < $length; ++$c) {
            $state |= 1 << ($position + ($c * (($axis == "H") ? 1 : 6)));
        }
    }

    if(count($moves) == 0) {
        $toCheck[] = [$state, $carsH, $carsV, []];

        //Do a BFS search for the solution
        while(count($toCheck)) {

            $newCheck = [];

            foreach($toCheck as [$state, $H, $V, $list]) {

                //Car reached the exit spot, we are over
                if($H[0][0] == 16) {
                    $moves = array_reverse($list);
                    break 2;
                }
        
                if(isset($history[$state])) continue;
                else $history[$state] = 1;

                //Cars that move horizontally
                foreach($H as $id => [$p, $l, $min, $max]) {
                    //Check moving left
                    if($p > $min && !($state & (1 << ($p - 1)))) {
                        $stateC = $state;
                        $stateC ^= (1 << ($p - 1)) + (1 << ($p + $l - 1));

                        $H[$id][0] = $p - 1;
                        $list[] = "$id LEFT";

                        $newCheck[] = [$stateC, $H, $V, $list];

                        array_pop($list);
                    }

                    //Check moving right
                    if($p < $max && !($state & (1 << ($p + $l)))) {
                        $stateC = $state;
                        $stateC ^= (1 << $p) + (1 << ($p + $l));

                        $H[$id][0] = $p + 1;
                        $list[] = "$id RIGHT";

                        $newCheck[] = [$stateC, $H, $V, $list];

                        array_pop($list);
                    }

                    $H[$id][0] = $p; //Reset for next cars
                }

                //Cars that move vertically
                foreach($V as $id => [$p, $l, $min, $max]) {
                    //Check moving up
                    if($p > $min && !($state & (1 << ($p - 6)))) {
                        $stateC = $state;
                        $stateC ^= (1 << ($p + ($l - 1) * 6)) + (1 << ($p - 6));
            
                        $V[$id][0] = $p - 6;
                        $list[] = "$id UP";

                        $newCheck[] = [$stateC, $H, $V, $list];

                        array_pop($list);
                    }

                    //Check moving down
                    if($p < $max && !($state & (1 << ($p + $l * 6)))) {
                        $stateC = $state;
                        $stateC ^= (1 << $p) + (1 << ($p + $l * 6));

                        $V[$id][0] = $p + 6;
                        $list[] = "$id DOWN";

                        $newCheck[] = [$stateC, $H, $V, $list];

                        array_pop($list);
                    }
                
                    $V[$id][0] = $p; //Reset for next cars
                }

                $toCheck = $newCheck;
            }
        }
    }

    echo array_pop($moves) . "\n";
}
?>
