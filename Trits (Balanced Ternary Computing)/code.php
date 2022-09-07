<?php

//Convert balanced ternary to decimal
function terDec(string $N): int {
    $dec = 0;
    $N = strrev($N);

    for($i = 0; $i < strlen($N); ++$i) {
        $dec += ($N[$i] == "T" ? -1 : intval($N[$i])) * (3 ** $i);
    }

    return $dec;
}

//Convert decimal to balanced ternary
function decTer(int $N): string {
    if($N < 0) {
        $negativeNumber = 1;
        $N = abs($N);
    }
    
    $ternary = [];
    
    //First get the unbalanced value
    while($N != 0) {
        $ternary[] = $N % 3;
        $N = intval($N / 3);
    }
    
    //Convert unbalanced to balanced
    for($i = 0; $i < count($ternary); ++$i) {
        if($ternary[$i] >= 2) {
            $ternary[$i] = ($ternary[$i] == 2) ? "T" : 0;
            $ternary[$i + 1] = ($ternary[$i + 1] ?? 0) + 1;
        }
    }
    
    //Negative number, we need to switch 1 & T
    if(isset($negativeNumber)) return strtr(strrev(implode($ternary)), "1T", "T1");
    else return strrev(implode($ternary));
}

$left = stream_get_line(STDIN, 10 + 1, "\n");
$op = stream_get_line(STDIN, 5 + 1, "\n");
$right = stream_get_line(STDIN, 10 + 1, "\n");

$leftDec = terDec($left);
$rightDec = terDec($right);

switch($op) {
    case "+":   echo decTer($leftDec + $rightDec) . PHP_EOL;         break;
    case "-":   echo decTer($leftDec - $rightDec) . PHP_EOL;         break;
    case "*":   echo decTer($leftDec * $rightDec) . PHP_EOL;         break;
    case ">>":  echo substr($left, 0, -$rightDec) ?: 0 . PHP_EOL;    break;
    case "<<":  echo $left . str_repeat("0", $rightDec) . PHP_EOL;   break;
}
?>
