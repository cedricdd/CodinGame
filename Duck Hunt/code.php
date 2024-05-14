<?php

fscanf(STDIN, "%d", $w);
fscanf(STDIN, "%d", $h);

for ($y = 0; $y < $h; ++$y) {
    foreach(str_split(trim(fgets(STDIN))) as $x => $c) {
        if(ctype_digit($c)) {
            $positions[$c] = [$x, $y];
        }
    }
}

for ($y = 0; $y < $h; ++$y) {
    foreach(str_split(trim(fgets(STDIN))) as $x => $c) {
        if(ctype_digit($c)) {
            //Get movement of the bird
            $vx = $x - $positions[$c][0];
            $vy = $y - $positions[$c][1];
        
            //How many turns do we have before we can't shoot that bird anymore
            $turns = INF;
        
            if($vx < 0) $turns = min($turns, intdiv($x, abs($vx)));
            elseif($vx > 0) $turns = min($turns, intdiv($w - $x - 1, $vx));
        
            if($vy < 0) $turns = min($turns, intdiv($y, abs($vy)));
            elseif($vy > 0) $turns = min($turns, intdiv($h - $y - 1, $vy));
        
            $birds[$c] = [$turns, $vx, $vy, $x, $y];
        }
    }
}

//Sort by the number of turn we have to shoot it
uasort($birds, function($a, $b) {
    return $a[0] <=> $b[0];
});

$currentTurn = 1;

foreach($birds as $id => [$turn, $vx, $vy, $x, $y]) {
    if($turn < $currentTurn) continue; //It's too late to shoot that bird

    echo $id . " " . ($x + ($currentTurn * $vx)) . " " . ($y + ($currentTurn * $vy)) . PHP_EOL;

    ++$currentTurn;
}
