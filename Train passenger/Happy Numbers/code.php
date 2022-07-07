<?php

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $input = stream_get_line(STDIN, 128 + 1, "\n");

    $sum = $input;
    $history = [];

    while(true) {

        if($sum == 1) {
            echo $input . " :)\n";
            continue 2;
        }

        if(isset($history[$sum])) {
            echo $input . " :(\n";
            continue 2;
        }
        
        $history[$sum] = 1;
        
        $sum = array_sum(array_map(function($d) {
            return $d * $d;
        }, str_split($sum)));
    }
}
?>
