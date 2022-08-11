<?php

fscanf(STDIN, "%d", $N);

for ($i = 0; $i < $N; $i++) {
    $lines[] = stream_get_line(STDIN, 127 + 1, "\n");
}
$line = str_replace("S", "", implode(" ", $lines)); //We don't care about the Statement, remove them

while(preg_match("/( if([ \d]+)else([ \d]+)endif)/", $line, $matches)) {
    //The number of result combinations in the 'then' part
    $leftSide = array_product(array_filter(explode(" ", $matches[2])));
    //The number of result combinations in the 'else' part
    $rightSide = array_product(array_filter(explode(" ", $matches[3])));

    //Replace the if else endif part with the number of combinaisions
    $line = str_replace($matches[1], " " . ($leftSide + $rightSide), $line);
}

//Took care of all the if statements, just do the product of the remaining values
preg_match("/begin(.*)end/", $line, $match);

echo array_product(array_filter(explode(" ", $match[1]))) . PHP_EOL;
?>
