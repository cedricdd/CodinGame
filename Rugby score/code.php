<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $n);

for($try = 0; $try <= floor($n/5); $try++) {
    for($tr = 0; $tr <= $try; $tr++) {
        $missing = $n - ($try * 5 + $tr * 2);
        if($missing >= 0 && $missing % 3 == 0) echo $try . " " . $tr . " "  . ($missing / 3) . "\n";
    }
}
?>
