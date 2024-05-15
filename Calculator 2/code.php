<?php

const WEIGHTS = ["+" => 0, "-" => 0, "*" => 1, "/" => 1];

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

    usort($operations, function($a, $b) {
        return WEIGHTS[$b] <=> WEIGHTS[$a];
    });

    error_log("returning -- " . ($result . implode("", $operations)));

    return $result . implode("", $operations);
}

$expr = trim(fgets(STDIN));

error_log($expr);

echo eval("return (" . $expr . ");") . PHP_EOL;
echo solve($expr) . PHP_EOL;
