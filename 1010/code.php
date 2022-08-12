<?php

//Flip an array diagonally 
function flipDiagonally($arr) {
    $out = array();
    foreach ($arr as $key => $subarr) {
        foreach (str_split($subarr) as $subkey => $subvalue) {
            $out[$subkey] = ($out[$subkey] ?? "") . $subvalue;
        }
    }
    return $out;
}

fscanf(STDIN, "%d", $W);
fscanf(STDIN, "%d", $H);

$s = microtime(true);

$line = "";
for ($i = 0; $i < $H; $i++) {
    //Use 0 for empty and 1 for full for convenience
    //Add an extra 1 at the end of each lines to delimit each lines for the regex
    $line .= strtr(stream_get_line(STDIN, $W + 1, "\n"), ".#", "01") . "1"; 
}

//Find all the position we can add the 2x2
preg_match_all("/(?<=00)(?=.{" . ($W - 1) . "}00)/", $line, $matches, PREG_OFFSET_CAPTURE);

$ans = 0;

if(count($matches[0])) {
    //Split the line back into grid & remove the extra delimiters we don't need anymore
    $grid = array_map(function($line) {
        return substr($line, 0, -1);
    }, str_split($line, $W + 1));
    $gridFlipped = flipDiagonally($grid);

    //Test all the positions
    foreach($matches[0] as [, $position]) {
        $position -= 2; //The position given is after the first half of the block
        $x = $position % ($W + 1);
        $y = intdiv($position, $W + 1);

        $complete = 0;
        //We use array_sum to check if the 2 blocl cells were the only ones missing in both rows & cols
        if(array_sum(str_split($grid[$y])) == ($W - 2)) ++$complete;
        if(array_sum(str_split($grid[$y + 1])) == ($W - 2)) ++$complete;
        if(array_sum(str_split($gridFlipped[$x])) == ($H - 2)) ++$complete;
        if(array_sum(str_split($gridFlipped[$x + 1])) == ($H - 2)) ++$complete;

        if($complete > $ans) $ans = $complete;
        if($ans == 4) break; //Can't be better than 4
    }
}

echo $ans . PHP_EOL;
?>
