<?php

const MOVES = [[0, 1], [0, -1], [1, 0], [-1, 0]];

//Check if we can remove some stone from the other player
function checkRemoval(int $x, int $y, string $player): bool {
    global $map, $S;

    $list = [];
    $removed = 0;
    $toCheck = [[$x, $y]];

    while(count($toCheck)) {
        [$x, $y] = array_pop($toCheck);

        if($x < 0 || $x == $S || $y < 0 || $y == $S) continue; //Out of the map
        if($map[$y][$x] == ".") return 0; //Other player group isn't surrounded
        if($map[$y][$x] == $player) continue; //Blocked by of our stone
        if(isset($list[$y][$x])) continue; //Position already checked
        else $list[$y][$x] = 1;
        
        foreach(MOVES as [$mx, $my]) $toCheck[] = [$x + $mx, $y + $my];
    }

    if(count($list) == 0) return false;

    //Removing the stones from the other player
    foreach($list as $y => $line) {
        foreach($line as $x => $filler) {
            $map[$y][$x] = ".";
            ++$removed;
        }
    }

    return true;
}

//Check if we just did a suicidal move
function checkSuicidal(int $x, int $y, string $player): bool {
    global $map, $S;

    $list = [];
    $toCheck = [[$x, $y]];

    while(count($toCheck)) {
        [$x, $y] = array_pop($toCheck);

        if($x < 0 || $x == $S || $y < 0 || $y == $S) continue; //Out of the map
        if($map[$y][$x] == ".") return false; //It's a safe placement
        if($map[$y][$x] != $player) continue; //Blocked by a stone of the other player
        if(isset($list[$y][$x])) continue; //Position already checked
        else $list[$y][$x] = 1;
        
        foreach(MOVES as [$mx, $my]) $toCheck[] = [$x + $mx, $y + $my];
    }

    return true;
}

fscanf(STDIN, "%d", $S);
fscanf(STDIN, "%d", $M);
for ($i = 0; $i < $S; $i++) {
    $map[] = stream_get_line(STDIN, $S + 1, "\n");
}

for ($i = 0; $i < $M; $i++) {
    [$player, $y, $x] = explode(" ", stream_get_line(STDIN, 7 + 1, "\n"));

    if($map[$y][$x] !== ".") die("NOT_VALID");

    $map[$y][$x] = $player;

    $removed = false;
    foreach(MOVES as [$mx, $my]) {
        $removed |= checkRemoval($x + $mx, $y + $my, $player);
    }

    //We haven't removed any stone from the other player, make sure it's not suicidal move
    if($removed == false && checkSuicidal($x, $y, $player)) die("NOT_VALID");

    $state = implode($map);
    if(isset($states[$state]) && $states[$state] == $i - 2) die("NOT_VALID"); //KO-rule
    else $states[$state] = $i;
}

echo implode("\n", $map) . PHP_EOL;
?>
