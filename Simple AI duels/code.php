<?php

//Pseudo-random generator
function getRand(): string {
    static $x = 12;

    $x = (137 * $x + 187) % 256;

    return (substr_count(decbin($x), "1") & 1) ? "C" : "D";
}

fscanf(STDIN, "%d", $nbturns);

fscanf(STDIN, "%d %s", $n, $player1Name);
for ($i = 0; $i < $n; $i++) {
    $actions[0][] = explode(" ", stream_get_line(STDIN, 20 + 1, "\n"));
}

fscanf(STDIN, "%d %s", $m, $player2Name);
for ($i = 0; $i < $m; $i++) {
    $actions[1][] = explode(" ", stream_get_line(STDIN, 20 + 1, "\n"));
}

$scores = [0, 0];
$listActions = [];

for($turn = 0; $turn < $nbturns; ++$turn) {

    for($i = 0; $i < 2; ++$i) {
        foreach($actions[$i] as $action) {
            //Start or default action
            if(count($action) == 2) {
                if($action[0] == "*" || ($action[0] == "START" && $turn == 0)) {
                    $listActions[$i][] = ($action[1] == "RAND") ? getRand() : $action[1];
                    break;
                }
            } //Action to do if you are winning
             elseif(count($action) == 3) { 
                if($scores[$i] > $scores[($i + 1) % 2]) {
                    $listActions[$i][] = ($action[2] == "RAND") ? getRand() : $action[2];
                    break; 
                }
            } elseif(count($action) == 4) {
                $index = ($i + (($action[0] == "OPP") ? 1 : 0)) % 2;

                //Checking previous turn action
                if($action[1] == -1) {
                    if($listActions[$index][$turn - 1] == $action[2]) {
                        $listActions[$i][] = ($action[3] == "RAND") ? getRand() : $action[3];
                        break; 
                    }
                } //If the previous actions of X are dominated
                elseif($action[1] == "MAX") {
                    $values = array_count_values($listActions[$index]);

                    if($values[$action[2]] >= ceil(($turn + 1) / 2)) {
                        $listActions[$i][] = ($action[3] == "RAND") ? getRand() : $action[3];
                        break; 
                    }
                }
            } //If the previous N actions of X are dominated 
            elseif(count($action) == 5) { 
                $index = ($i + (($action[0] == "OPP") ? 1 : 0)) % 2;

                $values = array_count_values(array_slice($listActions[$index], 0, max($turn, $action[2])));

                if($values[$action[3]] >= ceil(($turn + 1) / 2)) {
                    $listActions[$i][] = ($action[4] == "RAND") ? getRand() : $action[4];
                    break; 
                }
            }
        }
    }

    //Update the scores
    if(end($listActions[0]) == end($listActions[1])) {
        //Both cooperate
        if(end($listActions[0]) == "C") {
            $scores[0] += 2;
            $scores[1] += 2;
        } //Both defect
        else {
            $scores[0] += 1;
            $scores[1] += 1; 
        }
    } //One cooperate and one defect
    else {
        if(end($listActions[0]) == "C") $scores[1] += 3;
        else $scores[0] += 3; 
    }
}

//Show winner
echo [-1 => $player2Name, 0 => "DRAW", 1 => $player1Name][$scores[0] <=> $scores[1]] . PHP_EOL;
?>
