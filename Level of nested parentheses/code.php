<?php

function getDepth($start, $end) {
    global $positions, $length;

    //We don't directly return the value even if we already have it to find the level of nesting
    $positions[$start][2]++;

    $depth = 1;
    for($x = $start + 1; $x < $end; ++$x) {
        if(isset($positions[$x])) {
            $depth = max($depth, 1 + getDepth($x, $positions[$x][0]));
            $x = $positions[$x][0];
        }
    }

    return $positions[$start][1] = $depth;
}

$f = stream_get_line(STDIN, 100 + 1, "\n");
echo $f . "\n";

$length = strlen($f);
$positions = [];
$line = $f;

//Get the positions of all the parentheses 
while(preg_match_all("/\([^\(\)]*\)/", $line, $matches, PREG_OFFSET_CAPTURE)) {

    foreach($matches[0] as $match) {
        $start = $match[1];
        $end = $match[1] + strlen($match[0]) - 1;

        $line[$start] = " ";
        $line[$end] = " ";
        $positions[$start] = [$end, 0, 0];
    }
}

if(count($positions) == 0) exit();

ksort($positions);

//Get the depth of all matching parentheses
foreach($positions as $start => $info) {
    getDepth($start, $info[0]);
}

//Build the formatted ASCII string showing the level of nesting
$maxSize = max(array_column($positions, 1));
$result = array_fill(0, $maxSize + 2, str_repeat(" ", $length));

foreach($positions as $start => $info) {
    [$end, $size, $level] = $info;

    $result[0][$start] = "^";
    $result[0][$end] = "^";

    for($y = 1; $y <= $size; ++$y) {
        $result[$y][$start] = "|";
        $result[$y][$end] = "|";
    }

    $result[$y][$start] = $level;
    $result[$y][$end] = $level;

    for($x = $start + 1; $x < $end; ++$x) $result[$y][$x] = '-';
}

echo implode("\n", $result) . "\n";
?>
