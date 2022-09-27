<?php

fscanf(STDIN, "%d", $n);

$s = microtime(true);
$listMoves = [];

// game loop
while (TRUE) {
    $cars = [];
    $state = 0;

    for ($i = 0; $i < $n; $i++) {
        fscanf(STDIN, "%d %d %d %d %s", $id, $x, $y, $length, $axis);

        //We only care about the inputs on first turn
        if(count($listMoves) == 0) {
            $carPosition = $x + $y * 6;
            $cars[$id] = $carPosition;
    
            //Update the state with all the positions occupied by this car
            for($l = 0; $l < $length; ++$l) {
                $state |= 1 << ($carPosition + ($l * (($axis == "H") ? 1 : 6)));
            }

            //Car is moving horizontally 
            if($axis == "H") {
                for($x2 = 0; $x2 <= 6 - $length; ++$x2) {
                    $startPosition = $y * 6 + $x2;

                    if($x2 > 0) $carMoves[$id][$startPosition][] = [
                        1 << ($startPosition - 1), //The position that needs to be free to make the move
                        1 << ($startPosition + $length - 1), //The position that's freed by doing the move
                        $startPosition - 1, //The new position of the car after the move
                        "LEFT" //The move direction
                    ];
                    if($x2 < 6 - $length) $carMoves[$id][$startPosition][] = [
                        1 << ($startPosition + $length), 
                        1 << $startPosition, 
                        $startPosition + 1, 
                        "RIGHT"
                    ];
                }
            } //Car is moving vertically
            else {
                for($y2 = 0; $y2 <= 6 - $length; ++$y2) {
                    $startPosition = $y2 * 6 + $x;

                    if($y2 > 0) $carMoves[$id][$startPosition][] = [
                        1 << ($startPosition - 6), 
                        1 << ($startPosition + (($length - 1) * 6)), 
                        $startPosition - 6, 
                        "UP"
                    ];
                    if($y2 < 6 - $length) $carMoves[$id][$startPosition][] = [
                        1 << ($startPosition + ($length * 6)), 
                        1 << $startPosition, 
                        $startPosition + 6, 
                        "DOWN"
                    ];
                }
            }
        }
    }

    //Generate the list of moves on the first turn
    if(count($listMoves) == 0) {
        $toCheck[] = [$cars, $state, []];
        $history = [];
        $turn = 0;

        //Do a BFS search for the solution
        while(count($toCheck)) {

            $newCheck = [];

            foreach($toCheck as $i => [$cars, $state, $list]) {

                //Our car reached the exit spot, direction the beach
                if($cars[0] == 16) {
                    $listMoves = $list;
                    error_log(("Finised in " . (microtime(true) - $s) . "s"));
                    break 2;
                }
        
                //Check all the cars
                foreach($cars as $index => $position) {
                    //Check the potential moves that the car can do based on it's current position
                    foreach($carMoves[$index][$cars[$index]] as [$needToBeFree, $needToFreed, $newPosition, $direction]) {
                        //If no other car is blocking the move
                        if(($state & $needToBeFree) == 0) {

                            $updatedState = ($state | $needToBeFree) ^ $needToFreed; //The new state after the car moves

                            //We have already reached the state by using less moves, skipping
                            if(!isset($history[$updatedState])) {
                                $history[$updatedState] = 1;
                                $cars[$index] = $newPosition;
                                $list[$turn] = $index . " " . $direction;
                                
                                $newCheck[] = [$cars, $updatedState, $list];

                                $cars[$index] = $position; //Reset car position
                            }
                        }
                    }
                }
            }

            ++$turn;
            $toCheck = $newCheck;
        }
    }

    echo array_shift($listMoves) . "\n";
}
?>
