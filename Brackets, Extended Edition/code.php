<?php

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    //Start by removing everything that's not a bracket
    $expression = preg_replace("/[^\(\)\[\]\{\}\<\>]/", "", stream_get_line(STDIN, 10000 + 1, "\n"));

    do {
        //Remove every pair of brackets of the same type
        $expression = preg_replace("/[\(\)]{2}|[\[\]]{2}|[\{\}]{2}|[\<\>]{2}/", "", $expression, -1, $replaced);
    } while($replaced);
    
    //If expression is now empty it's valid
    echo (empty($expression) ? "true" : "false") . "\n";
}
?>
