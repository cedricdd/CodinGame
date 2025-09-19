<?php

function checkRule(?array $rule, int $value): bool {
    if($rule === null) return true;

    if($rule[0] == '=') {
        if($rule[3] == 1) return $value == $rule[1];
        else return $value <= $rule[1] && $value >= ($rule[1] - (($rule[3] - 1) * 6)); //TEST using real values
    } elseif($rule[0] == '>') {
        if($rule[3] == 1) return $value > $rule[1];
        else return $value > ($rule[1] - (($rule[3] - 1) * 6));
    } elseif($rule[0] == '<') {
        return $value < $rule[1]; 
    } elseif($rule[0] == "==") {
        if($rule[1] == -1) return true;
        else return $value == $rule[1];
    } elseif($rule[0] == "!=") return isset($rule[1][$value]);
    else exit("Rule no supported yet - " . $rule[0]);
}

function checkDoubleRule(?array $rule, int $value1, int $value2): bool {
    if($rule === null) return true;

    if($rule[0] == '=') {
        if($rule[3] == 2) return $rule[1] == $value1 + $value2;
        else return $value1 + $value2 <= $rule[1] && $value1 + $value2 >= ($rule[1] - (($rule[3] - 2) * 6)); //TEST using real values
    } elseif($rule[0] == "==") {
        if($rule[1] == -1) return $value1 == $value2;
        else return $value1 = $rule[1] && $value2 == $rule[1];
    } else exit("Rule double no supported yet - " . $rule[0]);
}

function updateRule(array &$rules, int $ruleID, int $index, int $value) {
    [$rule, &$ruleValue, &$positions, &$count] = $rules[$ruleID];

    //We don't need this rule anymore
    if($count == 1) unset($rules[$ruleID]);
    else {
        $count--;
        unset($positions[$index]);

        if($rule == '=') {
            $ruleValue -= $value;
        } elseif($rule == "==") {
            $ruleValue = $value;
        } elseif($rule == "!=") {
            unset($ruleValue[$value]);
        } else exit("Rule update no supported yet - " . $rule);
    }
}

function getPossibleDominoes(array $dominoes, array $rules, int $i1, int $i2): array {
    global $ruleByPositions;

    $possibilities = [];
    $count = 0;

    if($i1 > $i2) [$i1, $i2] = [$i2, $i1];

    $r1 = isset($ruleByPositions[$i1]) ? $rules[$ruleByPositions[$i1]] : null;
    $r2 = isset($ruleByPositions[$i2]) ? $rules[$ruleByPositions[$i2]] : null;

    foreach($dominoes as $dominoID => [$a, $b]) {
        if($r1 == $r2) {
            //We don't care about the rotation if both are in the same rule
            if(checkDoubleRule($r1, $a, $b)) {
                $possibilities[] = [$dominoID, $i1, $i2, $a, $b];
                ++$count;
            }
        } else {
            if(checkRule($r1, $a) && checkRule($r2, $b)) {
                $possibilities[] = [$dominoID, $i1, $i2, $a, $b];
                ++$count;
            }
            //Try the rotation of the domino, if both values are the same we can skip
            if($a != $b && checkRule($r1, $b) && checkRule($r2, $a)) {
                $possibilities[] = [$dominoID, $i1, $i2, $b, $a];
                ++$count;
            }
        }
    }

    return [$count, $possibilities];
}

function setDomino(array $info, array &$neighbors, array &$dominoes, array &$rules, array &$positionsToFind): string {
    global $width, $height, $ruleByPositions;

    [$dominoKey, $i1, $i2, $a, $b] = $info;

    // error_log(var_export($info, 1));

    //Update dominoes count
    if($dominoes[$dominoKey][2] > 1) $dominoes[$dominoKey][2]--;
    else unset($dominoes[$dominoKey]);

    //Update neighbors
    foreach($neighbors[$i1] as $n => $filler) unset($neighbors[$n][$i1]);
    foreach($neighbors[$i2] as $n => $filler) unset($neighbors[$n][$i2]);

    unset($neighbors[$i1]);
    unset($neighbors[$i2]);

    //Update rules
    if(isset($ruleByPositions[$i1])) updateRule($rules, $ruleByPositions[$i1], $i1, $a);
    if(isset($ruleByPositions[$i2])) updateRule($rules, $ruleByPositions[$i2], $i2, $b);

    //Update positions left to find
    unset($positionsToFind[$i1]);
    unset($positionsToFind[$i2]);

    return $a . " " . $b . " " . ($i1 % $width) . " " . intdiv($i1, $width) . " " . ((abs($i1 - $i2) == 1 && $width > 1) ? 0 : 1);
}

//If an index only has one neighbor we are that these two will contain a domino so the neighbor can't be associated with anything else
function reduceNeighbors(array &$neighbors, array &$positionsToFind, int $index) {
    $neighbor = array_key_first($neighbors[$index]);

    unset($positionsToFind[max($index, $neighbor)]);

    error_log("$index is sure to be associated with $neighbor");

    foreach($neighbors[$neighbor] as $n => $filler) {
        if($n == $index) continue;

        unset($neighbors[$n][$neighbor]);
        unset($neighbors[$neighbor][$n]);

        if(count($neighbors[$n]) == 1) reduceNeighbors($neighbors, $positionsToFind, $n);
    }
}

$ruleByPositions = [];

fscanf(STDIN, "%d %d", $height, $width);

$start = microtime(1);

for ($y = 0; $y < $height; ++$y) {
    foreach(explode(" ", trim(fgets(STDIN))) as $x => $v) {
        if($v > 0) {
            if(!isset($rules[$v])) $rules[$v] = [null, "", [], 0];

            $index = $y * $width + $x;
            $rules[$v][2][$index] = 1;
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

            $positionsToFind[$index] = 1;
        }
    }
}

foreach($neighbors as $index => $list) {
    if(count($list) == 1) reduceNeighbors($neighbors, $positionsToFind, $index);
}

error_log(var_export(array_map('implode', $map), 1));
// error_log(var_export($neighbors, 1));
// exit();

fscanf(STDIN, "%d", $rulesCount);

for ($i = 0; $i < $rulesCount; $i++) {
    fscanf(STDIN, "%d %s %d", $ruleID, $rule, $ruleValue);

    // error_log("$ruleID => $rule $ruleValue");

    if(($rule == "==" || $rule == "!=") && count($rules[$ruleID][2]) == 1) {
        error_log("useless rule $ruleID = with 1");
        unset($rules[$ruleID]);
        continue;
    }
    if($rule == "!=") $ruleValue = range(0, 6);

    $rules[$ruleID][0] = $rule;
    $rules[$ruleID][1] = $ruleValue;
}

// error_log(var_export($rules, 1));

fscanf(STDIN, "%d", $dominoesCount);
for ($i = 0; $i < $dominoesCount; $i++) {
    fscanf(STDIN, "%d %d", $a, $b);

    if($a > $b) [$a, $b] = [$b, $a];

    $key = $a . ";" . $b;

    if(!isset($dominoes[$key])) $dominoes[$key] = [$a, $b, 1];
    else $dominoes[$key][3]++;
}

// error_log(var_export($neighbors, 1));

$actions = [];

do {
    $dominoFound = false;

    foreach($positionsToFind as $index => $filler) {
        if(!isset($positionsToFind[$index])) continue; //Already found

        //We know for sure that a domino goes here
        if(count($neighbors[$index]) == 1) {
            $neighbor = array_key_first($neighbors[$index]);

            error_log("testing position: $index with $neighbor");

            [$count, $possibilities] = getPossibleDominoes($dominoes, $rules, $index, $neighbor);

            error_log("For $index we have $count");

            if($count == 0) exit("no possible domino for $index");

            if($count == 1) {
                error_log("We are sure we need to set at $index");
                // error_log(var_export(array_pop($possibilities), 1));

                $actions[] = setDomino(array_pop($possibilities), $neighbors, $dominoes, $rules, $positionsToFind);

                // error_log(var_export($neighbors, 1));
                $dominoFound = true;
            }
        }
    }
} while($dominoFound);

// error_log(var_export($actions, 1));

error_log(microtime(1) - $start);

echo implode(PHP_EOL, $actions) . PHP_EOL;
