<?php

const MOVES = ["00" => [-1, -1], "01" => [1, -1], "10" => [-1, 1], "11" => [1, 1]];
const SYMBOLS = [" ", ".", "o", "+", "=", "*", "B", "O", "X", "@", "%", "&", "#", "/", "^"];

$answer = [
    "+---[CODINGAME]---+",
    "|                 |",
    "|                 |",
    "|                 |",
    "|                 |",
    "|                 |",
    "|                 |",
    "|                 |",
    "|                 |",
    "|                 |",
    "+-----------------+",
];

$x = 9;
$y = 5;
$visited = [];

foreach(explode(":", trim(fgets(STDIN))) as $hexa) {
    $binary = str_pad(base_convert($hexa, 16, 2), 8, '0', STR_PAD_LEFT);

    foreach(array_reverse(str_split($binary, 2)) as $direction) {
        [$xm, $ym] = MOVES[$direction];

        $x = min(17, max(1, $x + $xm));
        $y = min(9, max(1, $y + $ym));
        
        $visited[$y][$x] = ($visited[$y][$x] ?? 0) + 1;
    }
}

//Add the symbols to the answer
foreach($visited as $y2 => $line) {
    foreach($line as $x2 => $count) {
        $answer[$y2][$x2] = SYMBOLS[$count % 15];
    }
}

//Add starting & end positions
$answer[5][9] = "S";
$answer[$y][$x] = "E"; 

echo implode("\n", $answer) . PHP_EOL;
