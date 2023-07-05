<?php

$time = strtotime(fgets(STDIN));
$reset = strtotime("08:00:00 AM");

if($reset > $time) $reset -= 86400; //We are still using yesterday's reset time

//For every 239s that have passed we need to add 1s to catch to real time
echo date('g:i:s A', $time + (($time - $reset) / 239)) . PHP_EOL;
