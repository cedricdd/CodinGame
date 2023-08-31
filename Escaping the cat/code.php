<?php

const NBR_OF_POINTS = 2400;
const MOUSESPEED = 10;
const ADDITIONAL_ANGLE = 0.174533; //10° in radian

function drawCirclePoints($nbrOfPoints, $radius) {
    $points = [];

    $slice = (2 * pi()) / $nbrOfPoints;

    for($i=0; $i < $nbrOfPoints; $i++){
        $angle = $slice * $i;
        $newX = (int)($radius * cos($angle));
        $newY = (int)($radius * sin($angle));
        
        $points[] = [$newX, $newY];
    }
    
    return $points;
}

fscanf(STDIN, "%d", $catSpeed);

error_log("Cat speed is $catSpeed");

//The radius where if mouse is below it can complete a circle faster than the cat and so increase the angle
$radius = (floor(500 * (MOUSESPEED / $catSpeed)) - MOUSESPEED);
$points = drawCirclePoints(NBR_OF_POINTS, $radius);
$rushX = $rushY = 0;
$prevCatX = $prevCatY = 0;
$catDirection = NULL;


while (TRUE) {
    fscanf(STDIN, "%d %d %d %d", $mouseX, $mouseY, $catX, $catY);

    $catPositions[] = [$catX, $catY];

    //We are rushing to the border
    if($rushX != 0 && $rushY != 0) {
        echo "$rushX $rushY Rushing to border\n";
        continue;
    }

    //Determine if the cat is moving clockwise or anti-clockwise
    if($prevCatX != 0 && $prevCatY != 0) {
        if((($prevCatX ^ $catX) < 0)) {
            //Going to the left
            if($prevCatX > $catX) {
                if($catY > 0) $catDirection = "anti-clockwise";
                else $catDirection = "clockwise";
            } //Going to the right
            else {
                if($catY > 0) $catDirection = "clockwise";
                else $catDirection = "anti-clockwise";  
            }
        }
        if((($prevCatY ^ $catY) < 0)) {
            //Going to the botom
            if($prevCatY > $catY) {
                if($catX > 0) $catDirection = "clockwise";
                else $catDirection = "anti-clockwise";
            } //Going to the top
            else {
                if($catX > 0) $catDirection = "anti-clockwise";
                else $catDirection = "clockwise";  
            }
        }
    }

    if($mouseX == 0 && $mouseY == 0) $angle = 0.0;
    else $angle = rad2deg(acos(($mouseX * $catX + $mouseY * $catY) / (sqrt(($mouseX ** 2) + ($mouseY ** 2)) * sqrt(($catX ** 2) + ($catY ** 2)))));

    error_log("MX $mouseX MY $mouseY -- CX $catX CY $catY -- angle is $angle -- cat direction $catDirection");

    $distanceFromCenter = sqrt(($mouseX ** 2) + ($mouseY ** 2));

    //If the we have reached our goal angle while being in right zone we can rush to the border
    if($angle >= 175.0 && $distanceFromCenter >= ($radius - MOUSESPEED)  && $distanceFromCenter <= ($radius + MOUSESPEED)) {
        //Use the opposite of the current cat position
        $x = ($catX * -1);
        $y = ($catY * -1); 

        //Add an extra angle for the inertia of the cat
        if($catDirection == "clockwise") {
            $rushX = intval($x * cos(ADDITIONAL_ANGLE) + $y * sin(ADDITIONAL_ANGLE));
            $rushY = intval($y * cos(ADDITIONAL_ANGLE) - $x * sin(ADDITIONAL_ANGLE));
        } else {
            $rushX = intval($x * cos(ADDITIONAL_ANGLE) - $y * sin(ADDITIONAL_ANGLE));
            $rushY = intval($y * cos(ADDITIONAL_ANGLE) + $x * sin(ADDITIONAL_ANGLE));
        }

        //Make sure we are outside of the pool
        $rushX += ($rushX > 0) ? 10 : -10;
        $rushY += ($rushY > 0) ? 10 : -10;
    }

    $targetX = 0;
    $targetY = 0;
    $distance = 0.0;

    for($i = 0; $i < NBR_OF_POINTS; ++$i) {
        [$x, $y] = $points[$i];
        $d = sqrt((($catX - $x) ** 2) + (($catY - $y) ** 2));

        if($d > $distance) {
            $distance = $d;
            $targetX = $x;
            $targetY = $y;
        }
    }

    $prevCatX = $catX;
    $prevCatY = $catY;

    echo "$targetX $targetY Building the angle\n";
}
