<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d %d", $width, $height);
for ($i = 0; $i < $height; $i++) {
    fscanf(STDIN, "%s", $line);
    $map[] = str_split($line);

    if(preg_match("/([<>^v])/", $line, $match)) {
        $sx = $px = strpos($line, $match[0]);
        $sy = $py = $i;

        switch($match[0]) {
            case "<": $direction = "LEFT"; break;
            case ">": $direction = "RIGHT"; break;
            case "^": $direction = "UP"; break;
            case "v": $direction = "DOWN"; break;
        }
    }
}
fscanf(STDIN, "%s", $side);

/*
for ($i = 0; $i < $height; $i++) {
    error_log(var_export(implode("", $map[$i]), true));
}
*/

//Replace starting postion
$map[$py][$px] = 0;

if($side == "L") {
    $directions = [
        "RIGHT" => ["UP" => [-1, 0], "RIGHT" => [0, 1], "DOWN" => [1, 0], "LEFT" => [0, -1]],
        "UP" => ["LEFT" => [0, -1], "UP" => [-1, 0], "RIGHT" => [0, 1], "DOWN" => [1, 0]],
        "LEFT" => ["DOWN" => [1, 0], "LEFT" => [0, -1], "UP" => [-1, 0], "RIGHT" => [0, 1]],
        "DOWN" => ["RIGHT" => [0, 1], "DOWN" => [1, 0], "LEFT" => [0, -1], "UP" => [-1, 0]],
    ];
} else {
    $directions = [
        "RIGHT" => ["DOWN" => [1, 0], "RIGHT" => [0, 1], "UP" => [-1, 0], "LEFT" => [0, -1]],
        "UP" => ["RIGHT" => [0, 1], "UP" => [-1, 0], "LEFT" => [0, -1], "DOWN" => [1, 0]],
        "LEFT" => ["UP" => [-1, 0], "LEFT" => [0, -1], "DOWN" => [1, 0], "RIGHT" => [0, 1]],
        "DOWN" => ["LEFT" => [0, -1], "DOWN" => [1, 0], "RIGHT" => [0, 1], "UP" => [-1, 0]],
    ];
}

if(($map[$py][$px + 1] ?? '#') !== "#" || ($map[$py][$px - 1] ?? '#') !== "#" || ($map[$py - 1][$px] ?? '#') !== "#" || ($map[$py + 1][$px] ?? '#') !== "#") {

    while(true) {

        //Find the new direction to take
        foreach($directions[$direction] as $newDirection => $values) {
            //The first available path
            if(($map[$py + $values[0]][$px + $values[1]] ?? "#") !== "#") {
                $direction = $newDirection;
                $py += $values[0];
                $px += $values[1];
                break;
            }
        }

        $map[$py][$px]++;

        //Back at the start
        if($px == $sx && $py == $sy) break;
    }

}

for ($i = 0; $i < $height; $i++) {
    echo implode("", $map[$i]) . "\n";
}
?>
