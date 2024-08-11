<?php

function updateOutput(string $attribute, int $index, string $characteristic, int $value) {
    global $output;

    // error_log("setting $attribute with $characteristic - $value");

    if($value == 1) {
        $output[$attribute][$index] = [$characteristic => 1];

        // error_log("$characteristic IS with $attribute");

        foreach($output as $attribute2 => $filler) {
            if($attribute == $attribute2 || !isset($output[$attribute2][$index][$characteristic])) continue;

            unset($output[$attribute2][$index][$characteristic]);

            if(count($output[$attribute2][$index]) == 1) {
                $characteristic2 = array_key_first($output[$attribute2][$index]);

                // error_log("$characteristic2 IS only left for $attribute2");

                updateOutput($attribute2, $index, $characteristic2, 1);
            }
        }

        applyRelations($attribute, $characteristic);
    } elseif(isset($output[$attribute][$index][$characteristic])) {
        unset($output[$attribute][$index][$characteristic]);

        // error_log("$characteristic is NOT with $attribute");

        if(count($output[$attribute][$index]) == 1) {
            $characteristic2 = array_key_first($output[$attribute][$index]);

            // error_log("$characteristic2 IS only left for $attribute");

            updateOutput($attribute, $index, $characteristic2, 1);
        }
    }
}

function applyRelations(string $attribute, string $name) {
    global $indexes, $characteristics, $output;
    static $history = [];

    if(isset($history[$attribute][$name])) return;
    else $history[$attribute][$name] = 1;

    error_log("!!!!!using $name on $attribute");

    foreach($characteristics[$name] as $characteristic => $value) {
        $index = $indexes[$characteristic];

        if($index == -1) continue;

        updateOutput($attribute, $index, $characteristic, $value);
    }
}

function isNotWith(array &$characteristics, array &$history, string $a, string $b, bool $debug =false) {
    // if($debug) error_log("$a is NOT with $b");

    if(isset($characteristics[$a][$b])) return;
    else $characteristics[$a][$b] = 0;

    foreach($characteristics[$b] as $c => $value) {
        if($c == $a) continue;

        if($value == 1) {
            isNotWith($characteristics, $history, $a, $c, $debug);
            isNotWith($characteristics, $history, $c, $a, $debug);
        }
    }
}

function isWith(array &$characteristics, array &$history, string $a, string $b, bool $debug =false) {
    // if($debug) error_log("$a is with $b");

    if(isset($characteristics[$a][$b])) return;
    else $characteristics[$a][$b] = 1;

    foreach($characteristics[$b] as $c => $value) {
        if($c == $a) continue;

        if($value == 1){
            isWith($characteristics, $history, $a, $c, $debug);
            isWith($characteristics, $history, $c, $a, $debug);
        }
        else {
            isNotWith($characteristics, $history, $a, $c, $debug);
            isNotWith($characteristics, $history, $c, $a, $debug);
        }
    }
}

$start = microtime(1);

$links = [];
$indexes = [];
$characteristics = [];

fscanf(STDIN, "%d %d", $nbCharacteristics, $nbPeople);
for ($i = 0; $i < $nbCharacteristics; $i++) {

    $info = explode(" ", trim(fgets(STDIN)));

    foreach($info as $characteristic) {
        $characteristics[$characteristic] = [];
        $indexes[$characteristic] = $i - 1;
    }

    $infos[] = array_flip($info);
}

// error_log(var_export($characteristics, true));
$test = 4;

fscanf(STDIN, "%d", $nbLinks);
for ($i = 0; $i < $nbLinks; $i++) {
    preg_match("/(.*) ([&!]) (.*)/", trim(fgets(STDIN)), $link);

    [, $a, $op, $b] = $link;

    // error_log("$a $op $b");

    $history = [];

    if($op == '&') {
        isWith($characteristics, $history, $a, $b, $i == $test ? 1 : 0);
        isWith($characteristics, $history, $b, $a, $i == $test ? 1 : 0);
    }
    else {
        isNotWith($characteristics, $history, $a, $b, $i == $test ? 1 : 0);
        isNotWith($characteristics, $history, $b, $a, $i == $test ? 1 : 0);
    }

    // if($i == $test - 1 || $i == $test) {
    //     foreach($characteristics as $t => $l) {
    //         $c = [];
    //         foreach($l as $p => $m) {
    //             $c[] = $p . " - " . $m;
    //         }

    //         error_log("$t " . implode(" | ", $c)) . PHP_EOL;
    //     }

    //     error_log("\n\n");
    // }
}

foreach($characteristics as $t => $l) {
    $c = [];
    foreach($l as $p => $m) {
        $c[] = $p . " - " . $m;
    }

    error_log("$t " . implode(" | ", $c)) . PHP_EOL;
}

foreach($infos[0] as $attribute => $filler) {
    $output[$attribute] = array_slice($infos, 1);
}

foreach($output as $attribute => $filler) applyRelations($attribute, $attribute);

// ksort($output);

// error_log(var_export($output, true));

error_log(microtime(1) - $start);
