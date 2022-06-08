<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

for ($i = 0; $i < 3; $i++) {
    $map[] = stream_get_line(STDIN, 3 + 1, "\n");
}

error_log(var_export($map, true));

$tocheck = [
    [[0, 0], [0, 1], [0, 2]],
    [[1, 0], [1, 1], [1, 2]],
    [[2, 0], [2, 1], [2, 2]],
    [[0, 0], [1, 1], [2, 2]],
    [[0, 2], [1, 1], [2, 0]],
    [[0, 0], [1, 0], [2, 0]],
    [[0, 1], [1, 1], [2, 1]],
    [[0, 2], [1, 2], [2, 2]],
];

foreach($tocheck as $check) {

    $count = 0;
    $switch = [];

    foreach($check as $cell) {
        list($x, $y) = $cell;
        switch($map[$y][$x]) {
            case "X":
                continue 3;
            case "O":
                ++$count;
                break;
            case ".":
                $switch = $cell;
                break;
        }
    }
    
    if($count == 2) {
        $map[$switch[1]][$switch[0]] = "O";
        echo implode("\n", $map);
        exit();
    }
}

echo "false\n";
?>
