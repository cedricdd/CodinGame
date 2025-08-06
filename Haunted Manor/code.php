<?php

function getPosibilities(int $vampireCount, int $zombieCount, int $ghostCount, array $positions, int $count, string $manor): array {
    $posibilities = [$manor => [$vampireCount, $zombieCount, $ghostCount, $count, []]];

    foreach($positions as [$position, $mirror]) {
        $newPosibilites = [];
        
        foreach($posibilities as $hash => [$vp, $zC, $gC, $count, $monsters]) {
            //We have already placed a monster on this position
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

    //Remove everything that doesn't reach the desired count
    foreach($posibilities as $i => [, , , $count, $monsters]) {
        if($count != 0) unset($posibilities[$i]);
    }

    return $posibilities;
}

function getPositions(int $x, int $y, string $d, string $manor): array {
    global $n;

    $mirror = 0;
    $toSet = [];
    $toCheck = [];

    //Until we leave the manor
    while($x >= 0 && $x < $n && $y >= 0 && $y < $n) {
        $index = $y * $n + $x;
        $c = $manor[$index];

        if($c == '.') $toSet[] = [$index, $mirror]; //Position where we need to set a monster
        elseif($c == 'X') $toCheck[] = [$index, $mirror]; //Position where we already have set a monster
        elseif($c == '/') {
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

        //Move to the next position
        switch($d) {
            case 'U': --$y; break;
            case 'D': ++$y; break;
            case 'L': ++$x; break;
            case 'R': --$x; break;
        }
    }

    return [$toSet, $toCheck, $x, $y];
}

function getCount(string $manor, array $positions): int {
    $count = 0;

    foreach($positions as [$index, $mirror]) {
        switch($manor[$index]) {
            case 'V': $count += !$mirror; break;
            case 'Z': $count++; break;
            case 'G': $count += $mirror; break;
        }
    }

    return $count;
}

function solve(int $vampireCount, int $zombieCount, int $ghostCount, string $manor, int $index) {
    global $n, $groups, $groupsCount, $start;

    //We have found a solution
    if($index == $groupsCount) {
        //There is a position that isn't reached by any of the clues, set it to the last monster we have
        if(($i = strpos($manor, '.')) !== false) {
            $manor[$i] = $vampireCount ? 'V' : ($zombieCount ? 'Z' : ($ghostCount ? 'G' : ''));
        }

        echo implode(PHP_EOL, str_split($manor, $n)) . PHP_EOL;
        error_log(microtime(1) - $start);
        exit();
    }

    [[$toSet1, $toCheck1, $count1], [$toSet2, $toCheck2, $count2]] = $groups[$index];

    $left = count($toSet1);
    $current1 = getCount($manor, $toCheck1);
    $current2 = getCount($manor, $toCheck2);

    //Invalid solution, we see more monster than we shound
    if($current1 > $count1 || $current2 > $count2) return;
    
    //Invalid solution, we can't see enough monsters
    if($current1 + $left < $count1 || $current2 + $left < $count2) return;

    //We have no monster to place this turn
    if($left == 0) {
        solve($vampireCount, $zombieCount, $ghostCount, $manor, $index + 1);
        return;
    }

    $posibilities1 = getPosibilities($vampireCount, $zombieCount, $ghostCount, $toSet1, $count1 - $current1, $manor);
    $posibilities2 = getPosibilities($vampireCount, $zombieCount, $ghostCount, $toSet2, $count2 - $current2, $manor);
    $posibilities = array_intersect_key($posibilities1, $posibilities2); //We only want solutions that satisfy both directions.

    foreach($posibilities as [$vc, $zc, $gc, , $monsters]) {
        foreach($monsters as $i => $monster) $manor[$i] = $monster;

        solve($vc, $zc, $gc, $manor, $index + 1);
    }
}

function checkClues(string $manor, array $clues): array {
    global $n;

    $groups = [];

    foreach($clues as $id => $filler) {
        if(!isset($clues[$id])) continue; 

        [$x, $y, $d, $count1] = $clues[$id];
        [$toSet1, $toCheck1, $x, $y] = getPositions($x, $y, $d, $manor);

        //Every clues work in pair, where we enter and where we leave the manor
        if($x == -1) $reverseID = 2 * $n + $y;
        elseif($x == $n) $reverseID = 3 * $n + $y;
        elseif($y == -1) $reverseID = $x;
        elseif($y == $n) $reverseID = $n + $x;

        [$x, $y, $d, $count2] = $clues[$reverseID];

        unset($clues[$reverseID]);

        if(!$toSet1 && !$toCheck1) continue; //We only crossed mirrors in the manor, clues can be ignored

        [$toSet2, $toCheck2, $x, $y] = getPositions($x, $y, $d, $manor);

        $groups[] = [
            [$toSet1, $toCheck1, $count1],
            [$toSet2, $toCheck2, $count2],
        ];
        
        foreach($toSet1 as [$index, ]) $manor[$index] = 'X'; //If we reach position with other clues the monsters would already be set
    }

    return $groups;
}


fscanf(STDIN, "%d %d %d", $vampireCount, $zombieCount, $ghostCount);

fscanf(STDIN, "%d", $n);

$start = microtime(1);

foreach(explode(" ", fgets(STDIN)) as $i => $value) $clues[] = [$i, 0, 'D', intval($value)];
foreach(explode(" ", fgets(STDIN)) as $i => $value) $clues[] = [$i, $n - 1, 'U', intval($value)];
foreach(explode(" ", fgets(STDIN)) as $i => $value) $clues[] = [0, $i, 'L', intval($value)];
foreach(explode(" ", fgets(STDIN)) as $i => $value)  $clues[] = [$n - 1, $i, 'R', intval($value)];

$manor = "";

for ($i = 0; $i < $n; $i++) $manor .= trim(fgets(STDIN));

$groups = checkClues($manor, $clues);
$groupsCount = count($groups);

error_log(var_export(str_split($manor, $n), 1));

solve($vampireCount, $zombieCount, $ghostCount, $manor, 0);
