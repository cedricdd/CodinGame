<?php

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $info = explode(" ", trim(fgets(STDIN)));

    if(count($info) == 3) {
        [$age, $gender, $genre] = $info;

        $genres[$gender][$genre][0] = min($age, $genres[$gender][$genre][0] ?? INF); //Lower bound for that genre/gender
        $genres[$gender][$genre][1] = max($age, $genres[$gender][$genre][1] ?? 0); //Upper bound for that genre/gender
    } else {
        [$age, $gender] = $info;

        //We check all the genres we know for that gender
        foreach($genres[$gender] ?? [] as $genre => [$min, $max]) {
            //If age is in the range we use the genre
            if($min <= $age && $max >= $age) {
                echo $genre . PHP_EOL;
                continue 2;
            }
        }

        echo "None" . PHP_EOL;
    }
}
