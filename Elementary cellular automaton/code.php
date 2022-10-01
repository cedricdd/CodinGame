<?php

fscanf(STDIN, "%d", $R);

$keys = ["111", "110", "101", "100", "011", "010", "001", "000"];
$rules = array_combine($keys, str_split(str_pad(decbin($R), 8, 0, STR_PAD_LEFT)));

fscanf(STDIN, "%d", $N);

$pattern = strtr(trim(fgets(STDIN)), ".@", "01");
$size = strlen($pattern);

for($l = 0; $l < $N; ++$l) {

    $updatedPattern = "";

    for($i = 0; $i < $size; ++$i) {
        $updatedPattern .= $rules[$pattern[($i - 1) % $size] . $pattern[$i] . $pattern[($i + 1) % $size]];
    }

    echo strtr($pattern, "01", ".@") . PHP_EOL;
    $pattern = $updatedPattern;
}
?>
