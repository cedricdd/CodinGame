<?php

$rows = "";
$start = microtime(1);

fscanf(STDIN, "%d %d", $r, $c);
for ($i = 0; $i < $r; $i++) {
    $rows .= stream_get_line(STDIN, $c + 1, "\n") . '#';
}

++$c; //We add a character for the rexeg to clearly separate lines

foreach(str_split($rows, $c) as $line) error_log(var_export($line, 1));

$max = min($c, $r * 2);
$count = 0;

//Test all the possible size of square
for($i = 3; $i <= $max; $i += 2) {
    $pattern = "/(?=\+[\+\-]{" . ($i - 2) . "}\+.{". ($c - $i) ."}" . str_repeat("[\+\|].{" . ($i - 2) . "}[\+\|].{". ($c - $i) ."}", (($i >> 1) - 1)) . "\+[\+\-]{" . ($i - 2) . "}\+)/";

    preg_match_all($pattern, $rows, $matches);

    $count += count($matches[0]);
}

echo $count . PHP_EOL;

error_log(microtime(1) - $start);
