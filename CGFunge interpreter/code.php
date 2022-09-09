<?php

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $code[] = rtrim(stream_get_line(STDIN, 30 + 1, "\n"));
}

error_log(var_export($code, true));

const MOVES = ["^" => [0, -1], "v" => [0, 1], "<" => [-1, 0], ">" => [1, 0]];
$direction = ">";
$stack = [];
$skip = false;
$stringMode = 0;
$x = 0;
$y = 0;

while(true) {
    $c = $code[$y][$x] ?? " ";

    if($skip) {
        $skip = false;
    } elseif(ctype_digit($c)) {
        $stack[] = $c;
    } elseif($stringMode && $c != '"') {
        $stack[] = ord($c);
    } elseif(in_array($c, ["+", "-", "*", "X"])) {
        $right = array_pop($stack);
        $left = array_pop($stack);

        switch($c) {
            case "+": array_push($stack, $left + $right); break;
            case "-": array_push($stack, $left - $right); break;
            case "*": array_push($stack, $left * $right); break;
            case "X": array_push($stack, $right, $left); break;
        }
    } elseif(in_array($c, ["<", ">", "^", "v"])) {
        $direction = $c;
    } else {
        switch($c) {
            case '"': $stringMode ^= 1; break;
            case "_": $direction = (array_pop($stack) == 0) ? ">" : "<"; break;
            case "|": $direction = (array_pop($stack) == 0) ? "v" : "^"; break;
            case "C": echo chr(array_pop($stack)); break;
            case "D": $stack[] = end($stack); break;
            case "E": break 2;
            case "I": echo array_pop($stack); break;
            case "P": array_pop($stack); break;
            case "S": $skip = true; break;
        }
    }

    [$mx, $my] = MOVES[$direction];
    $x += $mx;
    $y += $my;
}
?>
