<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $line = stream_get_line(STDIN, 255 + 1, "\n");

    $count = 0;

    while(($position = strpos($line, 'f')) !== false) {
        ++$count;
        $line = substr($line, $position + 3); 
    } 

    echo $count . "\n";
}
?>
