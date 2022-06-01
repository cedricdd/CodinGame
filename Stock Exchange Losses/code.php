<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $n);
$inputs = explode(" ", fgets(STDIN));
for ($i = 0; $i < $n; $i++) {
    $graph[] = intval($inputs[$i]);
}

error_log(var_export($graph, true));

$loss = 0;
$start = 0;

for($i=0; $i<$n; ++$i) {
    if($graph[$i] >= $start) {
        $start = $graph[$i];
        continue;
    }
    $loss = min($loss, $graph[$i] - $start);
}

echo($loss . "\n");
?>
