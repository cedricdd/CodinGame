<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/
fscanf(STDIN, "%d %d", $H, $W);
for ($y = 0; $y < $H; $y++) {
    foreach(str_split(stream_get_line(STDIN, 256 + 1, "\n")) as $x => $character) {
        if($character == "G") {
            //Chances of not catching monkeypox 
            $odds[] = 1 - min($x, $y) / ($x * $x + $y * $y + 1);
        }
    }
}

//Order by probability to NOT catch it
rsort($odds);

$total = 1.0;
for($i = 0; $i < count($odds); ++$i) {
    $total *= $odds[$i];

    //We don't want our chances of not catching it to go below 60%
    if($total < 0.6) break;
}

echo $i;
?>
