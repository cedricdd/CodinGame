<?php

function solve(array $sides, int $index): int {
    static $history = [];
    // error_log(var_export($sides, 1));

    $hash = md5(serialize($sides));

    if(isset($history[$hash][$index])) return $history[$hash][$index];

    if(count($sides[0]) == 0) return 0;

    if($index == 1) {
        rsort($sides[1]);

        $time = array_pop($sides[1]);

        $sides[0][] = $time;

        return $history[$hash][$index] = $time + solve($sides, 0);
    } else {
        sort($sides[0]);

        //We use the fastest and the slowest
        $slowest = array_pop($sides[0]);
        $fastest = array_shift($sides[0]);

        $sides2 = $sides;

        array_push($sides2[1], $fastest, $slowest);

        $time = $slowest + solve($sides2, 1);

        if(count($sides[0])) {
            //We use the two slowest
            $sides2 = $sides;

            $extra = array_pop($sides2[0]);

            array_push($sides2[1], $slowest, $extra);
            array_push($sides2[0], $fastest);

            $time2 = $slowest + solve($sides2, 1);

            if($time2 < $time) $time = $time2;

            //We use the two fastest
            $sides2 = $sides;

            $extra = array_shift($sides2[0]);

            array_push($sides2[1], $fastest, $extra);
            array_push($sides2[0], $slowest);

            $time2 = $extra + solve($sides2, 1);

            if($time2 < $time) $time = $time2;
        }

        return $history[$hash][$index] = $time;
    }
}

$start = microtime(1);

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d", $times[]);
}

error_log(var_export($times, 1));

echo solve([$times, []], 0) . PHP_EOL;

error_log(microtime(1) - $start);
