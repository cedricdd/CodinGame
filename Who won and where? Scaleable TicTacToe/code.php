<?php

$grid = "";

fscanf(STDIN, "%d %d", $n, $g);
for ($i = 0; $i < $n; $i++) {
    $grid .= "#" . stream_get_line(STDIN, $n + 1, "\n") . "#";
}

$grid = str_repeat("#", $n + 2) . $grid . str_repeat("#", $n + 2); //Format for search with regex

//Generate the patterns
$pattern = array_fill(0, $g, 'X');
$patterns = [
    implode("", $pattern),
    implode(".{" . ($n + 1) . "}", $pattern),
    implode(".{" . ($n + 2) . "}", $pattern),
    implode(".{" . $n . "}", $pattern),
];

//Check all patterns
foreach($patterns as $i => $pattern) {
    if(preg_match("/" . $pattern . "|" . str_replace('X', 'O', $pattern) ."/", $grid, $match, PREG_OFFSET_CAPTURE)) {

        [$text, $index] = $match[0];

        for($j = 0; $j < $g; ++$j) {
            //Replace the winning path
            switch($i) {
                case 0: $grid[$index + $j] = '-'; break;
                case 1: $grid[$index + (($n + 2) * $j)] = '|'; break;
                case 2: $grid[$index + (($n + 2) * $j) + $j] = '\\'; break;
                case 3: $grid[$index + (($n + 2) * $j) - $j] = '/'; break;
            }
        }
    }
}

echo implode("\n", array_map(function($line) {
    return substr($line, 1, -1);
}, array_slice(str_split($grid, $n + 2), 1, -1))) . PHP_EOL;

if(isset($text)) echo "The winner is " . $text[0] . "." . PHP_EOL;
elseif(strpos($grid, " ") !== false) echo "The game isn't over yet!" . PHP_EOL;
else echo "The game ended in a draw!" . PHP_EOL;
