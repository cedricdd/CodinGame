<?php

for ($i = 0; $i < 11; $i++) {
    $row[] = stream_get_line(STDIN, 59 + 1, "\n");
}

$value = "";

for($i = 0; $i < 13; ++$i) {
    $count = 0;
    
    $index = 5 + $i * 4;

    if($row[3][$index] != "|") $count += 5;
    if($row[5][$index] == "|") $count += 0;
    elseif($row[6][$index] == "|") $count += 1;
    elseif($row[7][$index] == "|") $count += 2;
    elseif($row[8][$index] == "|") $count += 3;
    elseif($row[9][$index] == "|") $count += 4;

    error_log($count);
    $value .= $count; 
}

$pos = strpos($row[4], '.') - 5;
$pos /= 4;
$pos += 1;

error_log($pos);

echo trim(substr($value, 0, $pos) . "." . substr($value, $pos), '0') . PHP_EOL;
