<?php

fscanf(STDIN, "%d %d", $N, $K);
for ($i = 0; $i < $K; $i++) {
    $inputs = array_map("intval", explode(" ", trim(fgets(STDIN))));

    $solutions = [];

    for($p = 0; $p < $N; ++$p) {
        $value = $inputs[$p];
        $inputs[$p] = 0;

        while($inputs[$p] < $value) {

            $max = max($inputs);
            $xor = array_reduce($inputs, function($carry, $item) {
                return $carry ^ $item;
            });
            
            /*
            https://mathoverflow.net/questions/71802/analysis-of-misere-nim
            Let ⊕ denote the bitwise xor operation on natural numbers. 
            It is both well-known and easy to verify that a Nim position (n1,…,nk) is a second player win in misère Nim if and only if:
                - some ni>1 and n1⊕⋯⊕nk=0
                - or all ni≤1 and n1⊕⋯⊕nk=1
            */
            if(($max > 1 && $xor == 0) || ($max <= 1 && $xor == 1)) {
                $solutions[] = ($p + 1) . ":" . ($value - $inputs[$p]);
                break;
            }

            $inputs[$p]++;
        }

        $inputs[$p] = $value;
    }

    if(count($solutions) == 0) echo "CONCEDE" . PHP_EOL;
    else echo implode(" ", $solutions) . PHP_EOL;
}
