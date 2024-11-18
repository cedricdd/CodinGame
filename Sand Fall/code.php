<?php

function addSand(int $x, string $letter, bool $lowercase) {
    global $box, $cols, $W, $H;

    //It can't go any lower
    if($cols[$x] == $H - 1) {
        $box[$H - 1][$x] = $letter;
        $cols[$x]--;
    } else {
        //Right then left
        if($lowercase) {
            if($x < $W - 1 && $box[$cols[$x] + 1][$x + 1] == " ") return addSand($x + 1, $letter, $lowercase);
            if($x > 0 && $box[$cols[$x] + 1][$x - 1] == " ") return addSand($x - 1, $letter, $lowercase);
        } //Left then right 
        else {
            if($x > 0 && $box[$cols[$x] + 1][$x - 1] == " ") return addSand($x - 1, $letter, $lowercase);
            if($x < $W - 1 && $box[$cols[$x] + 1][$x + 1] == " ") return addSand($x + 1, $letter, $lowercase);
        }

    if($cols[$x] < 0) exit("OVERFLOW"); //Box is overflowing

    //Sand can move diagonally
    $box[$cols[$x]][$x] = $letter;
    $cols[$x]--;
    }
}

fscanf(STDIN, "%d %d", $W, $H);

$box = array_fill(0, $H, str_repeat(" ", $W));
$cols = array_fill(0, $W, $H - 1);

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%s %d", $letter, $x);

    addSand($x, $letter, ord($letter) > 96);
}

echo implode("\n", array_map(function($line) {
    return '|' . $line . '|';
}, $box)) . PHP_EOL;

echo '+' . str_repeat('-', $W) . '+' . PHP_EOL;
