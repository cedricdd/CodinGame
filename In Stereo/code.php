<?php

fscanf(STDIN, "%d", $P);
$pattern = stream_get_line(STDIN, $P + 1, "\n");
fscanf(STDIN, "%d", $S);
$stock = stream_get_line(STDIN, $S + 1, "\n");
fscanf(STDIN, "%d %d", $H, $W);

$answer = array_fill(0, $H, str_repeat(" ", $W));

for ($y = 0; $y < $H; ++$y){

    //Reset info for each lines
    $index = 0;
    $depth = 0;
    $patternLine = $pattern;
    $stockLine = $stock;

    foreach(str_split(trim(fgets(STDIN))) as $x => $c) {

        $diff = $c - $depth;

        //Removing characters from pattern
        if($diff > 0) {
            $depth += $diff; //Depth increase
            for($i = 0; $i < $diff; ++$i) {
                $patternLine = substr_replace($patternLine, "", $index, 1); //Remove the character
                $index %= strlen($patternLine); //Update index position
            }
            
        }
        //Adding characters from stock
        elseif($diff < 0) {
            $diff = abs($diff);
            $depth -= $diff; //Depth decrease
            $patternLine = substr_replace($patternLine, substr($stockLine, 0, $diff), $index, 0); //Add to pattern at current location
            $stockLine = substr($stockLine, $diff); //Remove from stock
        }

        $answer[$y][$x] = $patternLine[$index];
        $index = ($index + 1) % strlen($patternLine); //Index position increase
    }
}

echo implode("\n", $answer) . PHP_EOL;
