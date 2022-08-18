<?php

//Split the word following the rules
function splitWord(string $word, int $spaceLeft): array {
    $size = strlen($word);
    $jumps = "";
    $stays = "";

    //Split the word into syllables
    preg_match_all("/[^aeiou]{0,1}[aeiou][^aeiou]{0,1}/i", strrev($word), $matches);

    //Remove syllables until it's small enough to fit on the line
    while(count($matches[0])) {
        $string = array_shift($matches[0]);

        $jumps .= $string;

        if(($size -= strlen($string)) < $spaceLeft) break;
    }

    $stays = implode($matches[0]); //The part that can fit on the line

    //Since consonants tend to belong to the next vowel we use the reverse to find the syllables, we need to reverse again
    if(strlen($stays) > 1) {
        $jumps = strrev($jumps);
        $stays = strrev($stays) . "-";
    } //We don't want 0 or 1 letter, we can't break up the word
    else {
        $jumps = $word;
        $stays = "";
    }

    return [$stays, $jumps];
}

fscanf(STDIN, "%d", $n);
$s = stream_get_line(STDIN, 500 + 1, "\n");

$lineIndex = 0;
$lineSize = 0;

foreach(explode(" ", $s) as $word) {
    $size = strlen($word);

    //The word can directly fit in the current line
    if($lineSize + $size <= $n) {
        $formatted[$lineIndex][] = $word;

        //Line is full
        if($lineSize + strlen($word) >= ($n - 1)) {
            ++$lineIndex;
            $lineSize = 0;
        } else {
            $lineSize += $size + 1;
        }
    } else {
        //We need to split the word (possible multiple time to fit on the line)
        while(true) {
            [$w1, $w2] = splitWord($word, $n - $lineSize);

            if(!empty($w1)) $formatted[$lineIndex][] = $w1;
            ++$lineIndex;
    
            //The rest after the split can fit into a line, no need to split again
            if(strlen($w2) <= $n) {
                $formatted[$lineIndex][] = $w2;
                $lineSize = strlen($w2) + 1;
                continue 2;
            } //Still too big, need to split again
            else {
                $word = $w2;
                $lineSize = 0;
            }
        }
    }
}

echo implode("\n", array_map(function($line) {
    return implode(" ", $line);
}, $formatted)) . PHP_EOL;
?>
