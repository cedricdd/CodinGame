<?php

fscanf(STDIN, "%d %d", $w, $h);

for ($y = 0; $y < $h; $y++) {
    foreach(str_split(trim(fgets(STDIN))) as $x => $c) {
        if($c == '*') $shape[] = [$x, $y];
    }
}

fscanf(STDIN, "%d %d", $pw, $ph);

$firstLine = null; //First line with an '*'
$best = [0, 0, 0];

for ($i = 0; $i < $ph; $i++) {
    $line = trim(fgets(STDIN));

    if($firstLine === null && strpos($line, '*') !== false) $firstLine = $i;

    $playfield[] = $line;
}

for($x = 0; $x <= $pw - $w; ++$x) {
    $playfieldWithPiece = $playfield;

    //Find where the piece would land if top left would be at position '$x"
    for($y = max(0, $firstLine - $h + 1); $y < $ph - $h + 1; ++$y) {
        $playfield2 = $playfield;

        foreach($shape as [$xs, $ys]) {
            if($playfield[$y + $ys][$x + $xs] == '*') break 2; //Shape can't go there
            else $playfield2[$y + $ys][$x + $xs] = '*';
        }

        $playfieldWithPiece = $playfield2;
    }

    if($playfield == $playfieldWithPiece) continue; //Piece can't go anywhere

    //Count how many lines would be removed
    $count = 0;

    foreach($playfieldWithPiece as $line) {
        if(strpos($line, '.') === false) ++$count;
    }

    if($count > $best[0]) $best = [$count, $x, $ph - $y];
}

echo $best[1] . " " . $best[2] . PHP_EOL . $best[0] . PHP_EOL;
