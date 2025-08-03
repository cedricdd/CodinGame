<?php

fscanf(STDIN, "%d %d %d", $vampireCount, $zombieCount, $ghostCount);

fscanf(STDIN, "%d", $n);

$canSeeFromTop = array_map('intval', explode(" ", fgets(STDIN)));
$canSeeFromBottom = array_map('intval', explode(" ", fgets(STDIN)));
$canSeeFromLeft = array_map('intval', explode(" ", fgets(STDIN)));
$canSeeFromRight = array_map('intval', explode(" ", fgets(STDIN)));

for ($i = 0; $i < $n; $i++) {
    $manor[] = trim(fgets(STDIN));
}

error_log(var_export($manor, 1));

foreach($canSeeFromTop as $i => $v) {
    $x = $i;
    $y = 0;
    $d = 'D';
    $mirror = 0;
    $positions = [];

    while($x >= 0 && $x < $n && $y >= 0 && $y < $n) {
        // error_log("at $x $y - $d - " . $manor[$y][$x]);
        if($manor[$y][$x] == '.') {
            $index = $y * $n + $x;

            if(isset($positions[$index])) {
                if($positions[$index][0] != $mirror) $positions[$index][0] = 2;
                $positions[$index][1]++;
            }
            else $positions[$index] = [$mirror, 1];
        } elseif($manor[$y][$x] == '/') {
            switch($d) {
                case 'U': $d = 'R'; break;
                case 'D': $d = 'L'; break;
                case 'L': $d = 'D'; break;
                case 'R': $d = 'U'; break;
            }
        } elseif($manor[$y][$x] == '\\') {
            switch($d) {
                case 'U': $d = 'L'; break;
                case 'D': $d = 'R'; break;
                case 'L': $d = 'U'; break;
                case 'R': $d = 'D'; break;
            }
        }

        switch($d) {
            case 'U': --$y; break;
            case 'D': ++$y; break;
            case 'L': --$x; break;
            case 'R': ++$x; break;
        }

        // error_log("end $x $y - $d - " . $manor[$y][$x]);
    }

    error_log(var_export($positions, 1));
}

echo implode(PHP_EOL, $manor);
