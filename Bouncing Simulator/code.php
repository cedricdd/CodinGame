<?php

fscanf(STDIN, "%d", $w);
fscanf(STDIN, "%d", $h);
fscanf(STDIN, "%d", $n);

$output[] = str_repeat('#', $w + 2);

for($i = 0; $i < $h; ++$i) $output[] = '#' . str_repeat('0', $w) . '#';

$output[] = str_repeat('#', $w + 2);

$d = [1, 1];
$x = 1;
$y = 1;

while($n > 0) {
    $output[$y][$x] = strval(intval($output[$y][$x]) + 1);
    
    $x += $d[0];
    $y += $d[1];
    $hit = false;

    //Hitting the left wall
    if($x == 0) {
        $d[0] = 1;
        $x += 2;
        $hit = true;
    }

    //Hitting the right wall
    if($x > $w) {
        $d[0] = -1;
        $x -= 2;
        $hit = true;
    }
        
    //Hitting the top wall
    if($y == 0) {
        $d[1] = 1;
        $y += 2;
        $hit = true;
    }
        
    //Hitting the bottom wall
    if($y > $h) {
        $d[1] = -1;
        $y -= 2;
        $hit = true;
    }
    
    if($hit) --$n;
}

echo implode(PHP_EOL, array_map(function($line) {
    return str_replace('0', ' ', $line);
}, $output)) . PHP_EOL;
