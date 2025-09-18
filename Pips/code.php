<?php

function checkRule(?array $rule, int $value): bool {
    if($rule === null) return true;

    if($rule[0] == '=') {
        if($rule[3] == 1) return $value == $rule[1];
        else return $value <= $rule[1];
    } elseif($rule[0] == '>') {
        if($rule[3] == 1) return $value > $rule[1];
        else return $value > ($rule[1] - (($rule[3] - 1) * 6));
    } elseif($rule[0] == '<') {
        return $value < $rule[1]; 
    }
    else exit("Rule no supported yet - " . $rule[0]);
}

function getPossibleDominoes(array $dominoes, array $rules, int $i1, int $i2): array {
    global $ruleByPositions;

    $possibilities = [];

    $r1 = isset($ruleByPositions[$i1]) ? $rules[$ruleByPositions[$i1]] : null;
    $r2 = isset($ruleByPositions[$i2]) ? $rules[$ruleByPositions[$i2]] : null;

    //No constraints
    if($r1 === null && $r2 === null) return [];

    foreach($dominoes as $dominoID => [$a, $b]) {
        if(checkRule($r1, $a) && checkRule($r2, $b)) $possibilities[] = [$dominoID, $a, $b];
        if(checkRule($r1, $b) && checkRule($r2, $a)) $possibilities[] = [$dominoID, $b, $a];
    }

    return $possibilities;
}

$ruleByPositions = [];

fscanf(STDIN, "%d %d", $height, $width);
for ($y = 0; $y < $height; ++$y) {
    foreach(explode(" ", trim(fgets(STDIN))) as $x => $v) {
        if($v > 0) {
            if(!isset($rules[$v])) $rules[$v] = [null, "", [], 0];

            $index = $y * $width + $x;
            $rules[$v][2][] = $index;
            $rules[$v][3]++;

            $ruleByPositions[$index] = $v;
        }

        $map[$y][$x] = $v == -1 ? "#" : '.';
    }
}

$neighbors = [];

for($index = 0, $y = 0; $y < $height; ++$y) {
    for($x = 0; $x < $width; ++$x, ++$index) {
        if($map[$y][$x] == '.') {
            if($x > 0 && $map[$y][$x - 1] == '.') $neighbors[$index][$index - 1] = 1;
            if($x < $width - 1 && $map[$y][$x + 1] == '.') $neighbors[$index][$index + 1] = 1;
            if($y > 0 && $map[$y - 1][$x] == '.') $neighbors[$index][$index - $width] = 1;
            if($y < $height - 1 && $map[$y + 1][$x] == '.') $neighbors[$index][$index + $width] = 1;

            $positionsToFind[] = $index;
        }
    }
}

error_log(var_export(array_map('implode', $map), 1));
// error_log(var_export($neighbors, 1));

fscanf(STDIN, "%d", $rulesCount);

for ($i = 0; $i < $rulesCount; $i++) {
    fscanf(STDIN, "%d %s %d", $ruleID, $rule, $ruleValue);

    // error_log("$ruleID => $rule $ruleValue");

    if(($rule == "==" || $rule == "!=") && count($rules[$ruleID][2]) == 1) {
        error_log("useless rule $ruleID = with 1");
        unset($rules[$ruleID]);
        continue;
    }

    $rules[$ruleID][0] = $rule;
    $rules[$ruleID][1] = $ruleValue;
}

error_log(var_export($rules, 1));

fscanf(STDIN, "%d", $dominoesCount);
for ($i = 0; $i < $dominoesCount; $i++) {
    fscanf(STDIN, "%d %d", $a, $b);

    if($a > $b) [$a, $b] = [$b, $a];

    $key = $a . ";" . $b;

    if(!isset($dominoes[$key])) $dominoes[$key] = [$a, $b, $a + $b, 1];
    else $dominoes[$key][3]++;
}

// error_log(var_export($neighbors, 1));
// exit();

foreach($positionsToFind as $index) {
    //We know for sure that a domino goes here
    if(count($neighbors[$index]) == 1) {
        $possibilities = getPossibleDominoes($dominoes, $rules, $index, array_key_first($neighbors[$index]));

        if(count($possibilities) == 1) {
            error_log("We are sure we need to set at $index");
            error_log(var_export(array_pop($possibilities), 1));
        }
    }
}

/*
//Check if we have two rules with only one position next to each other
foreach($rules as $ruleID => [$rule, $value, $positions, $count]) {
    if($count == 1) {
        $index = $positions[0];

        error_log("rule Id $ruleID only has 1 position at $index");
        // error_log(var_export($neighbors[$index], 1));

        // There is only one possible neighbor, we know where the dominoe goes
        if(count($neighbors[$index]) == 1) {
            $neighbor = array_key_first($neighbors[$index]);

            if(!isset($ruleByPositions[$neighbor])) {
                error_log("there is no rule on neighbor");

                $possibilities = [];

                foreach($dominoes as $dominoIndex => [$v1, $v2]) {
                    if($rule == "=" && ($v1 == $value || $v2 == $value)) $possibilities[] = $dominoIndex;
                }

                if(count($possibilities) == 1) error_log("The only possible domino is " . array_pop($possibilities));

            }
            else exit("neighbor also has a rule");
        }
    }
}
*/
