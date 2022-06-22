<?php
fscanf(STDIN, "%d", $N);
$inputs = explode(" ", fgets(STDIN));
for ($i = 0; $i < $N; $i++) {
    $n = intval($inputs[$i]);

    if(isset($check[$n])) {
        $check[$n + 1] = $check[$n] + 1;
        unset($check[$n]);
    } else $check[$n + 1] = 1;
}

//Sort by value asc, key desc
krsort($check);
asort($check);

$last = array_key_last($check);
$lenght = array_pop($check);

echo implode(" ", range($last - $lenght, $last - 1)) . "\n";
?>
