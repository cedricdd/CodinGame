<?php

$X = str_split(stream_get_line(STDIN, 99 + 1, "\n"));
$Y = stream_get_line(STDIN, 99 + 1, "\n");

foreach(str_split($Y) as $i => $c) {
    //There's a conflig with replacements
    if(isset($replace[$X[$i]]) && $replace[$X[$i]] != $c) die("CAN'T");
    else $replace[$X[$i]] = $c;
}

//Only keep the cases where there is a change
$changes = array_filter($replace, function($to, $from) {
    if($to !== $from) return true;
}, ARRAY_FILTER_USE_BOTH);

//Nothing is changed
if(count($changes) == 0) die("NONE");

foreach($changes as $from => $to) echo $from . "->" . $to . PHP_EOL;
?>
