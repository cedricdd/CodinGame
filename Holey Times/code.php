<?php

$digits = range(0, 9);
$digitsNoZero = range(1, 9);

function generatePossibleValues(string $input, int $i = 0): array {
    global $digits, $digitsNoZero;

    $values = ["" => 1];
    $l = $i > 0 ? $i * - 1 : PHP_INT_MAX;

    foreach(str_split(substr(trim($input), 0, $l)) as $x => $d) {
        $newValues = [];

        foreach($values as $value => $filler) {
            if($d == '*') {
                foreach(($x != 0 ? $digits : $digitsNoZero) as $possibleDigit) $newValues[$value . $possibleDigit] = 1;
            }
            else $newValues[$value . $d] = 1;
        }

        $values = $newValues;
    }

    return $values;
}

function generatePossibleValuesSplit(string $input): array {
    global $digits, $digitsNoZero;

    $values = [];

    foreach(str_split(trim(ltrim($input, 'x'))) as $x => $d) {
        if($d == '*') $values[] = ($x != 0 ? $digits : $digitsNoZero);
        else $values[] = [$d];
    }

    return $values;
}

$start = microtime(1);

fscanf(STDIN, "%d", $n);

$number1List = [];
$number2List = [];
$partialsList = [];
$resultList = [];

$number1List = generatePossibleValues(fgets(STDIN));
// $number2List = generatePossibleValuesSplit(fgets(STDIN));
$number2List = generatePossibleValues(ltrim(fgets(STDIN), 'x'));
// $nbrPartials = count($number2List);

$size = strlen(array_key_first($number2List));

// error_log(var_export($number2List, 1));
// error_log(var_export($number2List, 1));

$outputSize = strlen(trim(fgets(STDIN)));

for($i = 0; $i < $size; ++$i) {
    $partialsList[$i] = generatePossibleValues(fgets(STDIN), $i);

    error_log(count($partialsList[$i]));
}

fgets(STDIN);

$resultList = generatePossibleValues(fgets(STDIN));

error_log(var_export("size is $size", 1));
// error_log(var_export($partialsList, 1));

foreach($number1List as $number1 => $filler1) {
    foreach($number2List as $number2 => $filler2) {
        // error_log("$number1 * $number2");

        $partials = array_fill(0, $size, 0);

        for($i = 0; $i < $size; ++$i) {
            $partialIndex = ($size - 1 - $i);
            $digit = strval($number2)[$i];

            // error_log("testing $digit - $partialIndex");

            //TODO stop it too big

            if(!isset($partialsList[$partialIndex][$number1 * $digit])) {
                // error_log("we can't use '$digit' -- " . ($number1 * $digit));
                continue 2;
            }

            $partials[$partialIndex] = $number1 * $digit * (10 ** $partialIndex);
        }

        $total = array_sum($partials);

        if(!isset($resultList[$total])) continue;

        echo str_pad($number1, $outputSize, ' ', STR_PAD_LEFT) . PHP_EOL;
        echo 'x' . str_pad($number2, $outputSize - 1, ' ', STR_PAD_LEFT) . PHP_EOL;
        echo str_repeat('-', $outputSize) . PHP_EOL;
        echo implode(PHP_EOL, array_map(function($partial) use ($outputSize) { return str_pad($partial, $outputSize, ' ', STR_PAD_LEFT); }, $partials)) . PHP_EOL;
        echo str_repeat('-', $outputSize) . PHP_EOL;
        echo str_pad($total, $outputSize, ' ', STR_PAD_LEFT) . PHP_EOL;
        error_log(microtime(1) - $start);
        exit();
    }
}

exit();

foreach($number2List as $i => $list) {
    $partialIndex = ($nbrPartials - 1 - $i);

    error_log("Working at $i - $partialIndex");
    error_log(var_export($list, 1));


    if(count($list) > 1) {
        if(count($number1List) == 1 && count($partialsList[$partialIndex]) == 1) {
            $value = reset($partialsList[$partialIndex]) / reset($number1List);

            error_log("for number2 at $i we have $value");

            $number2List[$i] = [$value];

            continue;
        }

        $partial = reset($partialsList[$partialIndex]);

        error_log("Looking for $partial");
        foreach($list as $possibleDigit) {
            foreach($number1List as $n1) {
                if($n1 * $possibleDigit == $partial) error_log("$n1 * $possibleDigit = $partial");
            }
        }
    } else {
        if(count($number1List) == 1 && count($partialsList[$partialIndex]) > 1) {
            // error_log("setting partial $partialIndex to " . (reset($number1List) * reset($list)));
            $partialsList[$partialIndex] = [reset($number1List) * reset($list)];
        }
    }
}

// error_log(var_export($partialsList, 1));

if(count($resultList) > 1) {
    $result = 0;

    foreach($partialsList as $i => $list) $result += reset($list) * (10 ** $i);

    $resultList = [$result];
}

echo str_pad(reset($number1List), $outputSize, ' ', STR_PAD_LEFT) . PHP_EOL;
echo 'x' . str_pad(implode('', array_map('array_pop', $number2List)), $outputSize - 1, ' ', STR_PAD_LEFT) . PHP_EOL;
echo str_repeat('-', $outputSize) . PHP_EOL;
for($i = 0; $i < $nbrPartials; ++$i) echo str_pad(reset($partialsList[$i]) * (10 ** $i), $outputSize, ' ', STR_PAD_LEFT) . PHP_EOL;
echo str_repeat('-', $outputSize) . PHP_EOL;
echo str_pad(reset($resultList), $outputSize, ' ', STR_PAD_LEFT) . PHP_EOL;
