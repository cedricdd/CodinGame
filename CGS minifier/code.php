<?php

$alphabet = range("a", "z");
$minified = [];
$code = "";

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $code .= trim(fgets(STDIN));
}

//Find all the variables to minify
preg_match_all('/\$([^\$]*)\$/', $code, $matches);

foreach($matches[1] as $variable) {
    //This variable hasn't already been minified
    if(!isset($minified[$variable])) {
        $minified[$variable] = array_shift($alphabet);

        $code = str_replace("$" . $variable . "$", "$" . $minified[$variable] . "$", $code);
    }
}

//Replace any space character except between apostrophes, we assume there are no nested apostrophes and no unclosed apostrophes
echo preg_replace("/\s+(?=(?:[^\']*[\'][^\']*[\'])*[^\']*$)/", "", $code) . PHP_EOL;
