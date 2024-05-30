<?php

//Get all the elements that the substring needs to contain
function getElements(string $pattern): array {
    $elements = [];

    foreach(explode(",", $pattern) as $syntax) {
        if(strlen($syntax) > 1) {
            [$s, $e] = explode('-', $syntax);
            foreach(range($s, $e) as $element) $elements[$element] = 1;
        } else $elements[$syntax] = 1;
    }

    return $elements;
}

$start = microtime(1);

$wall = "";

fscanf(STDIN, "%d %d", $w, $h);
for ($i = 0; $i < $h; $i++) {
    $wall .= trim(fgets(STDIN));
}

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $caseline = trim(fgets(STDIN));
    $elements = getElements($caseline);

    $best = [INF, 0, 0];
    $maxStart = strlen($wall) - count($elements); //The max position for the start of the substring

    for($indexStart = 0; $indexStart <= $maxStart; ++$indexStart) {
        if(isset($elements[$wall[$indexStart]])) {
            $indexEnd = 0;
            
            //Foreach elements find the first closest one to the current position
            foreach($elements as $element => $filler) {
                $position = strpos($wall, strval($element), $indexStart);

                if($position === false) break 2; //This element wasn't found, we can no longer find a shortest substring

                //We already know that this substring can't be shorter than our current best
                if($position - $indexStart >= $best[0]) {
                    //Assuming that the element we just searched is the last character of the substring, move to the first position where we would have a shortest substring
                    $indexStart += ($position - $indexStart) - $best[0]; 
                    continue 2;
                } 

                if($position > $indexEnd) $indexEnd = $position;
            }

            $best = [$indexEnd - $indexStart, $indexStart, $indexEnd];
        }
    }

    echo $best[1] . " " . $best[2] . PHP_EOL;
}

error_log(microtime(1) - $start);
