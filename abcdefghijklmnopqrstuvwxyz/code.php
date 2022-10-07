<?php

const CARDINALS = [[1, 0], [-1, 0], [0, 1], [0, -1]]; 
$alphabet = range("a", "z");

fscanf(STDIN, "%d", $n);
for ($y = 0; $y < $n; ++$y) {
    fscanf(STDIN, "%s", $line);

    preg_match_all("/a/", $line, $matches, PREG_OFFSET_CAPTURE);

    foreach($matches[0] as [, $x]) $positionsA[] = [$x, $y];

    $grid[] = $line;
}

foreach($positionsA as [$xa, $ya]) {

    $toCheck = [[$xa, $ya, 0, []]];

    while(count($toCheck)) {
        [$x, $y, $i, $list] = array_pop($toCheck); 

        //We have linked all the letters
        if($i == 26) {
            $solution = $list;
            break;
        }

        if($grid[$y][$x] != $alphabet[$i]) continue; //Current position is not the next letter in the chain
        else $list[] = [$x, $y];

        foreach(CARDINALS as [$xm, $ym]) {
            $xu = $x + $xm;
            $yu = $y + $ym;

            if($xu >= 0 && $xu < $n && $yu >= 0 && $yu < $n) $toCheck[] = [$xu, $yu, $i + 1, $list];
        }
    }
}

$output = array_fill(0, $n, str_repeat("-", $n));
//Place the letters we used in the output 
foreach($solution as $i=> [$x, $y]) $output[$y][$x] = $alphabet[$i];

echo implode("\n", $output) . PHP_EOL;
?>
