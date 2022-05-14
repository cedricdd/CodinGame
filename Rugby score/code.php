<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $n);

for($try = 0; $try <= floor($n/5); $try++) {
    for($tr = 0; $tr <= min(floor($n/7), $try); $tr++) {
        $score = $try * 5 + $tr * 2;
        if($score <= $n && ($n - $score) % 3 == 0) echo $try . " " . $tr . " "  . (($n - $score) / 3) . "\n";
    }
}
?>
