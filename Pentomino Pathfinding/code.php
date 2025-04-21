<?php

const PENTOMINOES = [
    //I
    '0-0;0-1;0-2;0-3;0-4' => 1,
    '0-0;1-0;2-0;3-0;4-0' => 1,
];

$start = microtime(1);

fscanf(STDIN, "%d %d", $width, $height);
fscanf(STDIN, "%d", $maxCount);
for ($i = 0; $i < $height; $i++) {
    $map[] = stream_get_line(STDIN, $width + 1, "\n");
}

// error_log(var_export(count_chars(implode('', $map), 1), 1));

foreach(count_chars(implode('', $map), 1) as $c => $v) {
    if($c != 35 && $c != 46 && ($v % 5) != 0) exit("Board is invalid.\n0");
}

error_log(var_export($map, 1));

$longest = 0;

for($y = 1; $y < $height - 1; ++$y) {
    for($x = 1; $x < $width - 1; ++$x) {
        if($map[$y][$x] == '.') {
            $history = [];
            $count = 0;
            $toCheck = [$y => [$x => 1]];

            while(true) {
                $newCheck = [];

                // error_log($count);
                // error_log(var_export($toCheck, 1));

                foreach($toCheck as $y2 => $line) {
                    foreach($line as $x2 => $filler) {
                        $history[$y2][$x2] = 1;
    
                        foreach([[0, 1], [0, -1], [1, 0], [-1, 0]] as [$xm, $ym]) {
                            $xu = $x2 + $xm;
                            $yu = $y2 + $ym;
    
                            if($map[$yu][$xu] == '.' && !isset($history[$yu][$xu])) $newCheck[$yu][$xu] = 1;
                        }
                    }
                }

                if($newCheck) {
                    ++$count;
                    $toCheck = $newCheck;
                } else {
                    $longest = max($longest, $count);
                    break;
                }
            }
        } 
    }
}

echo "Board has valid pieces." . PHP_EOL;
echo $longest . PHP_EOL;

error_log(microtime(1) - $start);
