<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++)
{
    fscanf(STDIN, "%s", $number);

    $key = '';
    for($index = 0; $index < strlen($number); ++$index) {
        $key .= $number[$index];
        $map[$key] = 1;
    }
}

// The number of elements (referencing a number) stored in the structure.
echo count($map) . "\n";
?>
