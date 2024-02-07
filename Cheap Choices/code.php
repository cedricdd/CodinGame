<?php

$categories = [];

fscanf(STDIN, "%d", $c);
fscanf(STDIN, "%d", $p);
for ($i = 0; $i < $c; $i++) {
    [$category, $size, $price] = explode(" ", trim(fgets(STDIN)));

    $categories[$category][$size][] = $price;
}

foreach($categories as $categoryName => $category) {
    foreach($category as $size => $filler) {
        rsort($categories[$categoryName][$size]);
    }
}

for ($i = 0; $i < $p; $i++) {
    [$category, $size] = explode(" ", trim(fgets(STDIN)));

    if(isset($categories[$category][$size]) && $categories[$category][$size]) echo array_pop($categories[$category][$size]) . PHP_EOL;
    else echo "NONE" . PHP_EOL;
}
