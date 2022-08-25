<?php

fscanf(STDIN, "%d %d", $height, $width);
for ($i = 0; $i < $height; $i++) {
    $integers[] = explode(" ", stream_get_line(STDIN, 1024 + 1, "\n"));
}
for ($y = 0; $y < $height; ++$y) {
    foreach(explode(" ", stream_get_line(STDIN, 1024 + 1, "\n")) as $x => $c) {
        if($c == "X") {
            $number = ($integers[$y][$x] > 0 ? 1 : -1);

            if(($check ?? 0) == $number) die("false");
            else $check = $number;
        }
    }
}

echo "true" . PHP_EOL;
?>
