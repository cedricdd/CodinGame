<?php

function findNextRoomToExplore(int $position, int $thre = 1): ?array {
    global $visited, $links, $rooms;

    $history = [];
    $queue[0] = [$position, []];

    for($i = 0; ;++$i) {
        if(!isset($queue[$i])) return null;

        [$position, $path] = $queue[$i];

        if(isset($path[$position]) || $rooms[$position] > ($allowBats ? 3 : 1) || isset($history[$position])) continue;
        
        $history[$position] = true;
        $path[$position] = $position;

        if(!isset($visited[$position])) return $path;

        foreach($links[$position] as $neighbor => $_) {
            $queue[] = [$neighbor, $path];
        }

        unset($queue[$i]);
    }
}

function goToShootingPosition(int $position, array $path = []): ?array {
    global $mumpusPosition, $links, $rooms;

    $history = [];
    $queue[0] = [$position, []];

    for($i = 0; ;++$i) {
        if(!isset($queue[$i])) return null;

        [$position, $path] = $queue[$i];

        if(isset($path[$position]) || $rooms[$position] != 1 || isset($history[$position])) continue;
        
        $history[$position] = true;
        $path[$position] = $position;

        if(isset($links[$position][$mumpusPosition])) return $path;

        foreach($links[$position] as $neighbor => $_) {
            $queue[] = [$neighbor, $path];
        }

        unset($queue[$i]);
    }
}

function updateRooms($infoIndex) {
    global $rooms, $infos, $infosRemoved, $mumpusPosition, $batTargetPosition;

    [$neighbors, [$bats, $shaft, $mumpus]] = $infos[$infoIndex];

    error_log("working on info $infoIndex (" . implode('-', array_keys($neighbors)) . " $bats, $shaft, $mumpus) -- $batTargetPosition");

    $candidates = $neighbors;

    foreach($neighbors as $roomID => $_)
        //It's a power of two, we are sure what's in the room
        if(($rooms[$roomID] & ($rooms[$roomID] - 1)) == 0) {
            unset($candidates[$roomID]);

            if($batTargetPosition === $roomID) --$bats;
            else {
                switch ($rooms[$roomID]) {
                    case 2: --$bats; break;
                    case 4: --$shaft; break;
                    case 8: --$mumpus; break;
                }
            }
        }

    if($bats + $shaft + $mumpus == 0) {
        foreach($candidates as $roomID => $_) {
            $rooms[$roomID] = 1;
            unset($candidates[$roomID]);
        }
    }

    if(count($candidates) == 0) {
        unset($infos[$infoIndex]);
        $infosRemoved[$infoIndex] = true;
        error_log("we remove info index $infoIndex");
        return;
    }

    $hashDanger = ($bats ? 2 : 0) | ($shaft ? 4 : 0) | ($mumpus ? 8 : 0);

    if(count($candidates) > $bats + $shaft + $mumpus) $hashDanger |= 1;

    foreach($candidates as $roomID => $_) $rooms[$roomID] &= $hashDanger;

    if($bats) {
        $potential = 0;
        $missing = $bats;

        foreach($candidates as $roomID => $_) {
            if($rooms[$roomID] == 2) --$missing;
            elseif($rooms[$roomID] & 2) ++$potential;
        }

        error_log("$bats bats -- missing $missing & potential $potential");

        if($missing == 0 || $potential == $missing) {
            if($missing == 0) {
                error_log("We have found all the bats");

                foreach($candidates as $roomID => $_) {
                    if($rooms[$roomID] != 2) $rooms[$roomID] &= 13;
                }
            } else {
                error_log("We have found all the possible bats");

                foreach($candidates as $roomID => $_) {
                    if($rooms[$roomID] & 2) $rooms[$roomID] = 2;
                    else $rooms[$roomID] &= 13;
                }
            }

            $infos[$infoIndex][1][0] = 0;
        }
    }
    if($shaft) {
        $potential = 0;
        $missing = $shaft;

        foreach($candidates as $roomID => $_) {
            if($rooms[$roomID] == 4) --$missing;
            elseif($rooms[$roomID] & 4) ++$potential;
        }

        error_log("$shaft shaft -- missing $missing & potential $potential");

        //We have found them all
        if($missing == 0 || $potential == $missing) {
            if($missing == 0) {
                error_log("We have found all the shafts");

                foreach($candidates as $roomID => $_) {
                    if($rooms[$roomID] != 4) $rooms[$roomID] &= 11;
                }
            } else {
                error_log("We have found all the possible shafts");

                foreach($candidates as $roomID => $_) {
                    if($rooms[$roomID] & 4) $rooms[$roomID] = 4;
                    else $rooms[$roomID] &= 11;
                }
            }

            $infos[$infoIndex][1][1] = 0;
        }

    }
    if($mumpus) {
        $count = 0;

        foreach($candidates as $roomID => $_)
            if($rooms[$roomID] & 8) ++$count;

        error_log("$mumpus mumpus for $count rooms");

        if($mumpus > $count) {
            error_log(var_export($rooms, 1));
            die();
        }

        if($count == $mumpus) {
            foreach($candidates as $roomID => $_) {
                if($rooms[$roomID] & 8) {
                    $rooms[$roomID] = 8;
                    $mumpusPosition = $roomID;
                }
                else $rooms[$roomID] &= 7;
            }

            $infos[$infoIndex][1][2] = 0;
        }
    }
}

fscanf(STDIN, "%d %d %d", $roomCount, $batCount, $shaftCount);

$rooms = array_fill(0, $roomCount, 15);
$infos = [];
$infosRemoved = [];
$visited = [];
$links = [];
$actions = [];
$mumpusPosition = null;
$batTargetPosition = null;

// game loop
while (TRUE) {
    fscanf(STDIN, "%d", $currentRoom);
    fscanf(STDIN, "%d %d %d", $roomA, $roomB, $roomC);
    fscanf(STDIN, "%d %d %d", $bats, $shaft, $mumpus);

    $rooms[$currentRoom] = 1;
    $visited[$currentRoom] = true;

    error_log(var_export($currentRoom, true));
    error_log(var_export("$roomA, $roomB, $roomC", true));
    error_log(var_export("$bats, $shaft, $mumpus", true));

    $links[$currentRoom][$roomA] =  $links[$roomA][$currentRoom] = true;
    $links[$currentRoom][$roomB] =  $links[$roomB][$currentRoom] = true;
    $links[$currentRoom][$roomC] =  $links[$roomC][$currentRoom] = true;

    if($bats + $shaft + $mumpus == 0) {
        foreach(['A','B','C'] as $letter) {
            if($rooms[${"room" . $letter}] != 1) $rooms[${"room" . $letter}] = 1;
        }
    } elseif(!isset($infosRemoved[$currentRoom]) && !isset($infos[$currentRoom])) 
        $infos[$currentRoom] = [[$roomA => true, $roomB => true, $roomC => true], [$bats, $shaft, $mumpus]];

    do {
        $before = $infos;

        foreach($infos as $index => $_) {
            updateRooms($index);
        }
    } while($before != $infos);


    error_log(var_export($rooms, true));

    if(!$actions) {
        if($mumpusPosition !== null) {
            $path = array_values(goToShootingPosition($currentRoom));

            error_log(var_export($path, 1));

            $actions[] = "SHOOT $mumpusPosition";

            for($i = count($path) - 1; $i > 0; --$i) $actions[] = "MOVE " . $path[$i];
        } else {
            $path = findNextRoomToExplore($currentRoom);

            if($path === null) {
                $path = findNextRoomToExplore($currentRoom, true);

                $batTargetPosition = array_key_last($path);
            }

            $path = array_values($path);

            error_log(var_export($path, 1));

            for($i = count($path) - 1; $i > 0; --$i) $actions[] = "MOVE " . $path[$i];
        }
    }

    $action = array_pop($actions);

    if($action == "MOVE $batTargetPosition") {
        $rooms[$batTargetPosition] = 1;
    }

    echo $action . PHP_EOL;
}
