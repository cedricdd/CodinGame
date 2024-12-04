<?php

$letters = [];

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    foreach(str_split(trim(fgets(STDIN))) as $j => $c) {
        $letters[$j][$c] = ($letters[$j][$c] ?? 0) + 1;
    }
}

//We simply use the most used letter for each positions
foreach($letters as $list) {
    asort($list);

    echo array_key_last($list);
}
