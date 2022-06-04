<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $numberSnails);
for ($i = 1; $i <= $numberSnails; $i++) {
    fscanf(STDIN, "%d", $speeds[$i]);
}
fscanf(STDIN, "%d", $h);
fscanf(STDIN, "%d", $w);

$snails = [];
$exits = [];

for ($y = 0; $y < $h; $y++) {
    $line = stream_get_line(STDIN, 1024 + 1, "\n");

    foreach(str_split($line) as $x => $c) {
        //We found a snail
        if(ctype_digit($c)) {
            $snails[$c] = [$x, $y, $w + $h];

            //Check this snail against known exists
            foreach($exits as $exit) {
                $turns = ceil((abs($exit[0] - $x) + abs($exit[1] - $y)) / $speeds[$c]);
                $snails[$c][2] = min($snails[$c][2], $turns);
            }
        } //We found an exit
        elseif($c === '#') {
            $exits[] = [$x, $y];

            //Check this exit against known snails
            foreach($snails as $i => $snail) {
                $turns = ceil((abs($snail[0] - $x) + abs($snail[1] - $y)) / $speeds[$i]);
                $snails[$i][2] = min($snails[$i][2], $turns);
            }
        }
    }
}

//Order by best number of turn to reach an exit
uasort($snails, function ($a, $b) {
    return $a[2] <=> $b[2];
});

echo array_key_first($snails);
?>
