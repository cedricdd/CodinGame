<?php

fscanf(STDIN, "%d", $height);
fscanf(STDIN, "%d", $width);
fscanf(STDIN, "%d", $numberOfShelves);

$minBookcase = floor(($height - 1) / $numberOfShelves);
$maxBookcase = ceil(($height - 1) / $numberOfShelves);

//Decorative top
$answer[] = str_repeat("/", $width >> 1) . (($width & 1) ? "^" : "") . str_repeat("\\", $width >> 1) ;

$floor = $height - 1;

//Add the bookcases
while(true) {
    $answer[$floor] = "|" . str_repeat("_", $width - 2) . "|";
    
    if(--$numberOfShelves == 0) break;

    $floor -= (($floor - $maxBookcase) / $numberOfShelves >= $minBookcase) ? $maxBookcase : $minBookcase;
}

for($i = 0; $i < $height; ++$i) {
    echo ($answer[$i] ?? "|" . str_repeat(" ", $width - 2) . "|") . PHP_EOL;
}
