<?php

fscanf(STDIN, "%d", $frameLength);
fscanf(STDIN, "%s", $frame);

if(substr($frame, 0, 8) != "DECAFBAD") exit("403 Forbidden"); //Wrong Header

$count = hexdec(substr($frame, 8, 3));

if($frameLength != $count + 12) exit("403 Forbidden"); //Wrong number of order

if(array_sum(array_map('hexdec', str_split($frame))) % 16 != 0) exit("403 Forbidden"); //Wrong checksum

$orders = [];

//Get the orders
for($i = 11; $i < $frameLength - 1; ++$i) $orders[$frame[$i]] = ($orders[$frame[$i]] ?? 0) + 1;

foreach($orders as $type => $count) echo "$count $type" . PHP_EOL;
