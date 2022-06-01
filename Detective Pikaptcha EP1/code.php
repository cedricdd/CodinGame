<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d %d", $width, $height);
for ($i = 0; $i < $height; $i++) {
    fscanf(STDIN, "%s", $line);
    $lines[] = str_split($line); //Keeping it as string will break the case ($x - 1) being negative by returning the last character of the string
}

//error_log(var_export($lines, true));

for ($y = 0; $y < $height; $y++) {
    for ($x = 0; $x < $width; $x++) {
        if($lines[$y][$x] == '#') {
            echo '#';
            continue;
        }
        echo (($lines[$y-1][$x] ?? '#') == '0') + (($lines[$y+1][$x] ?? '#') == '0') + (($lines[$y][$x-1] ?? '#') == '0') + (($lines[$y][$x+1] ?? '#') == '0');
    }
    echo("\n");
}
?>
