<?php

const CHAMPIONS = [
    "KEN" => ["Life" => 25, "PUNCH" => 6, "KICK" => 5, "Hits" => 0, "Rage" => 0],
    "RYU" => ["Life" => 25, "PUNCH" => 4, "KICK" => 5, "Hits" => 0, "Rage" => 0],
    "TANK" => ["Life" => 50, "PUNCH" => 2, "KICK" => 2, "Hits" => 0, "Rage" => 0],
    "VLAD" => ["Life" => 30, "PUNCH" => 3, "KICK" => 3, "Hits" => 0, "Rage" => 0],
    "JADE" => ["Life" => 20, "PUNCH" => 2, "KICK" => 7, "Hits" => 0, "Rage" => 0],
    "ANNA" => ["Life" => 18, "PUNCH" => 9, "KICK" => 1, "Hits" => 0, "Rage" => 0],
    "JUN" => ["Life" => 60, "PUNCH" => 2, "KICK" => 1, "Hits" => 0, "Rage" => 0],
];

fscanf(STDIN, "%s %s", $champion1, $champion2);

$c1 = CHAMPIONS[$champion1];
$c2 = CHAMPIONS[$champion2];

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%s %s", $d, $ATTACK);

    $attackedID = ($d == "<" ? "1" : "2");
    $attackerID = ($d == "<" ? "2" : "1");
    $attackerName = ${"champion" . ($d == "<" ? "2" : "1")};

    //Get how many damages is being inflicted
    if($ATTACK == "SPECIAL") {
        switch($attackerName) {
            case "KEN":
                $damage = 3 * ${"c" . $attackerID}["Rage"];
                break;
            case "RYU":
                $damage = 4 * ${"c" . $attackerID}["Rage"];
                break;
            case "TANK":
                $damage = 2 * ${"c" . $attackerID}["Rage"];
                break;
            case "VLAD":
                $damage = 2 * ($c1["Rage"] + $c2["Rage"]);
                ${"c" . $attackedID}["Rage"] = 0;
                break;
            case "JADE":
                $damage = ${"c" . $attackerID}["Hits"] * ${"c" . $attackerID}["Rage"];
                break;
            case "ANNA":
                $damage = (18 - ${"c" . $attackerID}["Life"]) * ${"c" . $attackerID}["Rage"];
                break;
            case "JUN":
                $damage = ${"c" . $attackerID}["Rage"];
                ${"c" . $attackerID}["Life"] += ${"c" . $attackerID}["Rage"];
                break;
        }

        ${"c" . $attackerID}["Rage"] = 0;
    } else $damage = ${"c" . $attackerID}[$ATTACK];

    ${"c" . $attackedID}["Life"] -= $damage;
    ${"c" . $attackedID}["Rage"]++;
    ${"c" . $attackerID}["Hits"]++;

    if($c1["Life"] <= 0 || $c2["Life"] <= 0) break; //One of the contestants is dead
}

//Champion 2 won
if($c1["Life"] < $c2["Life"]) echo $champion2 . " beats " . $champion1 . " in " . $c2["Hits"] . " hits" . PHP_EOL;
//Champion 1 won
else echo $champion1 . " beats " . $champion2 . " in " . $c1["Hits"] . " hits" . PHP_EOL;
