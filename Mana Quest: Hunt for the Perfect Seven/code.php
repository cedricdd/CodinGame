<?php

function solve(array $patterns, array $categories, float $percentage, int $left, int $noPatternCount) {
    global $probablity, $matches, $counts;

    // We have picked all the cards
    if($left == 53) {
        if(!$patterns) $probablity += $percentage;

        return;
    }

    // Test by picking any of the categories we are still interested in
    foreach($categories as $category => $filler) {
        $patterns2 = $patterns;
        $categories2 = $categories;

        foreach($matches[$category] as $pattern2) unset($patterns2[$pattern2]); // Remove all the patterns that match the category

        unset($categories2[$category]);
        $newNoPatternCount = $counts[$category];

        // Potentially we now don't need some of the other categories if they were only matching a pattern that match the category we used
        if(count($matches[$category]) > 1) {
            foreach($categories2 as $category2 => $filler) {
                foreach($matches[$category2] as $pattern2) {
                    if(isset($patterns2[$pattern2])) continue 2;
                }

                // We don't need that category anymore
                unset($categories2[$category2]);
                $newNoPatternCount += $counts[$category2];
                $counts2[$category2] = 0;
            }
        }

        solve($patterns2, $categories2, $percentage * ($counts[$category] / $left), $left - 1, $noPatternCount + $newNoPatternCount - 1);
    }
    
    // We pick a card not matching any pattern we still need
    solve($patterns, $categories, $percentage * ($noPatternCount / $left), $left - 1, $noPatternCount - 1);
}

$start = microtime(1);

fscanf(STDIN, "%d", $c);
for ($i = 0; $i < $c; $i++) {
    fscanf(STDIN, "%s %d", $category, $count);

    $counts[$category] = $count;
}

$matches = [];
$patterns = [];
$categories = [];

fscanf(STDIN, "%d", $q);
for ($i = 0; $i < $q; $i++) {
    fscanf(STDIN, "%s", $pattern);

    if($pattern === "xxx") continue; // Any card will match, skipping

    $patterns[$pattern] = 1;

    //Find all the categories that match the pattern
    foreach($counts as $category => $count) {
        if(preg_match("/" . str_replace("x", ".", $pattern) . "/", $category)) {
            $categories[$category] = 1;

            $matches[$category][] = $pattern;
        }
    }
}

$noPatternCount = 0;

// Get how many cards don't match any patterns
foreach($counts as $category => $count) {
    if(!isset($matches[$category])) $noPatternCount += $count;
}

$probablity = 0.0;

solve($patterns, $categories, 1.0, 60, $noPatternCount);

echo number_format($probablity, 4) . PHP_EOL;

error_log(microtime(1) - $start);
