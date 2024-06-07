<?php

fscanf(STDIN, "%d", $L);
fscanf(STDIN, "%d", $N);

$output = array_fill(0, $L, 0);

for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%s %d", $pattern, $tempo);

    //Apply the pattern on each lines
    for($j = $tempo; $j <= $L; $j += $tempo) {
        $output[$j - 1] |= bindec(strtr($pattern, 'X', '1'));
    }
}

//Convert back in 'X' & '0' from binary
array_walk($output, function(&$row) {
    $row = str_pad(strtr(decbin($row), '1', 'X'), 4, '0', STR_PAD_LEFT);
});

echo implode("\n", array_reverse($output)) . PHP_EOL;
