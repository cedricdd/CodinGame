<?php

$ip = stream_get_line(STDIN, 40 + 1, "\n");

//Replace the longest streak that's at least 3 streaks
$ip = preg_replace("/(?:\:?0{4}\:?){3,}/", "::", $ip, 1, $replaced); 
//No 3 or more streaks, replace the first with 2
if(!$replaced) $ip = preg_replace("/(?:\:?0{4}\:?){2,}/", "::", $ip, 1); 

//Remove the leading zeros of every block
$ip = preg_replace("/(?<=^|:)0{1,3}([^:]{1,3})/", "$1", $ip);

echo $ip . PHP_EOL;
?>
