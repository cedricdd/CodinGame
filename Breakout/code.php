<?php

fscanf(STDIN, "%d %d", $bX, $bY);
fscanf(STDIN, "%d %d", $vX, $vY);
fscanf(STDIN, "%d", $pN);
fscanf(STDIN, "%d", $kN);
for ($i = 0; $i < $pN; $i++) {
    fscanf(STDIN, "%d %d", $pX, $pY);

    $paddles[] = [$pX, $pY];
}

// error_log(var_export($paddle, 1));

for ($i = 0; $i < $kN; $i++) {
    fscanf(STDIN, "%d %d %d %d", $kX, $kY, $kStrength, $kPoints);

    $bricks[] = [$kX, $kY, $kStrength, $kPoints];
}

ksort($bricks);

error_log(var_export($bricks, 1));

$paddle = array_shift($paddles);
$score = 0;

while(true) {
    error_log("Ball $bX $bY - $vX $vY");
    error_log("Paddle {$paddle[0]} {$paddle[1]}");

    $hit = [null, 0, 0, INF, ""];

    if($vY < 0) {
        error_log("Moving UP");

        //Checking the bottom of bricks
        foreach($bricks as $ID => [$xBrick, $yBrick]) {
            if($yBrick + 30 >= $bY) continue; //Can't hit there

            $x = $bX + ($vX / $vY) * ($yBrick + 30 - $bY);

            // error_log("Birck at $xBrick $yBrick => $x");

            if($x >= $xBrick && $x <= $xBrick + 100) {
                error_log("Ball is hitting brick ID $ID");

                $d = (($bX - $x) ** 2) + (($bY - $yBrick + 30) ** 2);

                if($d < $hit[3]) $hit = [$ID, $x, $yBrick + 30, $d, 'B'];
            }
        }
    }
    if($vY > 0) {
        error_log("Moving DOWN");

        //Checking the top of bricks
        foreach($bricks as $ID => [$xBrick, $yBrick]) {
            if($yBrick <= $bY) continue; //Can't hit there

            $x = $bX + ($vX / $vY) * ($yBrick - $bY);

            // error_log("Birck at $xBrick $yBrick => $x");

            if($x >= $xBrick && $x <= $xBrick + 100) {
                error_log("Ball is hitting brick ID $ID");

                $d = (($bX - $x) ** 2) + (($bY - $yBrick) ** 2);

                if($d < $hit[3]) $hit = [$ID, $x, $yBrick, $d, 'T'];
            }
        }
    }
    if($vX < 0) {
        error_log("Moving LEFT");

        //Checking the right of bricks
        foreach($bricks as $ID => [$xBrick, $yBrick]) {
            if($xBrick + 100 >= $bX) continue; //Can't hit there

            $y = $bY + ($vX / $vY) * ($xBrick + 100 - $bX);

            // error_log("Birck at $xBrick $yBrick => $x");

            if($y >= $yBrick && $y <= $yBrick + 30) {
                error_log("Ball is hitting brick ID $ID");

                $d = (($bX - $xBrick + 100) ** 2) + (($bY - $y) ** 2);

                if($d < $hit[3]) $hit = [$ID, $xBrick + 100, $y, $d, 'R'];
            }
        }
    }
    if($vX > 0) {
        error_log("Moving RIGHT");

        //Checking the left of bricks
        foreach($bricks as $ID => [$xBrick, $yBrick]) {
            if($xBrick <= $bX) continue; //Can't hit there

            $y = $bY + ($vX / $vY) * ($xBrick - $bX);

            // error_log("Birck at $xBrick $yBrick => $x");

            if($y >= $yBrick && $y <= $yBrick + 30) {
                error_log("Ball is hitting brick ID $ID");

                $d = (($bX - $xBrick) ** 2) + (($bY - $y) ** 2);

                if($d < $hit[3]) $hit = [$ID, $xBrick, $y, $d, 'L'];
            }
        }
    }

    error_log(var_export($hit, 1));

    if($hit[0] === null) {
        error_log("Not hitting any brick!");

        //Check top border
        if($vY < 0) {
            $xTop = $bX + ($vX / $vY) * (0 - $bY);

            if($xTop >= 0 && $xTop <= 1600) {
                error_log("Bouncing off Top - $xTop");

                $bX = $xTop;
                $bY = 0;
                $vY *= -1;
                continue;
            }
        }

        //Check left border
        if($vX < 0) {
            $yLeft = $bY + ($vX / $vY) * (0 - $bX);

            if($yLeft >= 0 && $yLeft <= 2400) {
                error_log("Bouncing off Left - $yLeft");

                $bX = 0;
                $bY = $yLeft;
                $vX *= -1;
                continue;
            }
        }

        //Check right border
        if($vX > 0) {
            $yRight = $bY + ($vX / $vY) * (1600 - $bX);

            if($yRight >= 0 && $yRight <= 2400) {
                error_log("Bouncing off Right - $yRight");

                $bX = 1600;
                $bY = $yRight;
                $vX *= -1;
                continue;
            }
        }

        //Check paddle
        if($vY > 0) {
            $xPaddle = $bX + ($vX / $vY) * ($paddle[1] - $bY);

            if($xPaddle >= $paddle[0] && $xPaddle <= $paddle[0] + 200) {
                error_log("Ball bounde off paddle");

                $bX = $xPaddle;
                $bY= $paddle[1];
                $vY *= -1;

                if($paddles) $paddle = array_shift($paddles); //Paddle moves
            } else {
                error_log("Ball miss the paddle, it's out");

                break;
            }
        }
    } else {
        //Brick isn't destroyed
        if($bricks[$hit[0]][2] > 1) $bricks[$hit[0]][2]--;
        else {
            $score += $bricks[$hit[0]][3];
            unset($bricks[$hit[0]]);
        }

        $bX = $hit[1];
        $bY = $hit[2];

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
