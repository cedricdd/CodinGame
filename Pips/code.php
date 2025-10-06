<?php

//Check if adding $value will go against the rule
function checkRule(?array $rule, int $value, array $values, int $value2): bool {
    if($rule === null) return true;

    if($rule[0] == '=') {
        if($rule[2] == 1) return $value == $rule[1];
        else {
            $values[$value]--;
            $values[$value2]--;

            return $value + getMinValue($values, $rule[2] - 1) <= $rule[1] && $value >= ($rule[1] - getMaxValue($values, $rule[2] - 1));
        }
    } elseif($rule[0] == '>') {
        if($rule[2] == 1) return $value > $rule[1];
        else return $value > ($rule[1] - getMaxValue($values, $rule[2] - 1));
    } elseif($rule[0] == '<') {
        return $value + getMinValue($values, $rule[2] - 1) < $rule[1];
    } elseif($rule[0] == "==") {
        return isset($rule[1][$value]);
    } elseif($rule[0] == "!=") {
        return isset($rule[1][$value]);
    }
    else exit("Rule no supported yet - " . $rule[0]);
}

//Check if adding $value1 & $value2 will go against the rule, we add two value to the same rule
function checkDoubleRule(?array $rule, int $value1, int $value2, array $values): bool {
    if($rule === null) return true;

    if($rule[0] == '=') {
        if($rule[2] == 2) return $value1 + $value2 == $rule[1];
        else {
            $values[$value1]--;
            $values[$value2]--;

            return $value1 + $value2 <= $rule[1] && $value1 + $value2 >= ($rule[1] - getMaxValue($values, $rule[2] - 2));
        }
    } elseif($rule[0] == '>') {
        return $value1 + $value2 > ($rule[1] - getMaxValue($values, $rule[2] - 2));
    } elseif($rule[0] == '<') {
        return $value1 + $value2 + getMinValue($values, $rule[2] - 2) < $rule[1];
    } elseif($rule[0] == "==") {
        return $value1 == $value2 && isset($rule[1][$value1]);
    } elseif($rule[0] == "!=") {
        return $value1 != $value2 && isset($rule[1][$value1]) && isset($rule[1][$value2]);
    } else exit("Rule double no supported yet - " . $rule[0]);
}

//We are adding a value to a rule
function updateRule(array &$rules, int $ruleID, int $index, int $value) {
    [$rule, &$ruleValues, &$count] = $rules[$ruleID];

    //We don't need this rule anymore
    if($count == 1) unset($rules[$ruleID]);
    else {
        $count--;

        if($rule == '=' || $rule == '>' || $rule == '<') {
            $ruleValues -= $value;
        } elseif($rule == "==") {
            $ruleValues = [$value => 1];
        } elseif($rule == "!=") {
            unset($ruleValues[$value]);
        } else exit("Rule update no supported yet - " . $rule);
    }
}

//Get all the possible dominoes we can add at $i1 & $i2
function getPossibleDominoes(array $dominoes, array $rules, array $values, int $i1, int $i2): array {
    global $ruleByPositions;

    $possibilities = [];
    $count = 0;

    if($i1 > $i2) [$i1, $i2] = [$i2, $i1];

    $r1 = isset($ruleByPositions[$i1]) ? $rules[$ruleByPositions[$i1]] : null;
    $r2 = isset($ruleByPositions[$i2]) ? $rules[$ruleByPositions[$i2]] : null;

    foreach($dominoes as $dominoID => [$a, $b]) {
        //The two positions are using the same rule
        if(($ruleByPositions[$i1] ?? null) == ($ruleByPositions[$i2] ?? null)) {
            //We don't care about the rotation if both are in the same rule
            if(checkDoubleRule($r1, $a, $b, $values)) {
                $possibilities[] = [$dominoID, $i1, $i2, $a, $b];
                ++$count;
            }
        } else {
            if(checkRule($r1, $a, $values, $b) && checkRule($r2, $b, $values, $a)) {
                $possibilities[] = [$dominoID, $i1, $i2, $a, $b];
                ++$count;
            }
            //Try the rotation of the domino, if both values are the same we can skip
            if($a != $b && checkRule($r1, $b, $values, $a) && checkRule($r2, $a, $values, $b)) {
                $possibilities[] = [$dominoID, $i1, $i2, $b, $a];
                ++$count;
            } 
        }
    }

    return [$count, $possibilities];
}

function setDomino(array $info, array &$positionsToFind, array &$neighbors, array &$dominoes, array &$rules, array &$values): string {
    global $width, $height, $ruleByPositions;

    [$dominoKey, $i1, $i2, $a, $b] = $info;

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

    //Update the values left
    $values[$a]--;
    $values[$b]--;

    foreach($rules as $ruleID => [$rule, , $count]) {
        if($rule == '==') {
            foreach($values as $value => $occ) {
                //We don't have enough occurence of that value, it can't satisfy the rule
                if($occ < $count) unset($rules[$ruleID][1][$value]);
            }
        }
    }
    
    return $a . " " . $b . " " . ($i1 % $width) . " " . intdiv($i1, $width) . " " . ((abs($i1 - $i2) == 1 && $width > 1) ? 0 : 1);
}

//If an index only has one neighbor we are sure that these two will contain a domino so the neighbor can't be associated with anything else
function reduceNeighbors(array &$neighbors, array &$positionsToFind, int $index) {
    global $width;

    $neighbor = array_key_first($neighbors[$index]);

    unset($positionsToFind[max($index, $neighbor)]);

    foreach($neighbors[$neighbor] as $n => $filler) {
        if($n == $index) continue;

        unset($neighbors[$n][$neighbor]);
        unset($neighbors[$neighbor][$n]);

        if(count($neighbors[$n]) == 1) reduceNeighbors($neighbors, $positionsToFind, $n);
    }
}

//Get the max value we can generate by using $count of the remaining $values
function getMaxValue(array $values, int $count): int {
    $max = 0;

    for($i = 6; $i > 0; --$i) {
        $occ = min($values[$i], $count);
        $max += $i * $occ;
        $count -= $occ;
    }

    return $max;
}

//Get the min value we can generate by using $count of the remaining $values
function getMinValue(array $values, int $count): int {
    $min = 0;

    for($i = 0; $i <= 6; ++$i) {
        $occ = min($values[$i], $count);
        $min += $i * $occ;
        $count -= $occ;
    }

    return $min;
}

function solve(array $positionsToFind, array $neighbors, array $dominoes, array $rules, array $values, array $actions) {
    global $start;
    static $guessMade = 0;

    while(true) {
        $dominoFound = false;

        if(!$positionsToFind) {
            error_log("Guesses Made: $guessMade");
            error_log(microtime(1) - $start);

            echo implode(PHP_EOL, $actions) . PHP_EOL;
            exit();
        }

        $candidates = [];

        foreach($positionsToFind as $index => $filler) {
            if(!isset($positionsToFind[$index])) continue; //Already found

            $countNeighbors = count($neighbors[$index]);

            //We know for sure that a domino goes here
            if($countNeighbors == 1) {
                $neighbor = array_key_first($neighbors[$index]);

                [$count, $possibilities] = getPossibleDominoes($dominoes, $rules, $values, $index, $neighbor);

                if($count == 0) return; //We made a bad guess previously

                //Only one possibility, we directly use it
                if($count == 1) {
                    $actions[] = setDomino(array_pop($possibilities), $positionsToFind, $neighbors, $dominoes, $rules, $values);

                    $dominoFound = true;
                } else {
                    if(!isset($candidates[$index])) $candidates[$index] = [0, []];

                    $candidates[$index][0] += $count;
                    array_push($candidates[$index][1], ...$possibilities);
                }
            } elseif($countNeighbors == 0) return; //We made a bad guess previously
        }

        if($dominoFound) continue;

        //We don't have any candidates
        if(!$candidates) {
            foreach($positionsToFind as $index => $filler1) {
                if(!isset($candidates[$index])) $candidates[$index] = [0, []];

                foreach($neighbors[$index] as $neighbor => $filler2) {
                    if($neighbor < $index) continue;

                    if(!isset($candidates[$neighbor])) $candidates[$neighbor] = [0, []];

                    [$count, $possibilities] = getPossibleDominoes($dominoes, $rules, $values, $index, $neighbor);

                    $candidates[$index][0] += $count;
                    array_push($candidates[$index][1], ...$possibilities);

                    $candidates[$neighbor][0] += $count;
                    array_push($candidates[$neighbor][1], ...$possibilities);
                }
            }
        }

        //We will make the guess on the index that has the less possibilities
        uasort($candidates, function($a, $b) {
            return $b[0] <=> $a[0];
        });

        [, $possibilities] = array_pop($candidates);

        $countCandidates = count($possibilities);

        if($countCandidates == 1) {
            $actions[] = setDomino(array_pop($possibilities), $positionsToFind, $neighbors, $dominoes, $rules, $values);

            continue;
        } elseif($countCandidates == 0) return; //We made a bad guess previously

        ++$guessMade;

        $count = count($actions);

        //Test each possibilities
        foreach($possibilities as $guess) {
            $positionsToFind2 = $positionsToFind;
            $neighbors2 = $neighbors;
            $dominoes2 = $dominoes;
            $values2 = $values;
            $rules2 = $rules;

            $actions[$count] = setDomino($guess, $positionsToFind2, $neighbors2, $dominoes2, $rules2, $values2);

            solve($positionsToFind2, $neighbors2, $dominoes2, $rules2, $values2, $actions);
        }

        return;
    }
}

$ruleByPositions = [];

fscanf(STDIN, "%d %d", $height, $width);

$start = microtime(1);

for ($y = 0; $y < $height; ++$y) {
    foreach(explode(" ", trim(fgets(STDIN))) as $x => $v) {
        if($v > 0) {
            if(!isset($rules[$v])) $rules[$v] = [null, "", 0];

            $index = $y * $width + $x;
            $rules[$v][2]++;

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

fscanf(STDIN, "%d", $rulesCount);

for ($i = 0; $i < $rulesCount; $i++) {
    fscanf(STDIN, "%d %s %d", $ruleID, $rule, $ruleValue);

    if($rule == "!=" || $rule == "==") $ruleValue = range(0, 6);

    $rules[$ruleID][0] = $rule;
    $rules[$ruleID][1] = $ruleValue;
}

$values = array_fill(0, 7, 0);

fscanf(STDIN, "%d", $dominoesCount);
for ($i = 0; $i < $dominoesCount; $i++) {
    fscanf(STDIN, "%d %d", $a, $b);

    $values[$a]++;
    $values[$b]++;

    if($a > $b) [$a, $b] = [$b, $a];

    $key = $a . ";" . $b;

    if(!isset($dominoes[$key])) $dominoes[$key] = [$a, $b, 1];
    else $dominoes[$key][3]++;
}

foreach($rules as $ruleID => [$rule, , $count]) {
    if($rule == '==') {
        foreach($values as $value => $occ) {
            //We don't have enough occurence of that value, it can't satisfy the rule
            if($occ < $count) unset($rules[$ruleID][1][$value]);
        }
    }
}

solve($positionsToFind, $neighbors, $dominoes, $rules, $values, []);
