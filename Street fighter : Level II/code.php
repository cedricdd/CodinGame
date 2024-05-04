<?php

const CHAMPIONS = [
    "KEN" => ["Name" => "KEN", "Life" => 25, "PUNCH" => 6, "KICK" => 5, "Rage" => 0],
    "RYU" => ["Name" => "RYU", "Life" => 25, "PUNCH" => 4, "KICK" => 5, "Rage" => 0],
    "TANK" => ["Name" => "TANK", "Life" => 50, "PUNCH" => 2, "KICK" => 2, "Rage" => 0],
    "VLAD" => ["Name" => "VLAD", "Life" => 30, "PUNCH" => 3, "KICK" => 3, "Rage" => 0],
    "JADE" => ["Name" => "JADE", "Life" => 20, "PUNCH" => 2, "KICK" => 7, "Rage" => 0],
    "ANNA" => ["Name" => "ANNA", "Life" => 18, "PUNCH" => 9, "KICK" => 1, "Rage" => 0],
    "JUN" => ["Name" => "JUN", "Life" => 60, "PUNCH" => 2, "KICK" => 1, "Rage" => 0],
    "VI" => ["Name" => "VI", "Life" => 35, "PUNCH" => 12, "KICK" => 0, "Rage" => 0],
    "JINX" => ["Name" => "JINX", "Life" => 22, "PUNCH" => 4, "KICK" => 4, "Rage" => 0],
    "TIFA" => ["Name" => "TIFA", "Life" => 38, "PUNCH" => 5, "KICK" => 5, "Rage" => 0],
    "ZED" => ["Name" => "ZED", "Life" => 27, "PUNCH" => 4, "KICK" => 5, "Rage" => 0],
    "SETT" => ["Name" => "SETT", "Life" => 39, "PUNCH" => 8, "KICK" => 0, "Rage" => 0],
];

function getPermutations(array $fighters, array $permutation, array &$permutations) {
    if(count($fighters) == 0) {
        $permutations[] = $permutation;
        return;
    }

    foreach($fighters as $i => $fighter) {
        $permutation[] = $fighters[$i];

        unset($fighters[$i]);

        getPermutations($fighters, $permutation, $permutations);

        $fighters[$i] = $fighter;

        array_pop($permutation);
    }
}

function solve(array $team1, array $team2, array $attacks): int {
    $hits1 = 0;
    $hits2 = 0;
    $hitsT1 = 0;
    $hitsT2 = 0;

    foreach($attacks as $i => [$d, $attack]) {
        $attackedID = ($d == "<" ? "1" : "2");
        $attackerID = ($d == "<" ? "2" : "1");
        $attackerName = ${"team" . ($d == "<" ? "2" : "1")}[0]["Name"];
        $damage = 0;

        //Get how many damages is being inflicted
        if($attack == "SPECIAL") {
            switch($attackerName) {
                case "KEN":
                    $damage = 3 * ${"team" . $attackerID}[0]["Rage"];
                    break;
                case "RYU":
                    $damage = 4 * ${"team" . $attackerID}[0]["Rage"];
                    break;
                case "TANK":
                    $damage = 2 * ${"team" . $attackerID}[0]["Rage"];
                    break;
                case "VLAD":
                    $damage = 2 * ($team1[0]["Rage"] + $team2[0]["Rage"]);
                    ${"team" . $attackedID}[0]["Rage"] = 0;
                    break;
                case "JADE":
                    $damage = ${'hits' . $attackerID} * ${"team" . $attackerID}[0]["Rage"];
                    break;
                case "ANNA":
                    $damage = (18 - ${"team" . $attackerID}[0]["Life"]) * ${"team" . $attackerID}[0]["Rage"];
                    break;
                case "JUN":
                    $damage = ${"team" . $attackerID}[0]["Rage"];
                    ${"team" . $attackerID}[0]["Life"] += ${"team" . $attackerID}[0]["Rage"];
                    break;
                case "VI":
                    ${"team" . $attackerID}[0]["Life"] += ${"team" . $attackerID}[0]["Rage"];
                    break;
                case "JINX":
                    $damage = (22 - ${"team" . $attackerID}[0]["Life"]) * $team1[0]["Rage"] * $team2[0]["Rage"];
                    break;
                case "TIFA":
                    ${"team" . $attackerID}[0]["Life"] += 3 * ${"team" . $attackerID}[0]["Rage"];
                    break;
                case "ZED":
                    $damage = 5 * ${"team" . $attackerID}[0]["Rage"];
                    ${"team" . $attackerID}[0]["Life"] -= ${"team" . $attackerID}[0]["Rage"];
                    break;
                case "SETT":
                    $damage = 2 * ${"team" . $attackerID}[0]["Rage"];
                    ${"team" . $attackerID}[0]["Life"] += ${"team" . $attackerID}[0]["Rage"];
                    break;
            }
    
            ${"team" . $attackerID}[0]["Rage"] = 0;
        } else $damage = ${"team" . $attackerID}[0][$attack];

        ${"team" . $attackedID}[0]["Life"] -= $damage;
        ${"team" . $attackedID}[0]["Rage"]++;
        ${"hits" . $attackerID}++;

        // error_log("$d $attack $attackerName -- $damage");
        // error_log(var_export(implode(" ", $team1[0]), true));
        // error_log(var_export(implode(" ", $team2[0]), true));

        if($team1[0]["Life"] <= 0) {
            array_shift($team1);
            $hitsT1 += $hits1;
            $hits1 = 0;
        }
        if($team2[0]["Life"] <= 0) {
            array_shift($team2);
            $hitsT2 += $hits2;
            $hits2 = 0;
        }
    
        if(count($team1) == 0 || count($team2) == 0) break; //All of the contestants of a team are dead
    }

    $hitsT1 += $hits1;
    $hitsT2 += $hits2;

    if(count($team2) == 0) return $hitsT1;
    else return PHP_INT_MAX;
}

$start = microtime(1);

[$t1, $t2] = explode(" ", trim(fgets(STDIN)));

$permutations = [];
getPermutations(explode(";", $t1), [], $permutations);

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%s %s", $d, $attack);

    $attacks[] = [$d, $attack];
}

$solution = [PHP_INT_MAX, ""];

foreach(explode(";", $t2) as $name) $team2[] = CHAMPIONS[$name];

foreach($permutations as $p1) {
    $team1 = [];

    foreach($p1 as $name) $team1[] = CHAMPIONS[$name];
    
    $turnsToWin = solve($team1, $team2, $attacks);

    error_log(implode(";", $p1) . " -- " . $turnsToWin);

    if($turnsToWin < $solution[0]) $solution = [$turnsToWin, implode(";", $p1)];
}

//Team 2 won
if($solution[0] == PHP_INT_MAX) echo "We always lose" . PHP_EOL;
//Team 1 won
else echo $solution[1] . " beats " . $t2 . " in " . $solution[0] . " hits" . PHP_EOL;

error_log(microtime(1) - $start);
