<?php

function findClosestBomb(int $index): array {
    global $moves, $bombs;

    if(count($bombs) == 0) return [];

    $toCheck = [[$index, []]];

    while($toCheck) {
        $newCheck = [];

        foreach($toCheck as [$index, $list]) {
            $list[$index] = $index;

            if(isset($bombs[$index])) return array_reverse(array_slice($list, 1));

            foreach($moves[$index] as $neighbor) {
                if(!isset($list[$neighbor])) {
                    $newCheck[] = [$neighbor, $list];
                }
            }
        }

        $toCheck = $newCheck;
    }

    return [];
}

// $rows: number of rows in the grid
fscanf(STDIN, "%d", $height);
// $columns: number of columns in the grid
fscanf(STDIN, "%d", $width);
for ($y = 0, $index = 0; $y < $height; ++$y) {
    for ($x = 0; $x < $width; ++$x, ++$index) {
        fscanf(STDIN, "%d %d %d %d %d", $west, $east, $north, $south, $hasBomb);

        if(!$west) $moves[$index][] = $index - 1;
        if(!$east) $moves[$index][] = $index + 1;
        if(!$north) $moves[$index][] = $index - $width;
        if(!$south) $moves[$index][] = $index + $width;
        if($hasBomb) $bombs[$index] = 1;

        // error_log("$x $y $west $east $north $south $hasBomb");
    }
}

error_log(var_export($bombs, 1));

$listMoves = [];

// game loop
while (TRUE) {
    // $robotX: the robot's current X coordinate
    // $robotY: the robot's current Y coordinate
    // $robotA: the robot's orientation
    // $robotBombs: the number of bombs the robot has
    fscanf(STDIN, "%d %d %d %d", $robotX, $robotY, $robotA, $robotBombs);

    error_log("$robotX, $robotY, $robotA, $robotBombs");

    $index = $robotY * $width + $robotX;

    error_log(count($moves[$index]));

    if($robotBombs && count($moves[$index]) >= 3) {
        error_log('dropping bomb');
        echo "DROP" . PHP_EOL;
        continue;
    }

    if(!$listMoves) {
        $listMoves = findClosestBomb($index);
        unset($bombs[reset($listMoves)]);
    }

    error_log(var_export($listMoves, 1));

    $next = end($listMoves);

    //Need to move right
    if($next == $index + 1) {
        switch($robotA) {
            case 0: echo "MOVE_BACKWARD\n"; array_pop($listMoves); break;
            case 1: echo "MOVE_FORWARD\n"; array_pop($listMoves); break;
            case 2: echo "TURN_RIGHT\n"; break;
            case 3: echo "TURN_LEFT\n"; break;
        }
    } //Need to move down
    elseif($next == $index + $width) {
        switch($robotA) {
            case 0: echo "TURN_LEFT\n"; break;
            case 1: echo "TURN_RIGHT\n"; break;
            case 2: echo "MOVE_BACKWARD\n"; array_pop($listMoves); break;
            case 3: echo "MOVE_FORWARD\n"; array_pop($listMoves); break;
        }
    } //Need to move left
    elseif($next == $index - 1) {
        switch($robotA) {
            case 0: echo "MOVE_FORWARD\n"; array_pop($listMoves); break;
            case 1: echo "MOVE_BACKWARD\n"; array_pop($listMoves); break;
            case 2: echo "TURN_LEFT\n"; break;
            case 3: echo "TURN_RIGHT\n"; break;
        }
    } //Need to move up
    elseif($next == $index - $width) {
        switch($robotA) {
            case 0: echo "TURN_RIGHT\n"; break;
            case 1: echo "TURN_LEFT\n"; break;
            case 2: echo "MOVE_FORWARD\n"; array_pop($listMoves); break;
            case 3: echo "MOVE_BACKWARD\n"; array_pop($listMoves); break;
        }
    }
}
