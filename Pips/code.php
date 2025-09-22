<?php

function checkRule(?array $rule, int $value): bool {
    if($rule === null) return true;

    if($rule[0] == '=') {
        return $value <= $rule[1] && $value >= ($rule[1] - (($rule[2] - 1) * 6)); //TEST using real values
    } elseif($rule[0] == '>') {
        if($rule[2] == 1) return $value > $rule[1];
        else return $value > ($rule[1] - (($rule[2] - 1) * 6));
    } elseif($rule[0] == '<') {
        return $value < $rule[1]; 
    } elseif($rule[0] == "==") {
        return isset($rule[1][$value]);
    } elseif($rule[0] == "!=") return isset($rule[1][$value]);
    else exit("Rule no supported yet - " . $rule[0]);
}

function checkDoubleRule(?array $rule, int $value1, int $value2): bool {
    if($rule === null) return true;

    if($rule[0] == '=') {
        return $value1 + $value2 <= $rule[1] && $value1 + $value2 >= ($rule[1] - (($rule[2] - 2) * 6)); //TEST using real values
    } elseif($rule[0] == "==") {
        return $value1 == $value2 && isset($rule[1][$value1]);
    } elseif($rule[0] == "!=") {
        return $value1 != $value2 && isset($rule[1][$value1]) && isset($rule[1][$value2]);
    } elseif($rule[0] == '>') {
        return $value1 + $value2 > ($rule[1] - (($rule[2] - 2) * 6));
    } elseif($rule[0] == '<') {
        return $value1 + $value2 < $rule[1]; 
    }
    else exit("Rule double no supported yet - " . $rule[0]);
}

function updateRule(array &$rules, int $ruleID, int $index, int $value) {
    [$rule, &$ruleValue, &$count] = $rules[$ruleID];

    //We don't need this rule anymore
    if($count == 1) unset($rules[$ruleID]);
    else {
        $count--;

        if($rule == '=' || $rule == '>' || $rule == '<') {
            $ruleValue -= $value;
        } elseif($rule == "==") {
            $ruleValue = [$value => 1];
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

function setDomino(array $info, array &$positionsToFind, array &$neighbors, array &$dominoes, array &$rules, array &$values): string {
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

    //Update the values left
    $values[$a]--;
    $values[$b]--;

    return $a . " " . $b . " " . ($i1 % $width) . " " . intdiv($i1, $width) . " " . ((abs($i1 - $i2) == 1 && $width > 1) ? 0 : 1);
}

//If an index only has one neighbor we are that these two will contain a domino so the neighbor can't be associated with anything else
function reduceNeighbors(array &$neighbors, array &$positionsToFind, int $index) {
    global $width;

    $neighbor = array_key_first($neighbors[$index]);

    unset($positionsToFind[max($index, $neighbor)]);

    error_log(($index % $width) . ";" . intdiv($index, $width) . " is sure to be associated with " . ($neighbor % $width) . ";" . intdiv($neighbor, $width));

    foreach($neighbors[$neighbor] as $n => $filler) {
        if($n == $index) continue;

        unset($neighbors[$n][$neighbor]);
        unset($neighbors[$neighbor][$n]);

        if(count($neighbors[$n]) == 1) reduceNeighbors($neighbors, $positionsToFind, $n);
    }
}

function getMaxValue(array $values, int $count): int {
    for($i = 6; $i > 0; ++$i) {

    }
}

function solve(array $positionsToFind, array $neighbors, array $dominoes, array $rules, array $values, array $actions) {
    global $start;
    static $guessMade = 0;

    while(true) {
        $dominoFound = false;
        $bestGuessCount = INF;
        $bestGuess = null;

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

                error_log("testing position: $index with $neighbor");

                [$count, $possibilities] = getPossibleDominoes($dominoes, $rules, $index, $neighbor);

                error_log("For $index we have $count");

                if($count == 0) {
                    error_log("no possible domino for $index");
                    // error_log(var_export($dominoes, 1));
                    // error_log(var_export($rules, 1));
                    return;
                }

                if($count == 1) {
                    error_log("We are sure we need to set at $index - " . $possibilities[0][0]);
                    // error_log(var_export(array_pop($possibilities), 1));

                    $actions[] = setDomino(array_pop($possibilities), $positionsToFind, $neighbors, $dominoes, $rules, $values);

                    $dominoFound = true;
                } elseif($bestGuessCount > $count) {
                    if(!isset($candidates[$index])) $candidates[$index] = [0, []];

                    $candidates[$index][0] += $count;
                    array_push($candidates[$index][1], ...$possibilities);
                }
            } elseif($countNeighbors == 0) {
                error_log("no neighbor left for $index");
                return;
            }
        }

        if($dominoFound) continue;

        //We don't have any candidates
        if(!$candidates) {
            foreach($positionsToFind as $index => $filler1) {
                if(!isset($candidates[$index])) $candidates[$index] = [0, []];

                foreach($neighbors[$index] as $neighbor => $filler2) {
                    if($neighbor < $index) continue;

                    if(!isset($candidates[$neighbor])) $candidates[$neighbor] = [0, []];

                    [$count, $possibilities] = getPossibleDominoes($dominoes, $rules, $index, $neighbor);

                    // error_log("for $index with $neighbor we have $count");

                    $candidates[$index][0] += $count;
                    array_push($candidates[$index][1], ...$possibilities);

                    $candidates[$neighbor][0] += $count;
                    array_push($candidates[$neighbor][1], ...$possibilities);
                }
            }
        }

        uasort($candidates, function($a, $b) {
            return $b[0] <=> $a[0];
        });

        error_log("making a guess at " . array_key_last($candidates));

        ++$guessMade;

        $count = count($actions);

        [, $possibilities] = array_pop($candidates);

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
// error_log(var_export($neighbors, 1));

fscanf(STDIN, "%d", $rulesCount);

for ($i = 0; $i < $rulesCount; $i++) {
    fscanf(STDIN, "%d %s %d", $ruleID, $rule, $ruleValue);

    if($rule == "!=" || $rule == "==") $ruleValue = range(0, 6);

    $rules[$ruleID][0] = $rule;
    $rules[$ruleID][1] = $ruleValue;
}

// error_log(var_export($rules, 1));

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

solve($positionsToFind, $neighbors, $dominoes, $rules, $values, []);
