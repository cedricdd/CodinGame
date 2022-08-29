<?php

fscanf(STDIN, "%d %d", $w, $h);
fscanf(STDIN, "%d", $n);

$map = "";
for ($i = 0; $i < $h; $i++) {
    $map .= stream_get_line(STDIN, 500 + 1, "\n");
}

error_log(var_export(str_split($map, $w), true));
$start = strpos($map, "O");
$position = $start;
$history = [];
$direction = 0;
$step = 0;
$moves = [$w * -1, 1, $w, -1];

//Move until we moved n time or until we reached a loop (same position and same direction)
while(!isset($history[$position . " " . $direction])) {
    $history[$position . " " . $direction] = $step++;

    //Robot encounters an obstacle, turn right
    while($map[$position + $moves[$direction]] == "#") $direction = ($direction + 1) % 4; 

    $position += $moves[$direction];

    if(--$n == 0) break;
}

//We have reached a loop and there are still some moves to do
if($n != 0) {
    $loopSize = $history[$position . " " . $direction];
    //Only keep the positions that are part of the loop and removed the direction
    $history = array_slice(array_map(function($v) { return explode(" ", $v)[0]; }, array_flip($history)), $loopSize);

    //Robot is moving in the loop
    $position = $history[$n % count($history)];
}

echo ($position % $w) . " " . (intdiv($position, $w)) . PHP_EOL;
?>
