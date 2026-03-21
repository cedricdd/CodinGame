<?php

$pieces = array_flip(str_split(trim(fgets(STDIN))));

for ($y = 0; $y < 8; ++$y) {
    foreach(str_split(trim(fgets(STDIN))) as $x => $c) {
        if(!isset($pieces[$c]) && !isset($pieces[strtoupper($c)])) $c = '.'; //Make sure that evertyhing that's not a piece is represented by a '.'

        $board1[$y][$x] = $c;
        $places[$c][] = [$x, $y]; //Save everywhere this piece is located
    }
}

for ($y = 0; $y < 8; ++$y) {
    foreach(str_split(trim(fgets(STDIN))) as $x => $c) {
        if(!isset($pieces[$c]) && !isset($pieces[strtoupper($c)])) $c = '.'; //Make sure that evertyhing that's not a piece is represented by a '.'

        if($c != '.' && $board1[$y][$x] != $c) $moved = [$x, $y, $c]; //This piece has moved

        $board2[$y][$x] = $c;
    }
}

//Search from the starting position of the piece that moved
foreach($places[$moved[2]] as [$x, $y]) {
    //Found the starting position
    if($board2[$y][$x] == '.') {
        echo chr($x + 97) . (8 - $y) . ($board1[$moved[1]][$moved[0]] == '.' ? "-" : "x") . chr($moved[0] + 97) . (8 - $moved[1]) . PHP_EOL;

        $xm = abs($x - $moved[0]);
        $ym = abs($y - $moved[1]);

        echo ((($xm == 2 && $ym == 1) || ($xm == 1 && $ym == 2)) ? "Knight" : "Other") . PHP_EOL;
    }
}
