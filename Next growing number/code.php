<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

$n = (string)(stream_get_line(STDIN, 32 + 1, "\n") + 1);

for($i = 1; $i < strlen($n); ++$i) {
    if($n[$i] < $n[$i-1]) { //we found the first issue, we just repeat the previous number until the end
        $n = substr($n, 0, $i) . str_repeat($n[$i-1], strlen($n) - $i);
        break;
    }
}

echo $n . "\n";
?>
