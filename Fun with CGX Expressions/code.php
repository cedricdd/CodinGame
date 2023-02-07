<?php

function LCM(string $a, string $b): string {
    return bcdiv(bcmul($a, $b), GCD($a, $b));
}

function GCD(string $a, string $b): string {
    return $b ? GCD($b, bcmod($a, $b)) : $a;
}

function simplifyFractions(string $a, string $b): array {

    $modifier = 1;

    if(bccomp($a, 0) == -1) {
        $a = bcmul($a, "-1");
        $modifier *= -1;
    }
    if(bccomp($b, 0) == -1) {
        $b = bcmul($b, "-1");
        $modifier *= -1;
    }

    $gcd = GCD($a, $b);

    return [bcmul(bcdiv($a, $gcd), $modifier), bcdiv($b, $gcd)];
}

function subFractions(array $a, array $b): array {

    $divisor = LCM($a[1], $b[1]);
    $dividend = bcsub(bcmul($a[0], bcdiv($divisor, $a[1])), bcmul($b[0], bcdiv($divisor, $b[1])));

    return simplifyFractions($dividend, $divisor);
}

function addFractions(array $a, array $b): array {
    $divisor = LCM($a[1], $b[1]);
    $dividend = bcadd(bcmul($a[0], bcdiv($divisor, $a[1])), bcmul($b[0], bcdiv($divisor, $b[1])));

    return simplifyFractions($dividend, $divisor);
}

function divFractions(array $a, array $b): array {
    return simplifyFractions(bcmul($a[0], $b[1]), bcmul($a[1], $b[0]));
}

function mulFractions(array $a, array $b): array {
    return simplifyFractions(bcmul($a[0], $b[0]), bcmul($a[1], $b[1]));
}

//Return the list of variable => expression in the string
function parse(string $input): array {

    $name = "";
    $value = "";
    $readingName = 1;
    $readingValue = 0;
    $count = 0;
    $info = [];

    foreach(str_split($input . ";") as $c) {

        switch($c) {
            //Expression can have nested parantheses, we want the full expression for the variable
            case "(": ++$count; break;
            case ")": --$count; break;
            case "=":
                //We finished reading a variable name
                if($readingName == 1) {
                    $readingName = 0;
                    $readingValue = 1;
                    continue 2;
                }
            case ";":
                //We finished reading an expression
                if($count == 0) {
                    $readingValue = 0;
                    $readingName = 1;

                    $info[trim($name, "'")] = trim($value, "'");
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

    //Value is a constant
    if(is_numeric($value)) $result = [intval($value), 1];
    //Value is a varirable
    elseif(preg_match("/^[a-zA-Z0-9]*$/", $value)) {
        $result = getValue($variables[$value]);
    } //Value is an operation or a fraction
    else {
        $expression = parse(trim($value, ")("));

        //Operation +-*/
        if(count($expression) == 3) {

            $num1 = getValue($expression["num1"]);
            $num2 = getValue($expression["num2"]);
            
            switch($expression["operator"]) {
                case "+": $result = addFractions($num1, $num2); break;
                case "-": $result = subFractions($num1, $num2); break;
                case "/": $result = divFractions($num1, $num2); break;
                case "*": $result = mulFractions($num1, $num2); break;
            }
        } //Fraction
        else {
            $result = divFractions(getValue($expression["numerator"]), getValue($expression["denominator"]));
        }
    }

    return $result;
}

$CGX = "";

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++){
    $CGX .= trim(fgets(STDIN));
}

//Get the value 'result' & 'vars' if it exist
preg_match("/^\('result'=([^;]+)(?:;'vars'=\((.*)\))?\)$/", $CGX, $matches);

$variables = parse($matches[2] ?? "");

$result = getValue(trim($matches[1], "'"));

//Print as integer when possible othewise as fraction
echo ($result[1] == 1 ? $result[0] : ($result[0] . "/" . $result[1])) . PHP_EOL;
