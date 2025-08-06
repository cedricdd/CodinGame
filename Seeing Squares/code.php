<?php

$rows = "";

fscanf(STDIN, "%d %d", $r, $c);
for ($i = 0; $i < $r; $i++) {
    $rows .= stream_get_line(STDIN, $c + 1, "\n");
}

error_log(var_export(str_split($rows, $c), 1));

$count = 0;

preg_match_all("/(?=\+---\+.{". ($c - 5) ."}\|.{3}\|.{". ($c - 5) ."}\+---\+)/", $rows, $matches);

$count += count($matches[0]);

preg_match_all("/(?=\+---[\+\-]---\+.{". ($c - 9) ."}\|.{7}\|.{". ($c - 9) ."}[\+\|].{7}[\+\|].{". ($c - 9) ."}\|.{7}\|.{". ($c - 9) ."}\+---[\+\-]---\+)/", $rows, $matches);

$count += count($matches[0]);

echo $count . PHP_EOL;
