<?php

fscanf(STDIN, "%d", $people);
fscanf(STDIN, "%d", $links);

$groups = range(0, $people - 1);
for($i = 0; $i < $people; ++$i) {
    $clusters[$i] = [$i => 1];
}

for ($i = 0; $i < $links; $i++) {
    [$a, $b] = explode(" ", stream_get_line(STDIN, 1024 + 1, "\n"));

    //People in the link are currently in different clusters
    if($groups[$a] != $groups[$b]) {

        $cluster = $clusters[$groups[$b]];
        unset($clusters[$groups[$b]]);

        //Update all the people in the group we remove
        foreach($cluster as $index => $filler) {
            $groups[$index] = $groups[$a];
        }

        $clusters[$groups[$a]] += $cluster; //Merge the clusters
    }
}

//Get the # of people in each clusters and group them
$sizes = array_count_values(array_map(function($cluster) {
    return count($cluster);
}, $clusters));

krsort($sizes);

foreach($sizes as $size => $frequency) echo $size . " " . $frequency . PHP_EOL;
?>
