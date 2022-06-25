<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $h);

$output = array_fill(0, $h, "");

for ($i = 0; $i < $h; $i++) {
    $values = explode(" ", stream_get_line(STDIN, 200 + 1, "\n"));

    for($j = 0; $j < count($values); ++$j) {
        if($j % 2 == 0) $output[$i] .= str_repeat(".", $values[$j]);
        else $output[$i] .= str_repeat("O", $values[$j]);
    }

    if($i > 0 && strlen($output[$i - 1]) != strlen($output[$i])) exit("INVALID");
}

echo implode("\n", $output);
?>
