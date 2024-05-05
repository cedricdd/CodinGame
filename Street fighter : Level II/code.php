<?php

const CHAMPIONS = [
    "KEN" => ["Name" => "KEN", "Life" => 25, "PUNCH" => 6, "KICK" => 5, "Hits" => 0, "Rage" => 0],
    "RYU" => ["Name" => "RYU", "Life" => 25, "PUNCH" => 4, "KICK" => 5, "Hits" => 0, "Rage" => 0],
    "TANK" => ["Name" => "TANK", "Life" => 50, "PUNCH" => 2, "KICK" => 2, "Hits" => 0, "Rage" => 0],
    "VLAD" => ["Name" => "VLAD", "Life" => 30, "PUNCH" => 3, "KICK" => 3, "Hits" => 0, "Rage" => 0],
    "JADE" => ["Name" => "JADE", "Life" => 20, "PUNCH" => 2, "KICK" => 7, "Hits" => 0, "Rage" => 0],
    "ANNA" => ["Name" => "ANNA", "Life" => 18, "PUNCH" => 9, "KICK" => 1, "Hits" => 0, "Rage" => 0],
    "JUN" => ["Name" => "JUN", "Life" => 60, "PUNCH" => 2, "KICK" => 1, "Hits" => 0, "Rage" => 0],
    "VI" => ["Name" => "VI", "Life" => 35, "PUNCH" => 12, "KICK" => 0, "Hits" => 0, "Rage" => 0],
    "JINX" => ["Name" => "JINX", "Life" => 22, "PUNCH" => 4, "KICK" => 4, "Hits" => 0, "Rage" => 0],
    "TIFA" => ["Name" => "TIFA", "Life" => 38, "PUNCH" => 5, "KICK" => 5, "Hits" => 0, "Rage" => 0],
    "ZED" => ["Name" => "ZED", "Life" => 27, "PUNCH" => 4, "KICK" => 5, "Hits" => 0, "Rage" => 0],
    "SETT" => ["Name" => "SETT", "Life" => 39, "PUNCH" => 8, "KICK" => 0, "Hits" => 0, "Rage" => 0],
];

//Generate all the order for the fighters in the team
function getPermutations(array $fighters, int $count, array $permutation, array &$permutations) {
    global $nbrInTeam; 

    if($count == $nbrInTeam) {
        $permutations[] = $permutation;
        return;
    }

    foreach($fighters as $i => $fighter) {
        $permutation[$count] = $fighters[$i];

        unset($fighters[$i]);

        getPermutations($fighters, $count + 1, $permutation, $permutations);

        $fighters[$i] = $fighter;
    }
}

function solve(array $team1, array $team2, array $attacks): int {
    $hitsTeam1 = 0;
    $hitsTeam2 = 0;

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
                    $damage = ${"team" . $attackerID}[0]["Hits"] * ${"team" . $attackerID}[0]["Rage"];
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

        ${"team" . $attackedID}[0]["Life"] -= $damage; //Aply damages
        ${"team" . $attackedID}[0]["Rage"]++; //Increase rage
        ${"team" . $attackerID}[0]["Hits"]++; //Increase hits

        if($team1[0]["Life"] <= 0) { //A fighter in team 1 is dead
            $hitsTeam1 += $team1[0]["Hits"];

            array_shift($team1);
        }
        if($team2[0]["Life"] <= 0) { //A fighter in team 2 is dead
            $hitsTeam2 += $team2[0]["Hits"];

            array_shift($team2);
        }
    
        if(count($team1) == 0 || count($team2) == 0) break; //All of the contestants of a team are dead
    }

    if(count($team1)) $hitsTeam1 += $team1[0]["Hits"];
    if(count($team2)) $hitsTeam2 += $team2[0]["Hits"];

    if(count($team1)) return $hitsTeam1; //Team 1 won
    else return PHP_INT_MAX; //Team 2 won
}

$start = microtime(1);

[$t1, $t2] = array_map(function($team) {
    return explode(";", $team);
}, explode(" ", trim(fgets(STDIN))));

$nbrInTeam = count($t1);

$permutations = [];
getPermutations($t1, 0, [], $permutations);

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%s %s", $d, $attack);

    $attacks[] = [$d, $attack];
}

$solution = [PHP_INT_MAX, ""];

foreach($t2 as $name) $team2[] = CHAMPIONS[$name];

//Test all the permutations of fighters
foreach($permutations as $p1) {
    $team1 = [];

    foreach($p1 as $name) $team1[] = CHAMPIONS[$name];
    
    $turnsToWin = solve($team1, $team2, $attacks);

    if($turnsToWin < $solution[0]) $solution = [$turnsToWin, implode(";", $p1)];
}


if($solution[0] == PHP_INT_MAX) echo "We always lose" . PHP_EOL; //Team 2 always wins
else echo $solution[1] . " beat " . implode(";", $t2) . " in " . $solution[0] . " hits" . PHP_EOL; //Team 1 can win

error_log(microtime(1) - $start);
