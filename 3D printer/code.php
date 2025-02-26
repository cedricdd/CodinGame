<?php

fscanf(STDIN, "%d", $width);
fscanf(STDIN, "%d", $height);
fscanf(STDIN, "%d", $length);

for ($i = 0; $i < $height; $i++) {
    $front[] = stream_get_line(STDIN, 999 + 1, "\n");
}
for ($i = 0; $i < $height; $i++) {
    $right[] = stream_get_line(STDIN, 999 + 1, "\n");
}
for ($i = 0; $i < $length; $i++) {
    $top[] = stream_get_line(STDIN, 999 + 1, "\n");
}

//We start with every layers being the same as the top
$output = array_fill(0, $height, $top);

//For each ' ' we can see from the front we need to remove a column in the corresponding floor
for ($y = 0; $y < $height; $y++) {
    for($x = 0; $x < $width; ++$x) {
        if(($front[$y][$x] ?? ' ') == ' ') {
            foreach($output[$y] as &$line) $line[$x] = ' ';
        }
    }
}

//For each ' ' we can see from the right we need to remove a row in the corresponding floor
for ($y = 0; $y < $height; $y++) {
    for($x = 0; $x < $length; ++$x) {
        if(($right[$y][$x] ?? ' ') == ' ') {
            $output[$y][$width - 1 - $x] = "";
        }
    }
}

//Output from bottom to top with the proper formatting
echo implode(PHP_EOL . "--" . PHP_EOL, array_reverse(array_map(function ($layer) {
    return implode(PHP_EOL, array_map('rtrim',$layer));
}, $output))) . PHP_EOL . "--";
