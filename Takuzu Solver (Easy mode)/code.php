<?php

$start = microtime(1);

fscanf(STDIN, "%d", $n);

$cols = array_fill(0, $n, [0, 0]);
$rows = array_fill(0, $n, [0, 0]);

for ($y = 0; $y < $n; ++$y) {
    $grid[$y] = trim(fgets(STDIN));

    foreach(str_split($grid[$y]) as $x => $c) {
        if($c == '.') $positions[] = [$x, $y];
        else {
            $cols[$x][$c]++;
            $rows[$y][$c]++;
        } 
    }
}

while($positions) {
    foreach($positions as $i => [$x, $y]) {
        $v = null;
    
        if($cols[$x][0] == $n >> 1) $v = 1;
        if($cols[$x][1] == $n >> 1) $v = 0;
        if($rows[$y][0] == $n >> 1) $v = 1;
        if($rows[$y][1] == $n >> 1) $v = 0;
        if($x > 0 && $x < $n - 1 && $grid[$y][$x - 1] == $grid[$y][$x + 1]) {
            if($grid[$y][$x - 1] == '1') $v = 0;
            if($grid[$y][$x - 1] == '0') $v = 1;
        }
        if($x > 1 && $grid[$y][$x - 2] == $grid[$y][$x - 1]) {
            if($grid[$y][$x - 1] == '1') $v = 0;
            if($grid[$y][$x - 1] == '0') $v = 1;
        }
        if($x < $n - 2 && $grid[$y][$x + 1] == $grid[$y][$x + 2]) {
            if($grid[$y][$x + 1] == '1') $v = 0;
            if($grid[$y][$x + 1] == '0') $v = 1;
        }
        if($y > 0 && $y < $n - 1 && $grid[$y - 1][$x] == $grid[$y + 1][$x]) {
            if($grid[$y - 1][$x] == '1') $v = 0;
            if($grid[$y + 1][$x] == '0') $v = 1;
        }
        if($y > 1 && $grid[$y - 2][$x] == $grid[$y - 1][$x]) {
            if($grid[$y - 1][$x] == '1') $v = 0;
            if($grid[$y - 1][$x] == '0') $v = 1;
        }
        if($y < $n - 2 && $grid[$y + 1][$x] == $grid[$y + 2][$x]) {
            if($grid[$y + 1][$x] == '1') $v = 0;
            if($grid[$y + 1][$x] == '0') $v = 1;
        }
    
        if($v !== null) {
            $grid[$y][$x] = $v;
    
            $cols[$x][$v]++;
            $rows[$y][$v]++;
    
            unset($positions[$i]);
        }
    }
}

echo implode(PHP_EOL, $grid) . PHP_EOL;
error_log(microtime(1) - $start);
