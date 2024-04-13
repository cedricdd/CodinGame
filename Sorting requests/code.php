<?php

function solve(array $chapters, array $requests = [], int $count = 0) {
    global $sorted, $bestSolution, $countSolution, $hashSolution;
    static $history = [], $orderSolution = "";

    if($count > $countSolution) {
        error_log("Stopping, already have a smaller solution");
        return;
    }

    $hash = implode("-", array_column($chapters, 0));

    if($hash == $hashSolution) {
        $order = implode("-", array_keys($requests));

        error_log("We have a solution -- $order -- $count -- $countSolution");

        if(strcmp($order, $orderSolution) > 0) {
            $bestSolution = $requests;
            $countSolution = $count;
        }
    } elseif(isset($history[$hash]) && $history[$hash] < $count) {
        error_log("!!!!!!!!!!! we already had $hash");
        return;
    } else $history[$hash] = $count;

    error_log("Hash : $hash -- count $count");

    foreach($chapters as $i => [$chapterID, $chapeterName]) {
        if($sorted[$chapterID] != $i) {
            error_log("We need to move the chapter $chapterID from $i to " . $sorted[$chapterID] . " -- $count");

            $requestsUpdated = $requests;
            $requestsUpdated[$chapterID] = $chapterID . ". " . $chapeterName . " " . ($sorted[$chapterID] + 1);

            $chaptersUpdated = $chapters;
            $chapter = array_splice($chaptersUpdated, $i, 1);

            // error_log(var_export($chapters, true));

            array_splice($chaptersUpdated, $sorted[$chapterID], 0, $chapter);

            // error_log(var_export($chapters, true));
            solve($chaptersUpdated, $requestsUpdated, $count + 1);
        }
    }
}

$start = microtime(1);

fscanf(STDIN, "%d", $nChapters);
for ($i = 0; $i < $nChapters; $i++) {
    $chapters[] = explode(". ", trim(fgets(STDIN)));
}

error_log(var_export($chapters, true));

$sorted = array_column($chapters, 0);
sort($sorted);
$sorted = array_flip($sorted);

error_log(var_export($sorted, true));

$hashSolution = implode("-", array_keys($sorted));
error_log("hash solution $hashSolution");
$bestSolution = [];
$countSolution = INF;

solve($chapters);

error_log(var_export($bestSolution, true));

if($countSolution != INF) {
    echo $countSolution . PHP_EOL . implode("\n", $bestSolution) . PHP_EOL;
} else echo "0" . PHP_EOL;

error_log(microtime(1) - $start);
