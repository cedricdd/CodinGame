<?php

fscanf(STDIN, "%d %d", $h, $w);
fscanf(STDIN, "%d", $nb);

$grid1 = array_fill(0, $h, str_repeat('.', $w));
$grid2 = array_fill(0, $w, str_repeat('.', $h));

for ($y = 0; $y < $h; ++$y) {
    foreach(str_split(trim(fgets(STDIN))) as $x => $c) {
        $grid1[$y][$x] = $c;
        $grid2[$x][$y] = $c;
    }
}

error_log(var_export($grid1, 1));
error_log(var_export($grid2, 1));

$corner = [];

for($i = 1; $i <= $nb; ++$i) {
    for ($x = 0; $x < $w; ++$x) {
        preg_match("/[$i]{2,}/", $grid2[$x], $match);

        if(isset($match[0])) $sideH[$i][] = $x;
    }

    for ($y = 0; $y < $h; ++$y) {
        preg_match("/[$i]{2,}/", $grid1[$y], $match);

        if(isset($match[0])) $sideV[$i][] = $y;
    }
}

error_log(var_export($sideH, 1));
error_log(var_export($sideV, 1));

// echo implode(PHP_EOL, array_reverse($output)) . PHP_EOL;
