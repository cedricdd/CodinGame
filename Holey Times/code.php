<?php

$digits = range(0, 9);
$digitsNoZero = range(1, 9);

function generatePossibleValues(string $input, int $i = 0): array {
    global $digits, $digitsNoZero;

    $values = ["" => 1];
    $l = $i > 0 ? $i * - 1 : PHP_INT_MAX; //In the partial we skip the '0' at the end

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

$start = microtime(1);

fscanf(STDIN, "%d", $n);

$number1List = [];
$number2List = [];
$partialsList = [];
$resultList = [];

$number1List = generatePossibleValues(fgets(STDIN));
$number2List = generatePossibleValues(ltrim(fgets(STDIN), 'x'));

$size1 = strlen(array_key_first($number1List));
$size2 = strlen(array_key_first($number2List));

$outputSize = strlen(trim(fgets(STDIN)));
$sizePartials = [];

for($i = 0; $i < $size2; ++$i) {
    $input = trim(fgets(STDIN));

    //Based on the size of the partial we know that the digit is a 0
    if($size1 > strlen($input) - $i) {
        $index = $size2 - $i - 1;

        //Remove all the possible numbers that don't have a '0' at the this position
        foreach($number2List as $number => $filler) {
            if(substr($number, $index, 1) !== '0') {
                unset($number2List[$number]);
            }
        }

        $partialsList[$i] = [0];
    } else {
        $partialsList[$i] = generatePossibleValues($input, $i);
    }
}

fgets(STDIN);

$input = trim(fgets(STDIN));
$resultSize = strlen($input);
$checkResults = false;

//We have contraints on the result
if(!empty(trim($input, '*'))) { 
    $checkResults = true;
    $resultList = generatePossibleValues($input);
}

foreach($number1List as $number1 => $filler1) {

    $min = max(10 ** ($size2 - 1), (10 ** ($resultSize - 1)) / $number1); //The min value of number2 to have the right number of digits in the multiplication
    $max = min(10 ** $size2 - 1, (10 ** $resultSize - 1) / $number1); //The max value of number2 to have the right number of digits in the multiplication

    foreach($number2List as $number2 => $filler2) {
        if($number2 < $min) continue; // Too small
        if($number2 > $max) continue 2; // Too big

        $number2 = strval($number2);

        for($i = 0; $i < $size2; ++$i) {
            $partialIndex = ($size2 - 1 - $i);
            $digit = $number2[$i];

            if(!isset($partialsList[$partialIndex][$number1 * $digit])) continue 2;
        }

        $total = $number1 * $number2;

        if($checkResults && !isset($resultList[$total])) continue;

        for($i = 0; $i < $size2; ++$i) {
            $partials[] = str_pad(($number1 * $number2[$i]) . str_repeat('0', $size2 - $i - 1), $outputSize, ' ', STR_PAD_LEFT);
        }

        echo str_pad($number1, $outputSize, ' ', STR_PAD_LEFT) . PHP_EOL;
        echo 'x' . str_pad($number2, $outputSize - 1, ' ', STR_PAD_LEFT) . PHP_EOL;
        echo str_repeat('-', $outputSize) . PHP_EOL;
        echo implode(PHP_EOL, array_reverse($partials)) . PHP_EOL;
        echo str_repeat('-', $outputSize) . PHP_EOL;
        echo str_pad($total, $outputSize, ' ', STR_PAD_LEFT) . PHP_EOL;

        break 2;
    }
}

error_log(microtime(1) - $start);
