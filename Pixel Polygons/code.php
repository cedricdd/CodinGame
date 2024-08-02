<?php

$map = "";
$corners = 0;

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $map .= trim(fgets(STDIN));
}

//We are searching for all the corners, we have 1 side for each corner
$patterns = [
    "(?<=\.\..{" . ($N - 2) . "})#(?=\.)",
    "#(?=\..{" . ($N - 2) . "}\.\.)",
    "(?<=\.)#(?=.{" . ($N - 2) . "}\.\.)",
    "(?<=\.\..{" . ($N - 2) . "}\.)#",
    "#(?=#.{" . ($N - 2) . "}#\.)",
    "#(?=\..{" . ($N - 2) . "}##)",
    "#(?=#.{" . ($N - 2) . "}\.#)",
    "(?<=\.)#(?=.{" . ($N - 2) . "}##)",
];

foreach($patterns as $pattern) {
    preg_match_all("/" . $pattern . "/", $map, $matches);

    $corners += count($matches[0]);
}

echo $corners . PHP_EOL;
