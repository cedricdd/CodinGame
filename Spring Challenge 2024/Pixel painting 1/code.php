<?php
fscanf(STDIN, "%d", $n);
$grid = array_fill(0, $n, str_repeat(".", $n));
// game loop
while (TRUE) {
    [$command, $nbr] = explode(" ", trim(fgets(STDIN)));
    for ($i = 0; $i < $n; $i++) {
        if($command == "C") $grid[$i][$nbr] = "#";
        else $grid[$nbr][$i] = ".";
    }
    echo implode("\n", $grid) . PHP_EOL;
}
?>
