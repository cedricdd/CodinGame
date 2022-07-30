<?php

fscanf(STDIN, "%d", $N);
$inputs = explode(" ", fgets(STDIN));
for ($i = 0; $i < $N; $i++) {
    $value = intval($inputs[$i]);

    //As long as we already have a stone with the same value we merge them
    while($stones[$value] ?? 0) {
        $stones[$value] = 0;
        $value++;
    }

    $stones[$value] = 1;
}

//Remove 0 values and print count
echo count(array_filter($stones));
?>
