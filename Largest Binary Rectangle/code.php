<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d %d", $width, $height);
for ($y = 0; $y < $height; $y++) {
    $map[] = str_replace(' ', '', stream_get_line(STDIN, $width * 2 + 1, "\n"));
}

error_log(var_export($map, true));

$bestScore = 0;

for ($y = 0; $y < $height; $y++) {
    //Get all the batch of "1" of the line
    preg_match_all("/1+/", $map[$y], $matches, PREG_OFFSET_CAPTURE);

    foreach($matches[0] as $match) {
        $length = strlen($match[0]);

        //We can't beat the current best score even if all lines are good
        if($length * $height <= $bestScore) continue;

        $score = $length;

        //Check the lines below
        for($y2 = $y + 1; $y2 < $height; ++$y2) {
            if(substr($map[$y2], $match[1], $length) === $match[0]) $score += $length;
            else break; 
        }

        //We can't beat the current best score even if all line at top are good
        if(($y * $length) + $score < $bestScore) continue;

        //Check the lines above
        for($y2 = $y - 1; $y2 >= 0; --$y2) {
            if(substr($map[$y2], $match[1], $length) === $match[0]) $score += $length;
            else break; 
        }

        if($bestScore < $score) $bestScore = $score;
    }
}

echo $bestScore . "\n";
?>
