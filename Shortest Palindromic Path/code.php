<?

class MinPriorityQueue extends SplPriorityQueue {

    public function compare($a, $b) {
       return $b <=> $a;
    }
}

function getDistance(int $x1, int $y1, int $x2, int $y2): int {
    return abs($x1 - $x2) + abs($y1 - $y2);
}

const N = [[0, 1], [0, -1], [1, 0], [-1, 0]];

fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d %d", $ys, $xs);
fscanf(STDIN, "%d %d", $yg, $xg);

for ($i = 0; $i < $N; $i++){
    $grid[] = trim(fgets(STDIN));
}

$start = microtime(1);
$history = [];
$queue = new MinPriorityQueue();
$queue->insert([$xs - 1, $ys - 1, $xg - 1, $yg - 1, getDistance($xs, $ys, $xg, $yg), 1], 0);
$answer = INF;

while($queue->count()) {
    [$x1, $y1, $x2, $y2, $d, $l] = $queue->extract();

    //We can't find a shortest path
    if($l * 2 + getDistance($x1, $y1, $x2, $y2) > $answer) continue;

    $i1 = $y1 * $N + $x1;
    $i2 = $y2 * $N + $x2;

    //We have found a path
    if($d <= 1) {
        $answer = $l * 2 - ($d ^ 1);
        continue;
    }

    //Check if we already had this configuration with a shorter path
    if((isset($history[$i1][$i2]) && $history[$i1][$i2] <= $l) || (isset($history[$i2][$i1]) && $history[$i2][$i1] <= $l)) continue;
    else $history[$i1][$i2] = $history[$i2][$i1] = $l;

    ++$l; //Length increase

    //Check all the moves we can make at position 1
    foreach(N as [$xm1, $ym1]) {
        $xu1 = $x1 + $xm1;
        $yu1 = $y1 + $ym1;

        if($xu1 >= 0 && $xu1 < $N && $yu1 >= 0 && $yu1 < $N) {
            //Check all the moves we can make at position 2
            foreach(N as [$xm2, $ym2]) {
                $xu2 = $x2 + $xm2;
                $yu2 = $y2 + $ym2;

                //We move on the same letter, it's still a palyndrome
                if($xu2 >= 0 && $xu2 < $N && $yu2 >= 0 && $yu2 < $N && $grid[$yu1][$xu1] == $grid[$yu2][$xu2]) {
                    $d = getDistance($xu1, $yu1, $xu2, $yu2);

                    $queue->insert([$xu1, $yu1, $xu2, $yu2, $d, $l], $l + $d);
                }
            }
        }
    }
}

echo $answer . PHP_EOL;
error_log(microtime(1) - $start);
