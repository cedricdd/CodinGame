<?php
$T = stream_get_line(STDIN, 1000 + 1, "\n");

foreach(explode(' ', $T) as $chunk) {
    preg_match("/([0-9]*)([0-9]{1}|[^0-9]+)/", $chunk, $match);

    switch($match[2]) {
        case "sp": $c = " "; break;
        case "bS": $c = "\\"; break;
        case "sQ": $c = "'"; break;
        case "nl": $c = "\n"; break;
        default: $c = $match[2];
    }

    echo str_repeat($c, $match[1] ?: 1);
}
?>
