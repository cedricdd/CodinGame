<?php

fscanf(STDIN, "%d", $lsize);
fscanf(STDIN, "%d", $rheight);
fscanf(STDIN, "%d", $rwidth);
fscanf(STDIN, "%d", $theight);
$characters = explode(" ", trim(fgets(STDIN)));
$shapes = explode(" ", trim(fgets(STDIN)));

//Unsuported shapes need to be displayed first
foreach($shapes as $i => $shape) {
    if(!in_array($shape, ["LINE", "RECTANGLE", "TRIANGLE", "REVERSE_TRIANGLE"])) {
        $answer[] = ["$shape IS NOT A SHAPE"];
        unset($shapes[$i]);
    }
}

foreach($shapes as $index => $shape) {
    $shapeDisplay = [];

    if($shape == "LINE") {
        $shapeDisplay[] = str_repeat($characters[0], $lsize);
    } elseif($shape == "RECTANGLE") {
        for($y = 0; $y < $rheight; ++$y) {
            if($y == 0 || $y == $rheight - 1) $shapeDisplay[] = str_repeat($characters[1], $rwidth);
            else $shapeDisplay[] = $characters[1] . (($rwidth > 1) ? str_repeat(" ", $rwidth - 2) . $characters[1] : "") ;
        }
    } elseif($shape == "TRIANGLE") {
        for($y = 0; $y < $theight; ++$y) {
            if($y == 0) $shapeDisplay[] = $characters[2];
            elseif($y == $theight - 1) $shapeDisplay[] = str_repeat($characters[2], $theight);
            else $shapeDisplay[] = $characters[2] . str_repeat(" ", $y - 1) . $characters[2];
        }  
    } elseif($shape == "REVERSE_TRIANGLE") {
        for($y = 0; $y < $theight; ++$y) {
            if($y == $theight - 1) $shapeDisplay[] = $characters[2];
            elseif($y == 0) $shapeDisplay[] = str_repeat($characters[2], $theight);
            else $shapeDisplay[] = $characters[2] . str_repeat(" ", $theight - $y - 2) . $characters[2] ;
        }  
    }

    $answer[] = $shapeDisplay;
}

echo implode("\n\n", array_map(function($shape) {
    return implode("\n", $shape);
}, $answer)) . PHP_EOL;
