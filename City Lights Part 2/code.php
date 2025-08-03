<?php

const CHARACTERS = [0 => 0,1 => 1,2 => 2,3 => 3,4 => 4,5 => 5,6 => 6,7 => 7,8 => 8,9 => 9,10 => 'A',11 => 'B',12 => 'C',13 => 'D',14 => 'E',15 => 'F',16 => 'G',17 => 'H',18 => 'I',19 => 'J',20 => 'K',21 => 'L',22 => 'M',23 => 'N',24 => 'O',25 => 'P',26 => 'Q',27 => 'R',28 => 'S',29 => 'T',30 => 'U',31 => 'V',32 => 'W',33 => 'X',34 => 'Y',35 => 'Z'];
$toValues = array_flip(CHARACTERS);

fscanf(STDIN, "%d", $w);
fscanf(STDIN, "%d", $h);
fscanf(STDIN, "%d", $d);

$level = array_fill(0, $h, array_fill(0, $w, 0));
$output = array_fill(0, $d, $level);

fscanf(STDIN, "%d", $n);

for ($z = 0; $z < $d; ++$z) {
    for ($y = 0; $y < $h; $y++) {
        foreach(str_split(trim(fgets(STDIN))) as $x => $c) {
            if($c !== '.') {
                $v = $toValues[$c];

                for($z2 = max(0, $z - $v); $z2 < min($z + $v, $d); ++$z2) {
                    for($y2 = max(0, $y - $v); $y2 < min($y + $v, $h); ++$y2) {
                        for($x2 = max(0, $x - $v); $x2 < min($x + $v, $w); ++$x2) {
                            $output[$z2][$y2][$x2] += max(0, $v - round(sqrt((($x - $x2) ** 2) + (($y - $y2) ** 2) + (($z - $z2) ** 2))));
                            $output[$z2][$y2][$x2] = min($output[$z2][$y2][$x2], 35);
                        }
                    }
                }
            }
        }
    }

    trim(fgets(STDIN)); //Useless line
}

echo implode(PHP_EOL . PHP_EOL, array_map(function ($level) {
    return implode(PHP_EOL, array_map(function ($line) {
        return implode('', array_map(function ($value) {
            return CHARACTERS[$value];
        }, $line));
    }, $level));
}, $output)) . PHP_EOL;
