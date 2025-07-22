<?php

class MinPriorityQueue extends SplPriorityQueue {
    public function compare($a, $b) {
       return $b <=> $a;
    }
}

$start = microtime(1);

fscanf(STDIN, "%d %d", $w, $h);

$maze = "";

for ($i = 0; $i < $h; $i++) {
    $maze .= stream_get_line(STDIN, $w + 1, "\n");
}

$history = [];

$queue = new MinPriorityQueue();
$queue->insert([[], strpos($maze, 'S'), 0.0, 0, 0], 0.0);

while(true) {
    [$mud, $position, $score, $treasure, $cleared] = $queue->extract();

    if(isset($history[$position][$treasure][$cleared]) && $history[$position][$treasure][$cleared] <= $score) continue;

    $history[$position][$treasure][$cleared] = $score;

    if($treasure && $maze[$position] == 'E') {
        error_log(microtime(1) - $start);

        $time = intval($score);

        exit(round(($score - $time) * 100000) . " " . $time);
    }

    switch($maze[$position]) {
        case 'T': $treasure = 1; $score += 1; break;
        case 'W': $score += 2; break;
        case 'M': $score += 5; break;
        case 'X': $score += (isset($mud[$position]) ? 1 : 10); $mud[$position] = 1; $cleared = 1; break;
        default: $score += 1;
    }

    $score += 0.00001;

    foreach([1, -1, $w, -$w] as $m) {
        if($maze[$position + $m] != '#') {
            $queue->insert([$mud, $position + $m, $score, $treasure, $cleared], $score);
        }
    }

    if($queue->isEmpty()) break;
}
