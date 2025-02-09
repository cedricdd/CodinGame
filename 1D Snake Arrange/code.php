<?php

function solve(array $patterns, int $listID): int {
    global $list, $success, $history;

    error_log($listID . " " . implode("-", $patterns));

    if($listID == $success) return 1;

    $pattern = array_pop($patterns);

    if($pattern === null) return 0;

    $s1 = $list[$listID];
    $s2 = strlen($pattern);
    $count = 0;

    error_log("we need to add $s1 in $pattern ($s2)");

    if($s1 > $s2) return solve($patterns, $listID);

    for($i = 0; $i <= $s2 - $s1; ++$i) {
        error_log("we can start at $i");

        if($i != 0 && $pattern[$i - 1] == '#') continue;

        if($i + $s1 == $s2) $count += solve($patterns, $listID + 1);
        elseif($pattern[$i + $s1] != '#') {
            $patterns[] = substr($pattern, $i + $s1 + 1);

            $count += solve($patterns, $listID + 1);

            array_pop($patterns);
        }
    }

    $count += solve($patterns, $listID);

    return $count;
}

$start = microtime(1);

fscanf(STDIN, "%d", $n);

for ($i = 0; $i < $n; $i++) {
    $history = [];

    [$pattern, $list] = explode(" ", trim(fgets(STDIN)));
    preg_match_all("/[\?\#]+/", $pattern, $matches);

    $list = explode(",", $list);
    $success = count($list);

    // error_log(var_export($matches, 1));

    echo solve(array_reverse($matches[0]), 0) . PHP_EOL;
}

error_log(microtime(1) - $start);
