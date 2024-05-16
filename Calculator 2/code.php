<?php

function solve(string $expr): string {
    $operations = [];
    $result = "";
    $count = 0;
    $subExpr = "";

    error_log("working on $expr");

    foreach(str_split($expr) as $c) {
        if($c == "(") ++$count;
        elseif($c == ")") {
            --$count;

            if($count == 0) {
                $result .= solve(substr($subExpr, 1));
                $subExpr = "";
                continue;
            }
        }

        if($count > 0) $subExpr .= $c;
        elseif(!ctype_digit($c)) $operations[] = $c;
    }

    error_log(var_export($operations, true));

    while(count($operations)) {
        if($operations[0] == '*' || $operations[0] == '/' || !isset($operations[1])) $result .= array_shift($operations);
        else {
            if($operations[1] == '+' || $operations[1] == '-') $result .= array_shift($operations);
            else $result .= array_splice($operations, 1, 1)[0];
        }
    }

    error_log("returning -- " . $result);

    return $result;
}

$expr = trim(fgets(STDIN));

error_log($expr);

echo eval("return (" . $expr . ");") . PHP_EOL;
echo solve($expr) . PHP_EOL;
