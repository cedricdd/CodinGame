<?php

$toCharacters = array_merge(range(0, 9), range('A', 'Z'));
$toValues = array_flip($toCharacters);

fscanf(STDIN, "%d", $h);
fscanf(STDIN, "%d", $w);

$output = array_fill(0, $h, array_fill(0, $w, 0));

for ($y = 0; $y < $h; $y++) {
    foreach(str_split(trim(fgets(STDIN))) as $x => $c) {
        if($c !== '.') {
            $v = $toValues[$c];

            for($y2 = max(0, $y - $v); $y2 < min($y + $v, $h); ++$y2) {
                for($x2 = max(0, $x - $v); $x2 < min($x + $v, $w); ++$x2) {
                    $output[$y2][$x2] += max(0, $v - round(sqrt((($x - $x2) ** 2) + (($y - $y2) ** 2))));
                    $output[$y2][$x2] = min($output[$y2][$x2], 35);
                }
            }
        }
    }
}

foreach($output as $values) {
    $line = "";

    for($i = 0; $i < $w; ++$i) {
        $line .= $toCharacters[$values[$i]];
    }

    echo $line . PHP_EOL;
}
