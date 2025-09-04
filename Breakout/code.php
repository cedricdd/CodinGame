<?php

$start = microtime(1);

fscanf(STDIN, "%d %d", $bX, $bY);
fscanf(STDIN, "%d %d", $vX, $vY);
fscanf(STDIN, "%d", $pN);
fscanf(STDIN, "%d", $kN);

for ($i = 0; $i < $pN; $i++) {
    fscanf(STDIN, "%d %d", $pX, $pY);

    $paddles[] = [$pX, $pY];
}

for ($i = 0; $i < $kN; $i++) {
    fscanf(STDIN, "%d %d %d %d", $kX, $kY, $kStrength, $kPoints);

    $bricks[] = [$kX, $kY, $kStrength, $kPoints];
}

$paddle = array_shift($paddles);
$score = 0;

while(true) {
    $hit = [null, 0, 0, INF, ""];

    /**
     * For the distance there's no need to bother with the sqrt, we just want to compare them, we don't need the real value
     */
    foreach($bricks as $ID => [$xBrick, $yBrick]) {
        //Checking the bottom of the brick
        if($vY < 0 && $yBrick + 30 < $bY) {
            $x = $bX + ($vX / $vY) * ($yBrick + 30 - $bY);

            if($x >= $xBrick && $x <= $xBrick + 100) {
                $d = (($bX - $x) ** 2) + (($bY - $yBrick - 30) ** 2);

                if($d < $hit[3]) $hit = [$ID, $x, $yBrick + 30, $d, 'B'];
            }
        }
        //Checking the top of the brick
        if($vY > 0 && $yBrick > $bY) {
            $x = $bX + ($vX / $vY) * ($yBrick - $bY);

            if($x >= $xBrick && $x <= $xBrick + 100) {
                $d = (($bX - $x) ** 2) + (($bY - $yBrick) ** 2);

                if($d < $hit[3]) $hit = [$ID, $x, $yBrick, $d, 'T'];
            }
        }
        //Checking the right of the brick
        if($vX < 0 && $xBrick + 100 < $bX) {
            $y = $bY + ($vY / $vX) * ($xBrick + 100 - $bX);

            if($y >= $yBrick && $y <= $yBrick + 30) {
                $d = (($bX - $xBrick - 100) ** 2) + (($bY - $y) ** 2);

                if($d < $hit[3]) $hit = [$ID, $xBrick + 100, $y, $d, 'R'];
            }
        }
        //Checking the left of the brick
        if($vX > 0 && $xBrick > $bX) {
            $y = $bY + ($vY / $vX) * ($xBrick - $bX);

            if($y >= $yBrick && $y <= $yBrick + 30) {
                $d = (($bX - $xBrick) ** 2) + (($bY - $y) ** 2);

                if($d < $hit[3]) $hit = [$ID, $xBrick, $y, $d, 'L'];
            }
        }
    }

    //Not hitting any brick!
    if($hit[0] === null) {
        //Check top border
        if($vY < 0) {
            $xTop = $bX + ($vX / $vY) * (0 - $bY);

            if($xTop >= 0 && $xTop <= 1600) {
                $bX = $xTop;
                $bY = 0;
                $vY *= -1;
                continue;
            }
        }

        //Check paddle
        if($vY > 0) {
            $xPaddle = $bX + ($vX / $vY) * (2300 - $bY);

            //Ball bounce off paddle
            if($xPaddle >= $paddle[0] && $xPaddle <= $paddle[0] + 200) {
                $bX = $xPaddle;
                $bY= $paddle[1];
                $vY *= -1;

                if($paddles) $paddle = array_shift($paddles); //Paddle moves

                continue;
            } 
        }

        //Check left border
        if($vX < 0) {
            $yLeft = $bY + ($vY / $vX) * (0 - $bX);

            if($yLeft >= 0 && $yLeft <= 2400) {
                $bX = 0;
                $bY = $yLeft;
                $vX *= -1;
                continue;
            }
        }

        //Check right border
        if($vX > 0) {
            $yRight = $bY + ($vY / $vX) * (1600 - $bX);

            if($yRight >= 0 && $yRight <= 2400) {
                $bX = 1600;
                $bY = $yRight;
                $vX *= -1;
                continue;
            }
        }

        break; //Ball miss the paddle, it's out.
    } //We are hitting a brick
    else {
        //Brick isn't destroyed
        if($bricks[$hit[0]][2] > 1) $bricks[$hit[0]][2]--;
        else {
            $score += $bricks[$hit[0]][3];
            unset($bricks[$hit[0]]);
        }

        //Move ball
        $bX = $hit[1];
        $bY = $hit[2];

        //Update direction vector
        switch($hit[4]) {
            case 'T':
            case 'B': $vY *= -1; break;
            case 'L': 
            case 'R': $vX *= -1; break;
            default: exit("Invalid Value!");
        }
    }
}

echo $score . PHP_EOL;
error_log(microtime(1) - $start);
