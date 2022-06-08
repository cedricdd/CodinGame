<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d %d", $N, $M);
for ($y = 0; $y < $N; $y++) {
    $line = stream_get_line(STDIN, $M + 1, "\n");

    //Get the position of all the heads
    preg_match_all("/o/", $line, $matches, PREG_OFFSET_CAPTURE);

    foreach($matches[0] as $match) $heads[] = [$match[1], $y];
    $map[] = $line;
}

 //Calculate the size of each snakes
foreach ($heads as $start) {
    list($x, $y) = $start;
    $size = 1;
    $direction = "";

   //Until we reach the tail
    while(true) {
        switch($map[$y][$x]) {
            case "o":
                if(($map[$y - 1][$x] ?? ".") == "|") {
                    --$y;
                    $direction = "UP";
                }
                elseif(($map[$y + 1][$x] ?? ".") == "|") {
                    ++$y;
                    $direction = "DOWN";
                }
                elseif(($map[$y][$x - 1] ?? ".") == "-") {
                    --$x;
                    $direction = "LEFT";
                }
                elseif(($map[$y][$x + 1] ?? ".") == "-") {
                    ++$x;
                    $direction = "RIGHT";
                }
                 ++$size;
                break;
            case "|":
                if($direction == "UP") --$y;
                else ++$y;
                ++$size;
                break;
            case "-";
                if($direction == "LEFT") --$x;
                else ++$x;
                ++$size;
                break;
            case "*":
                if($direction == "UP" || $direction == "DOWN") {
                    if(($map[$y][$x - 1] ?? ".") == "-") {
                        --$x;
                        $direction = "LEFT";
                    } else {
                        ++$x;
                        $direction = "RIGHT";
                    }
                } else {
                    if(($map[$y - 1][$x] ?? ".") == "|") {
                        --$y;
                        $direction = "UP";
                    } else {
                        ++$y;
                        $direction = "DOWN";
                    }
                }
                ++$size;
                break;
            case "<":
            case ">":
            case "^":
            case "v":
                $sizes[$size] = ($sizes[$size] ?? 0) + 1;
                break 2;
        }
    }
}

ksort($sizes);
echo array_key_last($sizes) . "\n";
echo array_pop($sizes) . "\n";
?>
