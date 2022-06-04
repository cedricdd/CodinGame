<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

$supportedCharacters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ?";

fscanf(STDIN, "%d", $L);
fscanf(STDIN, "%d", $H);
$T = stream_get_line(STDIN, 256 + 1, "\n");
for ($i = 0; $i < $H; $i++) {
    $ROW = stream_get_line(STDIN, 1024 + 1, "\n");
    
    foreach(array_chunk(str_split($ROW), $L) as $j => $output) {
        $letters[$j][$i] = implode('', $output);
    }
}

//error_log(var_export($letters, true));

for ($i = 0; $i < $H; $i++) {
    $output = "";

    foreach(str_split(strtoupper($T)) as $letter) {
        $position = strpos($supportedCharacters, $letter);
        $output .= $letters[($position !== FALSE) ? $position : 26][$i];
    }

    echo($output . "\n");
}
?>
