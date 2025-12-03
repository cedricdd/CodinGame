<?php

function interceptVelocity($pex, $pey, $pez, $vex, $vey, $vez, $pgx, $pgy, $pgz, $vp) {
    $eps = 1e-12;

    // r = p - g
    $rx = $pex - $pgx;
    $ry = $pey - $pgy;
    $rz = $pez - $pgz;

    // u = plane velocity
    $ux = $vex;
    $uy = $vey;
    $uz = $vez;

    $r_dot_u = $rx*$ux + $ry*$uy + $rz*$uz;
    $u_sq = $ux*$ux + $uy*$uy + $uz*$uz;
    $r_sq = $rx*$rx + $ry*$ry + $rz*$rz;

    $a = $u_sq - $vp*$vp;
    $b = 2.0 * $r_dot_u;
    $c = $r_sq;

    $ts = [];

    if (abs($a) < $eps) {
        // Linear case: b t + c = 0
        if (abs($b) < $eps) {
            if (abs($c) < $eps) {
                exit("Impossible");
            }
            exit("Impossible");
        }
        $t = -$c / $b;
        if ($t > $eps) {
            $ts[] = $t;
        }
    } else {
        // Quadratic
        $disc = $b*$b - 4.0*$a*$c;
        if ($disc >= -$eps) {
            if ($disc < 0) $disc = 0;
            $sqrt_d = sqrt($disc);

            $t1 = (-$b - $sqrt_d) / (2.0*$a);
            $t2 = (-$b + $sqrt_d) / (2.0*$a);

            if ($t1 > $eps) $ts[] = $t1;
            if ($t2 > $eps) $ts[] = $t2;
        }
    }

    if (count($ts) === 0) exit("Impossible");

    // Choose earliest hit time
    $t_hit = min($ts);

    // v_p = (r + u*t) / t
    $vpx = ($rx + $ux*$t_hit) / $t_hit;
    $vpy = ($ry + $uy*$t_hit) / $t_hit;
    $vpz = ($rz + $uz*$t_hit) / $t_hit;

    // Normalize to exact speed vp (fix tiny numerical error)
    $mag = sqrt($vpx*$vpx + $vpy*$vpy + $vpz*$vpz);

    if ($mag < $eps) exit("Impossible");

    $scale = $vp / $mag;
    $vpx *= $scale;
    $vpy *= $scale;
    $vpz *= $scale;

    return [$vpx, $vpy, $vpz, $t_hit];
}

fscanf(STDIN, "%f %f %f", $pex, $pey, $pez);
fscanf(STDIN, "%f %f %f", $vex, $vey, $vez);
fscanf(STDIN, "%f %f %f", $pgx, $pgy, $pgz);
fscanf(STDIN, "%f", $vp);

[$vpx, $vpy, $vpz, $time] = interceptVelocity($pex, $pey, $pez, $vex, $vey, $vez, $pgx, $pgy, $pgz, $vp);

echo number_format($vpx, 4) . " " . number_format($vpy, 4) . " " . number_format($vpz, 4) . PHP_EOL . number_format($time, 4) . PHP_EOL;
