<?php

$health = 5000;

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%s %d %d %d", $SHIP, $HP, $ARMOR, $DAMAGE);
    $ships[] = ["TYPE" => $SHIP, "HP" => $HP, "ARMOR" => $ARMOR, "DMG" => $DAMAGE, "DMG_TAKEN" => max((($SHIP == "FIGHTER") ? 20 : 10) - $ARMOR, 1)];
}

usort($ships, function($a, $b) {
    //# of turns to kill $a
    $turnA = ceil($a["HP"] / $a["DMG_TAKEN"]);
    //# of turns to kill $b
    $turnB = ceil($b["HP"] / $b["DMG_TAKEN"]);

    //While we kill a ship the other one is still shooting us, we need to kill first the one that will deal us the most damage while we kill the other one
    return $turnA * $b["DMG"] <=> $turnB * $a["DMG"];
 });

$target = array_key_first($ships);

while(true) {
    //All the ships that are left are shooting on us
    foreach($ships as $ship) {
        if(($health -= $ship["DMG"]) < 0) {
            error_log(var_export($health, true));
            die("FLEE");
        }
    }

    //Shoot on the target
    if(($ships[$target]["HP"] -= $ships[$target]["DMG_TAKEN"]) <= 0) {
        //All the ships have been destroyed
        if(count($ships) == 1) exit("$health");
        //Move to the next target
        else {
            unset($ships[$target]);
            $target = array_key_first($ships);
        }
    }
}

?>
