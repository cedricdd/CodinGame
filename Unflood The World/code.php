<?php

const CARDINALS = [[1, 0], [-1, 0], [0, 1], [0, -1]]; 

fscanf(STDIN, "%d %d", $W, $H);
for ($y = 0; $y < $H; ++$y) {
    $map[$y] = explode(" ", trim(fgets(STDIN)));

    foreach($map[$y] as $x => $value) {
        $cells[$value][] = [$x, $y];
    }
}

//Sort cells by height
ksort($cells);

error_log(var_export(array_map(function($line) {
    return implode(" ", $line);
}, $map), true));

$checked = [];
$drains = 0;

foreach($cells as $value => $list) {
    foreach($list as [$x, $y]) {
        //This square is already "linked" to a drain
        if(isset($checked[$y][$x])) continue;

        //We are adding a drain at the current position, find all the cells that are "linked" to it
        $toCheck = [[$x, $y, $value]];

        while(count($toCheck)) {
            [$x, $y, $v] = array_pop($toCheck);

            if(isset($checked[$y][$x])) continue;
            else $checked[$y][$x] = 1;

            foreach(CARDINALS as [$xm, $ym]) {
                $xu = $x + $xm;
                $yu = $y + $ym;

                //We want to go to all the cells that have an higher or the same height
                if($xu >= 0 && $xu < $W && $yu >= 0 && $yu < $H && $map[$yu][$xu] >= $v) $toCheck[] = [$xu, $yu, $map[$yu][$xu]];
            }
        }

        ++$drains;
    }
}

echo $drains . PHP_EOL;
?>
