<?php

$row = stream_get_line(STDIN, 100 + 1, "\n");

$laughts = str_split($row, 2);
$count = count($laughts);

//Get all the ones already laughing out loud
foreach($laughts as $laught) {
    if(preg_match("/[A-Z]{2}/", $laught)) {
        $loud[$laught] = 1;
    }
}

//Step 1
foreach($laughts as $i => $laught) {
    if(isset($loud[strtoupper($laught)])) $laughts[$i] = strtoupper($laught);
}

$result = $laughts;

//Step 2
foreach($laughts as $i => $laught) {
    error_log("working on $i $laught");

    if(preg_match("/[A-Z][a-z]/", $laught)) {
        //Both neighbors are sullen
        if($i > 0 && $i < $count - 1 && preg_match("/[a-z]{2}/", $laughts[$i - 1]) && preg_match("/[a-z]{2}/", $laughts[$i + 1])) continue;

        for($j = 1; $j <= 3; ++$j) {
            $left  = preg_match("/[A-Z]{2}/", ($laughts[$i - $j] ?? "")) ? $laughts[$i - $j] : null;
            $right = preg_match("/[A-Z]{2}/", ($laughts[$i + $j] ?? "")) ? $laughts[$i + $j] : null;

            //Out loud on both side, we use on letter from each
            if($left != null && $right != null) $result[$i] = $left[1] . $right[0];
            elseif($left != null) $result[$i] = $left;
            elseif($right != null) $result[$i] = $right;

            if($left != null || $right != null) break;
        }
    }
}

echo implode($result) . PHP_EOL;
