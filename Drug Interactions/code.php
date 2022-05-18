<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

$time_start = microtime(true);

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $drug = strtolower(stream_get_line(STDIN, 1024 + 1, "\n"));
    $drugs[] = array_count_values(str_split($drug));
}

usort($drugs, function($a, $b) {
    return array_sum($b) <=> array_sum($a);
});

//We compare each drug to each other to know if they are compatible
$compatibility = [];
for($i = 0; $i <= $n; ++$i) {
    for($j = $i + 1; $j < $n; ++$j) {
        $similarity = 0;
        foreach($drugs[$i] as $letter => $count) $similarity += min($drugs[$j][$letter] ?? 0, $count);

        $compatibility[$i][$j] = ($similarity < 3);
    }
}

$best = 0;

function calculate($list, $step) {

    global $n, $compatibility, $best;

    //No drugs left to add
    if($step >= $n) {
        $best = max(count($list), $best);
        return;
    } 

    //We can't find a better solution than the current best
    if((count($list) + ($n - $step)) < $best) return;

    //Can we add the next drug to the list
    foreach($list as $drugID) {
        if(!$compatibility[$drugID][$step]) return calculate($list, $step + 1);
    }
    
    return max(calculate(array_merge($list, [$step]), $step + 1), calculate($list, $step + 1));
}

calculate([], 0);
echo $best . "\n";
?>
