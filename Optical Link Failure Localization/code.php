<?php

fscanf(STDIN, "%d", $links);
fscanf(STDIN, "%d", $mtrails);
fscanf(STDIN, "%d", $failures);

$codes = str_split(trim(fgets(STDIN)));

for ($i = 0; $i < $links; $i++) {
    foreach(str_split(trim(fgets(STDIN))) as $x => $c) $rows[$x][] = intval($c);
}

for($x = 0; $x < $mtrails; ++$x) {
    //Every links in this trails are working
    if($codes[$x] == 0) {
        foreach($rows[$x] as $y => $c) {
            //This link was used in the working trail
            if($c == 1) {
                //We can remove the link from all other trails, we know it works
                for($x2 = 0; $x2 < $mtrails; ++$x2) {
                    if(!isset($rows[$x2])) continue;

                    $rows[$x2][$y] = 0;
                }
            }
        }

        unset($rows[$x]);
    }
}

//Get all the possibles broken links
foreach($rows as $row) {
    foreach(array_filter($row) as $link => $filler) $brokenLinks[$link] = 1;
}

if(count($brokenLinks) > $failures) exit("AMBIGUOUS"); //Too many possible broken links

ksort($brokenLinks); //We want them in ascending order

echo implode(" ", array_keys($brokenLinks)) . PHP_EOL;
