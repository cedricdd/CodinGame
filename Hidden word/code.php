<?php

function getRegex(string $word, int $w): array {
    $reverse = strrev($word);
    $split = str_split($word);
    $splitReverse = str_split($reverse);

    return [
        ["/" . $word . "|" . $reverse . "/", 1], //Vertical
        ["/" . implode(".{" . ($w + 1) . "}", $split) . "|" . implode(".{" . ($w + 1) . "}", $splitReverse) . "/", $w + 2], //Horizontal
        ["/" . implode(".{" . ($w + 2) . "}", $split) . "/", $w + 3], //Diagonal top to bottom
        ["/" . implode(".{" . $w . "}", $splitReverse) . "/", $w + 1], //Diagonal bottom to top
    ];
}

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%s", $words[]);
}

fscanf(STDIN, "%d %d", $h, $w);

$gridString = "";
for ($i = 0; $i < $h; $i++) {
    fscanf(STDIN, "%s", $line);
    $gridString .= "#" . $line . "#";
    $grid[] = str_split($line);
}

$gridString = str_repeat("#", $w + 2) . $gridString . str_repeat("#", $w + 2);

foreach($words as $word) {
    foreach(getRegex($word, $w) as [$regex, $move]) {
        //Find the word by using all the possible placements
        if(preg_match($regex, $gridString, $match, PREG_OFFSET_CAPTURE)) {
            $position = $match[0][1];
    
            //Struck all the letter of the word
            for($i = 0; $i < strlen($word); ++$i) {
                $y = intdiv($position, ($w + 2)) - 1;
                $x = ($position % ($w + 2)) - 1;
    
                unset($grid[$y][$x]);
                $position += $move;
            }
    
            continue 2; //Words are only present once
        }
    }
}

//Print out the unstruck characters
foreach($grid as $line) {
    foreach($line as $character) {
        echo $character;
    }
}
?>
