<?php

$start = microtime(1);

fscanf(STDIN, "%d", $attack);
fscanf(STDIN, "%d", $defense);

//Generate the results of each possible battles
function generateBattle(int $defense, int $attack): array {
    global $diceRolls;
     
    $total = 0;
    $armyLoss = [[1 => 0, 2 => 0], [0 => 0, 1 => 0], [0 => 0]];
    
    foreach($diceRolls[$defense] as $defenseRoll) {
        foreach($diceRolls[$attack] as $attackRoll) {
            $lossAttack = 0;
            $lossDefense = 0;
            
            //At max 2 armies will be lost
            for($i = 0; $i < 2; ++$i) {
                if(!isset($defenseRoll[$i]) || !isset($attackRoll[$i])) break;

                if($attackRoll[$i] > $defenseRoll[$i]) $lossDefense++;
                else $lossAttack++;
            }
            
            $armyLoss[$lossDefense][$lossAttack]++;
            ++$total;
        }
    }
    
    //Save the percentage of each possible outcomes of the battle
    foreach($armyLoss as $lossDefense => $list) {
        foreach($list as $lossAttack => $count) {
            if($count == 0) continue;

            $results[] = [$lossDefense, $lossAttack, $count /= $total];
        }
    }
    
    return $results;
}

//Generate all the rolls of $size
function generateRolls(int $size): array {
    $results = [[1], [2], [3], [4], [5], [6]];
    
    for($i = 1; $i < $size; ++$i) {
        $newResults = [];
        foreach($results as $result) {
            for($j = 1; $j <= 6; ++$j) {
                $result[$i] = $j;
                $newResults[] = $result;
            }
        }
        
        $results = $newResults;
    }
    
    //We want them ordered from biggest to lowest value
    foreach($results as &$result) rsort($result);
    
    return $results;
}

function solve(int $defense, int $attack): float {

    static $history = [];
    static $battles = [];
        
    if($defense == 0) return 1.0; //Defense lost
    if($attack == 0)  return 0.0; //Attack lost

    if(isset($history[$defense][$attack])) return $history[$defense][$attack];
    
    //The number of dices the defense and attack will roll
    $diceDefense = $defense > 1 ? 2 : 1;
    $diceAttack = $attack > 2 ? 3 : $attack;
    
    $result = 0.0;

    //We need to compute the result of this battle
    if(!isset($battles[$diceDefense][$diceAttack])) $battles[$diceDefense][$diceAttack] = generateBattle($diceDefense, $diceAttack);

    foreach($battles[$diceDefense][$diceAttack] as [$lossDefense, $lossAttack, $percentage]) {
        $result += solve($defense - $lossDefense, $attack - $lossAttack) * $percentage;
    }
    
    return $history[$defense][$attack] = $result;
}

//Generate all the possible dice rolls
for($i = 1; $i <= 3; ++$i) $diceRolls[$i] = generateRolls($i);

echo number_format(solve($defense, $attack) * 100, 2) . "%" . PHP_EOL;

error_log(microtime(1) - $start) . PHP_EOL;
