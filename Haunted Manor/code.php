<?php

function getPosibilities(array $positions, int $count): array {
    global $vampireCount, $zombieCount, $ghostCount;

    $posibilities = [[$vampireCount, $zombieCount, $ghostCount, $count, []]];

    // error_log("we start with $vampireCount, $zombieCount, $ghostCount, $count");

    foreach($positions as [$position, $mirror]) {
        $newPosibilites = [];
        
        foreach($posibilities as [$vp, $zC, $gC, $count, $monsters]) {
            if(isset($monsters[$position])) exit("case not handled yet");

            //We place a Vampire
            if($vp && ($mirror || $count)) {
                $newPosibilites[] = [$vp - 1, $zC, $gC, $count - (!$mirror ? 1 : 0), $monsters + [$position => 'V']];
            }

            //We place a Zombie
            if($zC && $count) {
                $newPosibilites[] = [$vp, $zC  - 1, $gC, $count - 1, $monsters + [$position => 'Z']];
            }

            //We place a Ghost
            if($gC && (!$mirror || $count)) {
                $newPosibilites[] = [$vp, $zC, $gC  - 1, $count - ($mirror ? 1 : 0), $monsters + [$position => 'G']];
            }
        }

        $posibilities = $newPosibilites;
        unset($newPosibilites);
    }

    // error_log(var_export($posibilities, 1));

    foreach($posibilities as $i => [, , , $count, $monsters]) {
        if($count != 0) unset($posibilities[$i]);
        else $posibilities[$i] = $monsters;
    }

    if(count($posibilities) == 1) {
        error_log(var_export($positions, 1));
        error_log(var_export($posibilities, 1));
    }

    return $posibilities;
}

function getPositions(int $x, int $y, string $d): array {
    global $n, $manor;

    $mirror = 0;
    $positions = [];

    while($x >= 0 && $x < $n && $y >= 0 && $y < $n) {
        // error_log("at $x $y - $d - " . $manor[$y][$x]);
        if($manor[$y][$x] == '.') {
            $index = $y * $n + $x;

            $positions[] = [$index, $mirror];
        } elseif($manor[$y][$x] == '/') {
            switch($d) {
                case 'U': $d = 'R'; break;
                case 'D': $d = 'L'; break;
                case 'L': $d = 'D'; break;
                case 'R': $d = 'U'; break;
            }

            $mirror = 1;
        } elseif($manor[$y][$x] == '\\') {
            switch($d) {
                case 'U': $d = 'L'; break;
                case 'D': $d = 'R'; break;
                case 'L': $d = 'U'; break;
                case 'R': $d = 'D'; break;
            }

            $mirror = 1;
        }

        switch($d) {
            case 'U': --$y; break;
            case 'D': ++$y; break;
            case 'L': --$x; break;
            case 'R': ++$x; break;
        }

        // error_log("end $x $y - $d - " . $manor[$y][$x]);
    }

    return $positions;
}

fscanf(STDIN, "%d %d %d", $vampireCount, $zombieCount, $ghostCount);

fscanf(STDIN, "%d", $n);

$canSeeFromTop = array_map('intval', explode(" ", fgets(STDIN)));
$canSeeFromBottom = array_map('intval', explode(" ", fgets(STDIN)));
$canSeeFromLeft = array_map('intval', explode(" ", fgets(STDIN)));
$canSeeFromRight = array_map('intval', explode(" ", fgets(STDIN)));

for ($i = 0; $i < $n; $i++) {
    $manor[] = trim(fgets(STDIN));
}

error_log(var_export($manor, 1));

foreach($canSeeFromTop as $i => $value) {
    $positions = getPositions($i, 0, 'D');

    // error_log(var_export($positions, 1));

    if($positions) {
        $posibilities = getPosibilities($positions, $value);
    }
}

echo implode(PHP_EOL, $manor);
