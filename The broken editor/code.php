<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

$input = stream_get_line(STDIN, 80 + 1, "\n");

error_log(var_export($input, true));

$output = "";
$index = 0;

foreach (str_split($input) as $character) {
    
    switch($character) {
        case "<":
            --$index;
            break;
        case ">":
            ++$index;
            break;
        case "-":
            $output = substr($output, 0, $index - 1) . substr($output, $index);
            --$index;
            break;
        default:
            $output = substr($output, 0, $index) . $character . substr($output, $index);
            ++$index;
    }

    //Fix out of bounds
    $index = max(0, min(strlen($output), $index));

};

echo $output;
?>
