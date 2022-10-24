<?php

fscanf(STDIN, "%d %d", $n, $m);
for ($i = 0; $i < $m; $i++) {
    fscanf(STDIN, "%s %s %d", $t1, $t2, $duration);

    $technologies[$t1][2][$t2] = $duration; //T2 requires T1 to be researched
    $technologies[$t2][3][$t1] = $duration; //T1 is required to research T2
}

//Get the EST of a technology
function getEST(array $technologies, string $technology): int {
    if(isset($technologies[$technology]["EST"])) return $technologies[$technology]["EST"];

    //No technology is required to start this technology
    if(!isset($technologies[$technology][3])) $EST = 0;
    else {
        $EST = -INF;

        foreach(($technologies[$technology][3] ?? []) as $previous => $time) {
            $EST = max($EST, getEST($technologies, $previous) + $time);
        }
    }

    return $technologies[$technology]["EST"] = $EST;
}

//Get the LST of a technology
function getLST(array $technologies, string $technology): int {
    if(isset($technologies[$technology]["LST"])) return $technologies[$technology]["LST"];

    //This technology isn't required by any other technologies
    if(!isset($technologies[$technology][2])) $LST = $technologies[$technology]["EST"];
    else {
        $LST = INF;

        foreach(($technologies[$technology][2] ?? []) as $next => $time) {
            $LST = min($LST, getLST($technologies, $next) - $time);
        }
    }

    return $technologies[$technology]["LST"] = $LST;
}

//Get the critical path
function getCriticalPath(array $technologies): array {
    //Find the starting technology
    foreach($technologies as $technology => $info) {
        if($info["EST"] == 0) break;
    }

    $path = [];

    while(true) {
        $path[] = $technology;

        //We reached the last technology
        if(!isset($technologies[$technology][2])) return $path;

        $nextTechnology = null;

        //Find the next technology where EST == LST with the lowest EST
        foreach($technologies[$technology][2] as $next => $value) {
            if($technologies[$next]["EST"] == $technologies[$next]["LST"] && ($nextTechnology == null || $technologies[$next]["EST"] < $technologies[$nextTechnology]["EST"])) {
                $nextTechnology = $next;
            }
        }

        $technology = $nextTechnology;
    }
}

foreach($technologies as $technology => &$info) {
    getEST($technologies, $technology);
}

foreach($technologies as $technology => &$info) {
    getLST($technologies, $technology);
}

echo implode(" ", getCriticalPath($technologies)) . PHP_EOL;

ksort($technologies, SORT_STRING); //lexicographic ASCII order

foreach($technologies as $technology => $array) {
    echo $technology . " " . $array['EST'] . " " . $array['LST'] . PHP_EOL;
}
