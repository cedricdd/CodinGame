<?php

//Find a path to the next room we want to explore
function findNextRoomToExplore(int $position, bool $allowBats = false): ?array {
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

//We found the location of the mumpus, go into position to shot it
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

function checkRoomsInfo($infoIndex) {
    global $rooms, $infos, $infosRemoved, $mumpusPosition;

    [&$neighbors, [$bats, $shaft, $mumpus]] = $infos[$infoIndex];

    //We have nothing left to find
    if($bats + $shaft + $mumpus == 0) {
        unset($infos[$infoIndex]);

        $infosRemoved[$infoIndex] = true;

        return;
    }

    //We can remove the rooms we know are empty
    foreach($neighbors as $roomID => $_) if($rooms[$roomID] == 1) unset($neighbors[$roomID]);

    $hashDanger = ($bats ? 2 : 0) | ($shaft ? 4 : 0) | ($mumpus ? 8 : 0);

    if($bats + $shaft + $mumpus < count($neighbors)) $hashDanger |= 1;

    foreach($neighbors as $roomID => $_) $rooms[$roomID] &= $hashDanger;

    //There's at least one bat
    if($bats) {
        $potential = [];

        foreach($neighbors as $roomID => $_) if($rooms[$roomID] & 2) $potential[] = $roomID;

        if(count($potential) == 1) {
            $roomID = reset($potential);
            $rooms[$roomID] = 2;
            unset($infos[$infoIndex][0][$roomID]);

            $infos[$infoIndex][1][0] = 0; //We are done with bats
        }
    }
    //There's at least one shaft
    if($shaft) {
        $potential = [];

        foreach($neighbors as $roomID => $_) if($rooms[$roomID] & 4) $potential[] = $roomID;

        if(count($potential) == 1) {
            $roomID = reset($potential);
            $rooms[$roomID] = 4;
            unset($infos[$infoIndex][0][$roomID]);


            $infos[$infoIndex][1][1] = 0; //We are done with shafts
        }

    }
    //There's one mumpus
    if($mumpus) {
        $potential = [];

        foreach($neighbors as $roomID => $_) if($rooms[$roomID] & 8) $potential[] = $roomID;

        if(count($potential) == 1) {
            $roomID = reset($potential);
            $rooms[$roomID] = 8;
            $mumpusPosition = $roomID;
            unset($infos[$infoIndex][0][$roomID]);


            $infos[$infoIndex][1][2] = 0; //We are done with mumpus
        }
    }
}

fscanf(STDIN, "%d %d %d", $roomCount, $batCount, $shaftCount);

$hash = 8 | 1; //Everything can be empty or a mumpus

if($batCount) {
    $hash |= 2; //There are some bats
    $foundBatGroups = false;
} else $foundBatGroups = true;

if($shaftCount) {
    $hash |= 4; //There are some shafts
    $foundShaftGroups = false;
} else $foundShaftGroups = true;

$rooms = array_fill(0, $roomCount, $hash);
$infos = [];
$infosRemoved = [];
$visited = [];
$links = [];
$actions = [];
$shaftsInfo = [];
$batsInfo = [];
$mumpusPosition = null;

// game loop
while (TRUE) {
    fscanf(STDIN, "%d", $currentRoom);
    fscanf(STDIN, "%d %d %d", $roomA, $roomB, $roomC);
    fscanf(STDIN, "%d %d %d", $bats, $shaft, $mumpus);

    $rooms[$currentRoom] = 1;
    $visited[$currentRoom] = true;

    //There's only one mumpus, any rooms not a direct neighbor of our current location can't contain the mumpus
    if($mumpus != 0) 
        foreach($rooms as $roomID => $_)
            if($roomID != $roomA && $roomID != $roomB && $roomID != $roomC) $rooms[$roomID] &= 7;
    
    $links[$currentRoom][$roomA] =  $links[$roomA][$currentRoom] = true;
    $links[$currentRoom][$roomB] =  $links[$roomB][$currentRoom] = true;
    $links[$currentRoom][$roomC] =  $links[$roomC][$currentRoom] = true;

    if($shaft && !isset($shaftsInfo[$currentRoom])) $shaftsInfo[$currentRoom] = [$shaft, [$roomA, $roomB, $roomC]];
    if($bats && !isset($batsInfo[$currentRoom])) $batsInfo[$currentRoom] = [$bats, [$roomA, $roomB, $roomC]];

    //Nothing in any of the three rooms
    if($bats + $shaft + $mumpus == 0) {
        foreach(['A','B','C'] as $letter) {
            if($rooms[${"room" . $letter}] != 1) $rooms[${"room" . $letter}] = 1;
        }
    } elseif(!isset($infosRemoved[$currentRoom]) && !isset($infos[$currentRoom])) {
        $infos[$currentRoom] = [[$roomA => true, $roomB => true, $roomC => true], [$bats, $shaft, $mumpus]];
    }

    //Check if with the new info we can deduce what's in some rooms
    do {
        $before = $infos;

        foreach($infos as $index => $_) checkRoomsInfo($index);
    } while($before != $infos);

    //We are not sure where all the shafts are yet
    if($foundShaftGroups === false) {
        foreach($shaftsInfo as $index1 => [, $list]) {
            //Check if it's still possible for a shaft to be there
            foreach($list as $index2 => $roomID) {
                if(($rooms[$roomID] & 4) == 0) unset($shaftsInfo[$index1][1][$index2]);
            }
        }

        $shaftsInfoTemp = array_values($shaftsInfo);
        $shaftIDs = [];
        $groups = [];

        //We group the possible locations of shafts
        for($i = count($shaftsInfoTemp) - 1; $i >= 0; --$i) {
            foreach($shaftsInfoTemp[$i][1] as $roomID) $shaftIDs[$roomID] = true;

            foreach($groups as $groupID => $possibleRooms) {
                $intersect = array_intersect($shaftsInfoTemp[$i][1], $possibleRooms);

                if($intersect == false) continue;

                $groups[$groupID] = $intersect;

                continue 2;
            }

            $groups[] = $shaftsInfoTemp[$i][1];
        }

        //We know all the possible locations of shafts
        if(count($groups) == $shaftCount) {
            foreach($rooms as $roomID => $hash) {
                //A shaft can't be there
                if(!isset($shaftIDs[$roomID]) && $rooms[$roomID] & 4) $rooms[$roomID] &= 11;
            }

            $foundShaftGroups = true;
        }
    }

    //We are not sure where all the bats are yet
    if($foundBatGroups === false) {
        foreach($batsInfo as $index1 => [, $list]) {
            foreach($list as $index2 => $roomID) {
                if(($rooms[$roomID] & 2) == 0) unset($batsInfo[$index1][1][$index2]);
            }
        }

        $batsInfoTemp = array_values($batsInfo);
        $batIDs = [];
        $groups = [];

        //We group the possible locations of cats
        for($i = count($batsInfoTemp) - 1; $i >= 0; --$i) {
            foreach($batsInfoTemp[$i][1] as $roomID) $batIDs[$roomID] = true;

            foreach($groups as $groupID => $possibleRooms) {
                $intersect = array_intersect($batsInfoTemp[$i][1], $possibleRooms);

                if($intersect == false) continue;

                $groups[$groupID] = $intersect;

                continue 2;
            }

            $groups[] = $batsInfoTemp[$i][1];
        }

        //We know all the possible locations of bats
        if(count($groups) == $batCount) {
            foreach($rooms as $roomID => $hash) {
                //A bat can't be there
                if(!isset($batIDs[$roomID]) && $rooms[$roomID] & 2) $rooms[$roomID] &= 13;
            }

            $foundBatGroups = true;
        }
    }

    $shaftFound = 0;

    foreach($rooms as $roomID => $hash) if($hash == 4) ++$shaftFound; //We are sure this room contains a shaft

    if($shaftFound == $shaftCount)
        foreach($rooms as $roomID => $hash)
            if($hash != 4 && ($hash & 4)) $rooms[$roomID] &= 11; //We are sure there's no shaft there


    if(!$actions) {
        //Go kill the mumpus
        if($mumpusPosition !== null) {
            $path = goToShootingPosition($currentRoom);

            $actions[] = "SHOOT $mumpusPosition";
        } else {
            $path = findNextRoomToExplore($currentRoom); //Find the next safe room to explore

            if($path === null) { //We have no safe room to explore, go to a bat
                $path = findNextRoomToExplore($currentRoom, true);

                $rooms[array_key_last($path)] = 1;
                $batCount--;
            }
        }

        $path = array_values($path);

        for($i = count($path) - 1; $i > 0; --$i) $actions[] = "MOVE " . $path[$i];
    }

    echo array_pop($actions) . PHP_EOL;
}
