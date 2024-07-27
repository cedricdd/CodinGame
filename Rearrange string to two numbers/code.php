<?php

const POWER = 10 ** 18;

function getFirstNonZero(array $digits): array {
    foreach($digits as $i => $digit) {
        if($digit != '0') return [$digit, $i];
    }

    return [null, null];
}

$inputs = str_split(trim(fgets(STDIN)));

if(count($inputs) <= 1) exit("-1 -1");

sort($inputs);

error_log(var_export($inputs, true));

$a = array_shift($inputs);
$b = '';

do {
    //Generate B
    if(count($inputs) == 1 || reset($inputs) != '0') $b = implode('', $inputs);
    else {
        [$digit, $position] = getFirstNonZero($inputs);
         
        if($digit === null) exit("-1 -1");

        $b = substr_replace($digit . implode("", $inputs), '', $position + 1, 1);
        error_log("$b -- $position");
    }

    error_log("$a - $b");

    if(intval($a) <= POWER && bccomp($b, strval(POWER)) <= 0) {
        exit(min($a, $b) . " " . max($a, $b));
    }

    if($a > POWER) exit("-1 -1");

    if(intval($a) == 0) {
        [$digit, $position] = getFirstNonZero($inputs);
         
        if($digit === null) exit("-1 -1");

        $a = $digit . $a;
        unset($inputs[$position]);

        error_log("A was 0 - $a");

    } else $a .= array_shift($inputs);
} while(true);
