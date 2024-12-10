<?php

function solve(array $evidences, int $index) {
    global $N;

    if($index == $N) exit(array_key_first($evidences[0]));

    //Test all the evidences left at this index
    foreach($evidences[$index] as $evidence => $filler) {
        $evidences2 = $evidences;
        
        //Remove all the other evidences at this index in all the sets
        foreach($evidences[$index] as $evidence2 => $filler2) {
            if($evidence != $evidence2) {
                for($i = 0; $i < $N; ++$i) {
                    unset($evidences2[$i][$evidence2]);

                    //We have one set with nothing left, we have picked a wrong evidence
                    if(count($evidences2[$i]) == 0) continue 3;
                }
            }
        }

        solve($evidences2, $index + 1);
    }

}

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $input = explode(", ", trim(fgets(STDIN)));

    $evidences[] = array_flip($input);
}

solve($evidences, 0);
