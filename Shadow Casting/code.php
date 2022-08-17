<?php

$ans = [];
$width = 0;

fscanf(STDIN, "%d", $N);
for($i = 0; $i < $N; ++$i) {
    $art[] = stream_get_line(STDIN, 256 + 1, "\n");
    $width = max($width, strlen($art[$i]));
}

$ans = array_fill(0, $N + 2, str_repeat(" ", $width + 2));

foreach($art as $y => $line) {
    foreach(str_split($line) as $x => $c) {
        if($c !== " " && $c !== "") {
            $ans[$y][$x] = $c;
            $ans[$y + 1][$x + 1] = "-";
            $ans[$y + 2][$x + 2] = "`";
        }
    }
}

echo implode("\n", array_map("rtrim", $ans)) . PHP_EOL;
?>
