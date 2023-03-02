<?php

function getRegex(string $word): array {
    global $size;

    $reverse = strrev($word);
    $split = str_split($word);
    $splitReverse = str_split($reverse);

    return [
        ["/" . $word . "|" . $reverse . "/", 1], //Vertical
        ["/" . implode(".{" . ($size + 1) . "}", $split) . "|" . implode(".{" . ($size + 1) . "}", $splitReverse) . "/", $size + 2], //Horizontal
        ["/" . implode(".{" . ($size + 2) . "}", $split) . "|" . implode(".{" . ($size + 2) . "}", $splitReverse) . "/", $size + 3], //Diagonal top to bottom
        ["/" . implode(".{" . $size . "}", $split) . "|" . implode(".{" . $size . "}", $splitReverse) . "/", $size + 1], //Diagonal bottom to top
    ];
}
fscanf(STDIN, "%d", $size);

$gridString = "";
for ($i = 0; $i < $size; $i++) {
    $gridString .= "#" . trim(fgets(STDIN)) . "#";
}

$gridString = str_repeat("#", $size + 2) . $gridString . str_repeat("#", $size + 2);
$gridResult = array_fill(0, $size, str_repeat(" ", $size));

foreach(array_map("strtoupper", explode(" ", trim(fgets(STDIN)))) as $word) {

    foreach(getRegex($word) as [$regex, $move]) {
        //Find the word by using all the possible placements
        if(preg_match($regex, $gridString, $match, PREG_OFFSET_CAPTURE)) {
            $position = $match[0][1];

            //Struck all the letter of the word
            for($i = 0; $i < strlen($word); ++$i) {
                $gridResult[intdiv($position, $size + 2) - 1][($position % ($size + 2)) - 1] = $gridString[$position];
                $position += $move;
            }
    
            continue 2; //Words are only present once
        }
    }
}

echo implode("\n", $gridResult) . PHP_EOL;
