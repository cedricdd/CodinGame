<?php

function getPosibilities(int $vampireCount, int $zombieCount, int $ghostCount, array $positions, int $count): array {
    $posibilities = [[$vampireCount, $zombieCount, $ghostCount, $count, []]];

    // error_log("we start with $vampireCount, $zombieCount, $ghostCount, $count");

    foreach($positions as [$position, $mirror]) {
        $newPosibilites = [];
        
        foreach($posibilities as [$vp, $zC, $gC, $count, $monsters]) {
            if(isset($monsters[$position])) {
                if($monsters[$position] == 'G' && ($mirror || $count)) $newPosibilites[] = [$vp, $zC, $gC, $count - ($mirror ? 1 : 0), $monsters];
                elseif($monsters[$position] == 'Z' && $count) $newPosibilites[] = [$vp, $zC, $gC, $count - 1, $monsters];
                elseif($monsters[$position] == 'V' && (!$mirror || $count)) $newPosibilites[] = [$vp, $zC, $gC, $count - (!$mirror ? 1 : 0), $monsters];
            } else {
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
        }

        $posibilities = $newPosibilites;
        unset($newPosibilites);
    }

    // error_log(var_export($posibilities, 1));

    foreach($posibilities as $i => [, , , $count, $monsters]) {
        if($count != 0) unset($posibilities[$i]);
    }

    return $posibilities;
}

function getPosibilities2(array $positions, int $count): array {
    global $vampireCount, $zombieCount, $ghostCount, $hash;

    $posibilities[$hash] = [$vampireCount, $zombieCount, $ghostCount, $count, []];

    // error_log("we start with $vampireCount, $zombieCount, $ghostCount, $count");

    foreach($positions as [$position, $mirror]) {
        $newPosibilites = [];
        
        foreach($posibilities as $hash => [$vp, $zC, $gC, $count, $monsters]) {
            if(isset($monsters[$position])) {
                if($monsters[$position] == 'G' && ($mirror || $count)) $newPosibilites[$hash] = [$vp, $zC, $gC, $count - ($mirror ? 1 : 0), $monsters];
                elseif($monsters[$position] == 'Z' && $count) $newPosibilites[$hash] = [$vp, $zC, $gC, $count - 1, $monsters];
                elseif($monsters[$position] == 'V' && (!$mirror || $count)) $newPosibilites[$hash] = [$vp, $zC, $gC, $count - (!$mirror ? 1 : 0), $monsters];
            } else {
                //We place a Vampire
                if($vp && ($mirror || $count)) {
                    $hash[$position] = 'V';
                    $newPosibilites[$hash] = [$vp - 1, $zC, $gC, $count - (!$mirror ? 1 : 0), $monsters + [$position => 'V']];
                }

                //We place a Zombie
                if($zC && $count) {
                    $hash[$position] = 'Z';
                    $newPosibilites[$hash] = [$vp, $zC  - 1, $gC, $count - 1, $monsters + [$position => 'Z']];
                }

                //We place a Ghost
                if($gC && (!$mirror || $count)) {
                    $hash[$position] = 'G';
                    $newPosibilites[$hash] = [$vp, $zC, $gC  - 1, $count - ($mirror ? 1 : 0), $monsters + [$position => 'G']];
                }
            }
        }

        $posibilities = $newPosibilites;
        unset($newPosibilites);
    }

    // error_log(var_export($posibilities, 1));

    foreach($posibilities as $i => [, , , $count, $monsters]) {
        if($count != 0) unset($posibilities[$i]);
    }

    return $posibilities;
}

function getPositions(int $vampireCount, int $zombieCount, int $ghostCount, array $manor, int $index): array {
    global $n, $clues;

    [$x, $y, $d, ] = $clues[$index];
    $mirror = 0;
    $seen = 0;
    $positions = [];

    // error_log("starting at $x $y - $d");

    while($x >= 0 && $x < $n && $y >= 0 && $y < $n) {
        $c = $manor[$y][$x];

        // error_log("at $x $y - $d - " . $manor[$y][$x]);
        if($c == '.') {
            $index = $y * $n + $x;

            $positions[] = [$index, $mirror];
        } elseif($c == '/') {
            switch($d) {
                case 'U': $d = 'L'; break;
                case 'D': $d = 'R'; break;
                case 'L': $d = 'U'; break;
                case 'R': $d = 'D'; break;
            }

            $mirror = 1;
        } elseif($c == '\\') {
            switch($d) {
                case 'U': $d = 'R'; break;
                case 'D': $d = 'L'; break;
                case 'L': $d = 'D'; break;
                case 'R': $d = 'U'; break;
            }

            $mirror = 1;
        }
        elseif($c == 'V' && !$mirror) ++$seen;
        elseif($c == 'G' && $mirror) ++$seen;
        elseif($c == 'Z') ++$seen;

        switch($d) {
            case 'U': --$y; break;
            case 'D': ++$y; break;
            case 'L': ++$x; break;
            case 'R': --$x; break;
        }

        // error_log("end $x $y - $d - " . $manor[$y][$x]);
    }

    return [$positions, $seen];
}

function getPositions2(int $x, int $y, string $d): array {
    global $n, $manor;

    $mirror = 0;
    $positions = [];

    // error_log("starting at $x $y - $d");

    while($x >= 0 && $x < $n && $y >= 0 && $y < $n) {
        $c = $manor[$y][$x];

        // error_log("at $x $y - $d - " . $manor[$y][$x]);
        if($c == '.') {
            $index = $y * $n + $x;

            $positions[] = [$index, $mirror];
        } elseif($c == '/') {
            switch($d) {
                case 'U': $d = 'L'; break;
                case 'D': $d = 'R'; break;
                case 'L': $d = 'U'; break;
                case 'R': $d = 'D'; break;
            }

            $mirror = 1;
        } elseif($c == '\\') {
            switch($d) {
                case 'U': $d = 'R'; break;
                case 'D': $d = 'L'; break;
                case 'L': $d = 'D'; break;
                case 'R': $d = 'U'; break;
            }

            $mirror = 1;
        }

        switch($d) {
            case 'U': --$y; break;
            case 'D': ++$y; break;
            case 'L': ++$x; break;
            case 'R': --$x; break;
        }

        // error_log("end $x $y - $d - " . $manor[$y][$x]);
    }

    return [$positions, $x, $y];
}

function solve(int $vampireCount, int $zombieCount, int $ghostCount, array $manor, int $index) {
    global $n, $clues, $start;
    static $reverse = [];

    if(isset($reverse[$index])) solve($vampireCount, $zombieCount, $ghostCount, $manor, $index + 1);

    if($index == $n * 4) {
        if($vampireCount || $zombieCount || $ghostCount) {
            foreach($manor as $y => $line) {
                if(($x = strpos($line, '.')) !== false) {
                    $manor[$y][$x] = $vampireCount ? 'V' : ($zombieCount ? 'Z' : ($ghostCount ? 'G' : ''));
                    break;
                }
            }
        }

        echo implode(PHP_EOL, $manor) . PHP_EOL;
        error_log(microtime(1) - $start);
        exit();
    }

    $count = $clues[$index][3];

    // error_log("Working on $index ($count) with: $vampireCount - $zombieCount - $ghostCount");
    // error_log(var_export($manor, 1));

    [$positions, $seen] = getPositions($vampireCount, $zombieCount, $ghostCount, $manor, $index);

    $countPositions = count($positions);

    // Impossible solution
    if($seen > $count) {
        // error_log("already seeing too much");
        return;
    }
    if($seen + $countPositions < $count) {
        // error_log("can't seen enough anymore");
        return;
    }

    // error_log("we have $countPositions positions & we already see: " . $seen);

    if($countPositions == 0) {
        solve($vampireCount, $zombieCount, $ghostCount, $manor, $index + 1);
        return;
    }

    $posibilities = getPosibilities($vampireCount, $zombieCount, $ghostCount, $positions, $count - $seen);

    foreach($posibilities as [$vc, $zc, $gc, , $monsters]) {
        // error_log("we need to test:");
        // error_log(var_export($monsters, 1));

        $manorUpdated = $manor;

        foreach($monsters as $i => $monster) {
            $manorUpdated[intdiv($i, $n)][$i % $n] = $monster;
        }

        solve($vc, $zc, $gc, $manorUpdated, $index + 1);
    }
}

function generateGroups(): array {
    global $n, $clues;

    $groups = [];

    foreach($clues as $id => $filler) {
        if(!isset($clues[$id])) continue; 

        [$x, $y, $d, $count] = $clues[$id];
        [$positions, $x, $y] = getPositions2($x, $y, $d);

        error_log("Clue ID: $id - $x $y");
        // error_log(var_export($positions, 1));

        $posibilities1 = getPosibilities2($positions, $count);

        error_log(var_export(count($posibilities1), 1));
        // error_log(var_export($posibilities1, 1));

        if($x == -1) $reverseID = 2 * $n + $y;
        elseif($x == $n) $reverseID = 3 * $n + $y;
        elseif($y == -1) $reverseID = $x;
        elseif($y == $n) $reverseID = $n + $y;

        [$x, $y, $d, $count] = $clues[$reverseID];
        [$positions, $x, $y] = getPositions2($x, $y, $d);

        error_log("Clue reverseID: $reverseID - $x $y");
        // error_log(var_export($positions, 1));

        $posibilities2 = getPosibilities2($positions, $count);

        error_log(var_export(count($posibilities2), 1));
        // error_log(var_export($posibilities2, 1));

        $both = array_intersect_key($posibilities1, $posibilities2);

        error_log(var_export(count($both), 1));
        error_log(var_export($both, 1));

        exit();
    }

    return $groups;
}

fscanf(STDIN, "%d %d %d", $vampireCount, $zombieCount, $ghostCount);

fscanf(STDIN, "%d", $n);

$start = microtime(1);

foreach(explode(" ", fgets(STDIN)) as $i => $value) {
    $clues[] = [$i, 0, 'D', intval($value)];
}
foreach(explode(" ", fgets(STDIN)) as $i => $value) {
    $clues[] = [$i, $n - 1, 'U', intval($value)];
}
foreach(explode(" ", fgets(STDIN)) as $i => $value) {
    $clues[] = [0, $i, 'L', intval($value)];
}
foreach(explode(" ", fgets(STDIN)) as $i => $value) {
    $clues[] = [$n - 1, $i, 'R', intval($value)];
}

for ($i = 0; $i < $n; $i++) {
    $manor[] = trim(fgets(STDIN));
}

$hash = implode("", $manor);

error_log(var_export($manor, 1));

$groups = generateGroups();

solve($vampireCount, $zombieCount, $ghostCount, $manor, 0);
