<?php

fscanf(STDIN, "%d", $n);

$start = microtime(1);
$goal = $n >> 1;
$cols = array_fill(0, $n, [0, 0]);
$rows = array_fill(0, $n, [0, 0]);
$output = array_fill(0, $n, str_repeat(" ", $n));

for ($y = 0; $y < $n; ++$y) {
    foreach(str_split(str_replace(" ", "", trim(fgets(STDIN)))) as $x => $c) {
        $output[$y][$x] = $c;

        if($c !== "_") {
            $cols[$x][$c]++;
            $rows[$y][$c]++;
        } else $toFind[] = [$x, $y];
    }
}

error_log(var_export($output, 1));

while($toFind) {
    foreach($toFind as $index => [$x, $y]) {
        $value = null;

        if($cols[$x][0] == $goal) $value = 1; //We have already all the 0 in this col
        elseif($cols[$x][1] == $goal) $value = 0; //We have already all the 1 in this col
        elseif($rows[$y][0] == $goal) $value = 1; //We have already all the 0 in this row
        elseif($rows[$y][1] == $goal) $value = 0; //We have already all the 1 in this row
        elseif($x < $n - 2 && $output[$y][$x + 1] != '_' && $output[$y][$x + 1] == $output[$y][$x + 2]) $value = ($output[$y][$x + 1] + 1) % 2; //2 similar values on the right
        elseif($x > 1 && $output[$y][$x - 1] != '_' && $output[$y][$x - 1] == $output[$y][$x - 2]) $value = ($output[$y][$x - 1] + 1) % 2; //2 similar values on the left
        elseif($y < $n - 2 && $output[$y + 1][$x] != '_' && $output[$y + 1][$x] == $output[$y + 2][$x]) $value = ($output[$y + 1][$x] + 1) % 2; //2 similar values on the bottom
        elseif($y > 1 && $output[$y - 1][$x] != '_' && $output[$y - 1][$x] == $output[$y - 2][$x]) $value = ($output[$y - 1][$x] + 1) % 2; //2 similar values on the top
        elseif($x > 0 && $x < $n - 1 && $output[$y][$x - 1] != '_' && $output[$y][$x - 1] == $output[$y][$x + 1]) $value = ($output[$y][$x + 1] + 1) % 2; //2 similar values left & right
        elseif($y > 0 && $y < $n - 1 && $output[$y - 1][$x] != '_' && $output[$y - 1][$x] == $output[$y + 1][$x]) $value = ($output[$y + 1][$x] + 1) % 2; //2 similar values top & bottom

        if($value !== null) {
            $output[$y][$x] = $value;

            $cols[$x][$value]++;
            $rows[$y][$value]++;

            unset($toFind[$index]);
        }
    }
}


echo implode(PHP_EOL, array_map(function($line) {
    return implode(" ", str_split($line));
}, $output)) . PHP_EOL;

error_log(microtime(1) - $start);
