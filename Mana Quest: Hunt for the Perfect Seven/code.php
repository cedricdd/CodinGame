<?php

$total = 0;

fscanf(STDIN, "%d", $c);
for ($i = 0; $i < $c; $i++) {
    fscanf(STDIN, "%s %d", $category, $count);

    $total += $count;
    $categories[$category] = $count;
}


$patterns = [];
$counts = [];

fscanf(STDIN, "%d", $q);
for ($i = 0; $i < $q; $i++) {
    fscanf(STDIN, "%s", $pattern);

    foreach($categories as $category => $count) {
        if(preg_match("/" . str_replace("x", ".", $pattern) . "/", $category)) {
            $patterns[$pattern][] = $category;

            $counts[$category] = $count;
        }
    }

    if(!isset($patterns[$pattern])) exit("0.0000");
}

$counts["-"] = $total - array_sum($counts);

error_log(var_export($categories, 1));
error_log(var_export($patterns, 1));
error_log(var_export($counts, 1));
