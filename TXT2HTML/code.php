<?php
fscanf(STDIN, "%d", $N);

$line = [];
echo "<table>" . PHP_EOL;

for ($i = 0; $i < $N; $i++) {
    $input = stream_get_line(STDIN, 50 + 1, "\n");

    //We start a new line
    if($input[0] == '+') {
        //We need to output the last line
        if($line) echo "<tr>" . implode('', array_map(function($values) { 
            return "<td>" . implode(" ", $values) . "</td>"; 
        }, $line)) . "</tr>" . PHP_EOL;

        $line = array_fill(0, substr_count($input, "+") - 1, []); //New empty line
    } else {
        //Get the values each cells, skip anything empty
        $cells = array_filter(array_map('trim', explode('|', $input)));

        foreach($cells as $j => $cell) $line[$j - 1][] = trim($cell);
    }
}

echo "</table>" . PHP_EOL;
