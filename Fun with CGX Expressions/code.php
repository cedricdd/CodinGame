<?php

function GCD(int $a, int $b): int {
    while ($a != $b) {
        if ($a > $b) {
            $a -= $b;
        } else {
            $b -= $a;
        }
    }

    return $a;
}

function LCM(int $a, int $b): int {
    return $a * $b / GCD($a, $b);
}

function simplifyFractions(int $a, int $b): array {

    $modifier = 1;

    //Negative value
    if(($a < 0 && $b > 0) || ($a > 0 && $b < 0)) $modifier = -1;

    $a = abs($a);
    $b = abs($b);

    $gcd = GCD($a, $b);

    return [($a / $gcd) * $modifier, $b / $gcd];
}

function subFractions(array $a, array $b): array {

    $divisor = LCM($a[1], $b[1]);
    $dividend = ($a[0] * ($divisor / $a[1])) - ($b[0] * ($divisor / $b[1]));

    return simplifyFractions($dividend, $divisor);
}

function addFractions(array $a, array $b): array {
    $divisor = LCM($a[1], $b[1]);
    $dividend = ($a[0] * ($divisor / $a[1])) + ($b[0] * ($divisor / $b[1]));

    return simplifyFractions($dividend, $divisor);
}

function divFractions(array $a, array $b): array {
    return simplifyFractions($a[0] * $b[1], $a[1] * $b[0]);
}

function mulFractions(array $a, array $b): array {
    return simplifyFractions($a[0] * $b[0], $a[1] * $b[1]);
}

function parse(string $input): array {

    error_log("parsing $input");

    $name = "";
    $value = "";
    $readingName = 0;
    $readingValue = 0;
    $count = 0;
    $info = [];

    foreach(str_split($input . ";") as $c) {

        switch($c) {
            case "(": ++$count; break;
            case ")": --$count; break;
            case "'":
                if(empty($name)) $readingName = 1;
                elseif($readingName == 1) $readingName = 0;
                break;
            case ";":
                if($count == 0) {
                    $readingValue = 0;

                    $info[trim($name, "'")] = trim($value, "='");
                    [$name, $value] = ["", ""];
        
                    continue 2;
                }
        }

        if($readingName) $name .= $c;
        else $value .= $c;
    }

    return $info;
}

function getValue($value): array {
    global $variables;

    error_log("get value of $value");

    if(is_numeric($value)) {
        $result = [intval($value), 1];
    }

    elseif(preg_match("/^[a-zA-Z0-9]*$/", $value)) {
        $result = getValue($variables[$value]);
    } else {

        $expression = parse(trim($value, ")("));

        error_log(var_export($expression, true));

        if(count($expression) == 3) {

            $a = getValue($expression["num1"]);
            //error_log("a - " . $expression["num1"] . " => " . $a[0] . "/" . $a[1]);
            $b = getValue($expression["num2"]);
            //error_log("b - " . $expression["num2"] . " => " . $b[0] . "/" . $b[1]);
            
            switch($expression["operator"]) {
                case "+": $result = addFractions($a, $b); break;
                case "-": $result = subFractions($a, $b); break;
                case "/": $result = divFractions($a, $b); break;
                case "*": $result = mulFractions($a, $b); break;
            }
        } else {
            $result = divFractions(getValue($expression["numerator"]), getValue($expression["denominator"]));
        }
    }

    error_log("$value => " . $result[0] . "/" . $result[1]);
    return $result;
}

$start = microtime(1);

$CGX = "";

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++){
    $CGX .= trim(fgets(STDIN));
}

error_log(var_export($CGX, true));

//Get the value 'result' & 'vars' if it exist
preg_match("/^\('result'=([^;]+)(?:;'vars'=\((.*)\))?\)$/", $CGX, $matches);

//error_log(var_export($matches, true));

$variables = parse($matches[2] ?? "");

error_log("varirables:");
error_log(var_export($variables, true));

$result = getValue(trim($matches[1], "'"));

echo ($result[1] == 1 ? $result[0] : ($result[0] . "/" . $result[1])) . PHP_EOL;

error_log(microtime(1) - $start);
