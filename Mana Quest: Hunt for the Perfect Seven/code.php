<?php

function solve(array $patterns, array $counts, float $percentage, int $left, int $otherCount, bool $debug = false) {
    global $probablity, $matches;

    // We have picked all the cards
    if($left == 53) {
        if(!$patterns) $probablity += $percentage;

        return;
    }

    $used = [];

    foreach($patterns as $pattern => $list) {
        foreach($list as $category) {
            if(isset($used[$category])) continue;
            else $used[$category] = 1;

            if($left == 60) {
                if($category == "C1R") $debug = true;
                else $debug = false;
            }

            error_log("at $left using $category for $pattern -- $left - $otherCount");

            $patterns2 = $patterns;
            $counts2 = $counts;

            foreach($matches[$category] as $pattern2) unset($patterns2[$pattern2]);

            $total = 0;

            foreach($list as $category2) {
                if($category == $category2) {
                    $total += $counts[$category2];
                    $counts2[$category2] = 0;
                }
                else {
                    foreach($matches[$category2] as $pattern2) {
                        if(isset($patterns2[$pattern2])) continue 2;
                    }

                    $total += $counts[$category2];
                    $counts2[$category2] = 0;
                }
            }

            // error_log(var_export($patterns2, 1));

            solve($patterns2, $counts2, $percentage * ($counts[$category] / $left), $left - 1, $otherCount + $total - 1, $debug);
        }
    }
    
    solve($patterns, $counts, $percentage * ($otherCount / $left), $left - 1, $otherCount - 1, $debug);
}

$total = 0;
$start = microtime(1);

fscanf(STDIN, "%d", $c);
for ($i = 0; $i < $c; $i++) {
    fscanf(STDIN, "%s %d", $category, $count);

    $total += $count;
    $categories[$category] = $count;
}

$patterns = [];
$matches = [];
$test2 = [];

fscanf(STDIN, "%d", $q);
for ($i = 0; $i < $q; $i++) {
    fscanf(STDIN, "%s", $pattern);

    if($pattern === "xxx") continue;

    foreach($categories as $category => $count) {
        if(preg_match("/" . str_replace("x", ".", $pattern) . "/", $category)) {
            $patterns[$pattern][] = $category;

            $matches[$category][] = $pattern;
        }
    }

    if(!isset($patterns[$pattern])) exit("0.0000");
}

$otherCount = 0;

foreach($categories as $category => $count) {
    if(!isset($matches[$category])) $otherCount += $count;
}

error_log(var_export($categories, 1));
error_log(var_export($patterns, 1));
error_log(var_export($matches, 1));

$probablity = 0.0;

solve($patterns, $categories, 1.0, 60, $otherCount);

echo number_format($probablity, 4) . PHP_EOL;

error_log(microtime(1) - $start);
