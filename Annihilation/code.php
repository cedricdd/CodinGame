<?php
fscanf(STDIN, "%d %d", $H, $W);
for ($y = 0; $y < $H; $y++){
    foreach(str_split(stream_get_line(STDIN, 256 + 1, "\n")) as $x => $character) {
        if($character != '.') $arrows[$x . " " . $y] = $character;
    }
}

$step = 0;

while(count($arrows)) {
    ++$step;
    $postions = [];

    foreach($arrows as $position => $direction) {
        list($x, $y) = explode(" ", $position);

        switch($direction) {
            case 'v':
                $y = ($y + $H + 1) % $H;
                break;
            case '^':
                $y = ($y + $H - 1) % $H;
                break;
            case '>':
                $x = ($x + $W + 1) % $W;
                break;
            case '<':
                $x = ($x + $W - 1) % $W;
                break;
        }

        //The new position of the arrow
        $postions[$x . " " . $y][] = $direction;
    }

    //We reset the arrow array and only keep the ones that are alone
    $arrows = [];

    foreach($postions as $position => $arrow) {
        if(count($arrow) > 1) continue;

        $arrows[$position] = array_pop($arrow);
    }
}

echo $step . "\n";
?>
