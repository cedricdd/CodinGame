<?php

fscanf(STDIN, "%d %d", $width, $height);

$strokes = ['h' => [], 'v' => []];

for ($y = 0; $y < $height; ++$y) {
    $map[$y] = trim(fgets(STDIN));

    foreach(str_split($map[$y]) as $x => $c) {
        if($x > 0 && $c != $map[$y][$x - 1]) $strokes['v'][($x - 1) . "-" . $x . "-" . $y] = 1; 
        if($y > 0 && $c != $map[$y - 1][$x]) $strokes['h'][($y - 1) . "-" . $y . "-" . $x] = 1; 
    }
}

error_log(var_export($map, 1));

$count = 0;

foreach(['h', 'v'] as $direction) {
    while($strokes[$direction]) {
        [$a, $b, $c] = explode("-", array_key_first($strokes[$direction]));
    
        do {
            unset($strokes[$direction][$a . "-" . $b . "-" . $c]);
            $c++;
        } while(isset($strokes[$direction][$a . "-" . $b . "-" . $c]));
     
    
        ++$count;
    }
}

echo $count . PHP_EOL;
