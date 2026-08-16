<?php

fscanf(STDIN, "%d", $h);
fscanf(STDIN, "%d", $w);
fscanf(STDIN, "%d", $n);

$rotations = explode(" ", fgets(STDIN));

$ch = "";
$fc = "";

for ($i = 0; $i < $h; $i++) {
    $row = stream_get_line(STDIN, $w + 1, "\n");

    if($i == $h >> 1) $ch = $row;
    $fc .= $row[$w >> 1];
}

$chOriginal = $ch;

//Make sure the are the same len
$l = max($w, $h);
if($w < $h) $ch = str_pad($ch, $l, " ", STR_PAD_BOTH);
if($h < $w) $fc = str_pad($fc, $l, " ", STR_PAD_BOTH);

$overlap1 = "";
$overlap3 = "";

//No matter the number of rotation there's only two possible overlap, (90° & 180°)
for($i = 0, $j = $l - 1; $i < $l; ++$i, --$j) {
    if($ch[$i] === $fc[$i]) $overlap3 .= $ch[$i];
    elseif($ch[$i] === ' ') $overlap3 .= $fc[$i];
    elseif($fc[$i] === ' ') $overlap3 .= $ch[$i];
    else $overlap3 .= ' ';

    if($ch[$i] === $fc[$j]) $overlap1 .= $ch[$i];
    elseif($ch[$i] === ' ') $overlap1 .= $fc[$j];
    elseif($fc[$j] === ' ') $overlap1 .= $ch[$i];
    else $overlap1 .= ' ';
}

$current = 0;

foreach($rotations as $rotation) {
    $rotation = intval($rotation) % 4;
    $current = ($current + $rotation + 4) % 4;

    switch($current) {
        case 0:
        case 2: //It's vertical, just output the center horizontal
            echo $chOriginal . PHP_EOL;
            break;
        case 1:
        case 3: //It's horizontal, ouptut the overlapping
            echo ${"overlap" . $current} . PHP_EOL;
            break;
        default: throw exception("Invalid Value");
    }
}
