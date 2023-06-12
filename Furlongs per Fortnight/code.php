<?php

const DISTANCES = [
    "miles" => ["miles" => 1, "furlongs" => 8, "chains" => 80, "yards" => 1760, "feet" => 5280, "inches" => 63360],
    "furlongs" => ["miles" => 1/8, "furlongs" => 1, "chains" => 10, "yards" => 220, "feet" => 660, "inches" => 7920],
    "chains" => ["miles" => 1/80, "furlongs" => 1/10, "chains" => 1, "yards" => 22, "feet" => 66, "inches" => 792],
    "yards" => ["miles" => 1/1760, "furlongs" => 1/220, "chains" => 1/22, "yards" => 1, "feet" => 3, "inches" => 36],
    "feet" => ["miles" => 1/5280, "furlongs" => 1/660, "chains" => 1/66, "yards" => 1/3, "feet" => 1, "inches" => 12],
    "inches" => ["miles" => 1/63360, "furlongs" => 1/7920, "chains" => 1/792, "yards" => 1/36, "feet" => 1/12, "inches" => 1],
];

const TIME = [
    "fortnight" => ["fortnight" => 1, "week" => 2, "day" => 14, "hour" => 336, "minute" => 20160, "second" => 1209600],
    "week" => ["fortnight" => 1/2, "week" => 1, "day" => 7, "hour" => 168, "minute" => 10080, "second" => 604800],
    "day" => ["fortnight" => 1/14, "week" => 1/7, "day" => 1, "hour" => 24, "minute" => 1440, "second" => 86400],
    "hour" => ["fortnight" => 1/336, "week" => 1/168, "day" => 1/24, "hour" => 1, "minute" => 60, "second" => 3600],
    "minute" => ["fortnight" => 1/20160, "week" => 1/10080, "day" => 1/1440, "hour" => 1/60, "minute" => 1, "second" => 60],
    "second" => ["fortnight" => 1/1209600, "week" => 1/604800, "day" => 1/86400, "hour" => 1/3600, "minute" => 1/60, "second" => 1],
];

preg_match("/([0-9]+) ([a-z]+) per ([a-z]+) CONVERT TO ([a-z]+) per ([a-z]+)/", trim(fgets(STDIN)), $matches);

[, $speed, $dist1, $time1, $dist2, $time2] = $matches;

error_log(var_export("$speed, $dist1, $time1, $dist2, $time2", true)); 

echo number_format($speed * DISTANCES[$dist1][$dist2] / TIME[$time1][$time2], 1, ".", "") . " $dist2 per $time2" . PHP_EOL; 
