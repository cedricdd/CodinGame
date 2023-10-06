<?php

const ALPHABET = "ABCDEFGHIJKLMNOPQRSTUVWXYZ <";

preg_match_all("/(P|L[0-9]+|R[0-9]+)/", trim(fgets(STDIN)), $actions);

error_log(var_export($actions, true));

$index = 0;
$initials = "";

foreach($actions[0] as $action) {
    if($action == "P") {
        if($index == 27) $initials = substr($initials, 0, -1);
        else {
            $initials .= ALPHABET[$index];
            if(strlen($initials) == 3) break;
        }
    }
    elseif($action[0] == "L") $index = ($index - intval(substr($action, 1)) + 28) % 28;
    else $index = ($index + intval(substr($action, 1))) % 28;
}

echo $initials . PHP_EOL;
