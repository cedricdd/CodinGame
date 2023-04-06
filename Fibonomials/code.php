<?php

//Get the polynomial based on coefs
function getCoefs(array $list): string {
    $polynomial = [];

    foreach($list as $i => $v) {
        if($v == 0 && $i > 0) continue;

        $polynomial[] = $v . (($i != 0) ? "*(x)" . (($i > 1) ? "**$i": "") : "");
    }

    //Clean a bit before returning
    return preg_replace("/\b0[+-]\b/", "", str_replace("+-", "-", str_replace("-1*", "-", implode("+", $polynomial))));
}

//Get the polynomial based on roots
function getRoots(array $list): string {
    $polynomial = [];

    foreach($list as $i => $v) {
        $polynomial[] = "(x" . (($v != 0) ? (($v > 0) ? ("-" . $v) : ("+" . ($v * -1))) : "") . ")";
    }

    return implode("*", $polynomial);
}

//Evaluate the string and print the result
function printValue(string $expression, int $x) {
    $value = eval("return " . str_replace("x", $x, $expression) . ";");

    if(abs($value) > 1000000000000) echo sprintf("%.6E", $value) . PHP_EOL; //scientific notation
    else echo $value . PHP_EOL;
}

if(trim(fgets(STDIN)) == "COEFS") {
    $P0 = getCoefs(explode(" ", trim(fgets(STDIN))));
    $P1 = getCoefs(explode(" ", trim(fgets(STDIN))));
} else {
    $P0 = getRoots(explode(" ", trim(fgets(STDIN))));
    $P1 = getRoots(explode(" ", trim(fgets(STDIN))));
}

fscanf(STDIN, "%d", $x);

printValue($P0, $x);
printValue($P1, $x);

fscanf(STDIN, "%d", $n);

for($i = 2; $i < $n; ++$i) {
    
    $P2 = str_replace("x", $P0, $P1) . "+" . str_replace("x", $P1, $P0);
    //We can reduce, there are no x
    if(strpos($P2, "x") === false) $P2 = eval("return $P2;");

    printValue($P2, $x);

    [$P0, $P1] = [$P1, $P2];
}
