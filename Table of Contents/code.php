<?php

fscanf(STDIN, "%d", $lengthofline);
fscanf(STDIN, "%d", $N);

$sections = [];

for ($i = 0; $i < $N; $i++) {
    [$title, $page] = explode(" ", trim(fgets(STDIN)));

    $titleTrimmed = ltrim($title, ">");
    $indent = strlen($title) - strlen($titleTrimmed);

    $sections[$indent + 1] = 0; //Make sure the sub-section is set to 0 in case we are done with it
    $sections[$indent] = ($sections[$indent] ?? 0) + 1; //Increment section count

    $formatted = str_repeat("    ", $indent) . $sections[$indent] . " " . $titleTrimmed;
    echo $formatted . str_repeat(".", $lengthofline - strlen($formatted . $page)) . $page . PHP_EOL; 
}
