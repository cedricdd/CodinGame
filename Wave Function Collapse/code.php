<?php

$characters = [];

fscanf(STDIN, "%d %d", $W1, $H1);
for ($i = 0; $i < $H1; $i++) {
    $line = trim(fgets(STDIN));

    if($i > 0 && $i < $H1 - 1) {
        $characters += array_flip(str_split(substr($line, 1, -1)));
    }

    $prototype[] = $line;
}

error_log(var_export($characters, true));

for($y = 1; $y < $H1 - 3; ++$y) {
    for($x = 1; $x < $W1 - 3; ++$x) {
        $patch = [];

        for($y2 = 0; $y2 < 3; ++$y2) {
            for($x2 = 0; $x2 < 3; ++$x2) {
                $patch[$y2][$x2] = $prototype[$y + $y2][$x + $x2];
            }
        }

        $patches[] = $patch;
    }
}

// error_log(var_export($patches, true));

fscanf(STDIN, "%d %d", $W2, $H2);
for ($i = 0; $i < $H2; $i++) {
    $partial [] = str_split(trim(fgets(STDIN)));
}

// error_log(var_export($partial, true));

for($y = 0; $y < $H2; ++$y) {
    for($x = 0; $x < $W2; ++$x) {
        $possibilities[$y * $W2 + $x] = $partial[$y][$x] == '?' ? $characters : [$partial[$y][$x] => 1];
    }
}

// error_log(var_export($possibilities, true));

// ksort($possibilities);
// $test = "";
// foreach($possibilities as $list) {
//     if(count($list) > 1) $test .= "?";
//     else $test .= array_key_first($list);
// }

// echo implode(PHP_EOL, str_split($test, $W2)) . PHP_EOL;

$testi = 0;

while($testi++ < 10) {
    for($y = 1; $y <= $H2 - 3; ++$y) {
        for($x = 1; $x < $W2 - 3; ++$x) {
            // if($x == 1 && $y == 2){
            //     error_log("at $x $y");
            // }
    
            $updatedPossibilities = [];
    
            //TODO skip is all unknown
            //TODO saves possible patches starting at each positions
            foreach($patches as $index => $patch) {
                // if($x == 1 && $y == 2) {
                //     error_log("testing $index");
                //     foreach($patch as $y2 => $line) {
                //         error_log(implode("", $line));
                //     }
                // }

                foreach($patch as $y2 => $line) {
                    for($x2 = 0; $x2 < 3; ++$x2) {
                        if(!isset($possibilities[($y + $y2) * $W2 + $x + $x2][$line[$x2]])) {
                            // if($x == 1 && $y == 2) {
                            //     error_log("$x2 $y2 should be \"" . $line[$x2] . "\"");
                            //     error_log(var_export($possibilities[($y + $y2) * $W2 + $x + $x2], true));
                            // }
                            
                            continue 3;
                        }
                    }
                }
    
                // if($x == 1 && $y == 2) error_log("at $x $y with can have:");
                // if($x == 1 && $y == 2) error_log(var_export($patch, true));
    
                foreach($patch as $y2 => $line) {
                    for($x2 = 0; $x2 < 3; ++$x2) {
                        $updatedPossibilities[($y + $y2) * $W2 + $x + $x2][$line[$x2]] = 1;
                    }
                }
    
                // error_log(var_export($updatedPossibilities, true));
            }
    
            $possibilities = $updatedPossibilities + $possibilities;
        }
    }
}

ksort($possibilities);
$test = "";
foreach($possibilities as $list) {
    if(count($list) > 1) $test .= "?";
    else $test .= array_key_first($list);
}

echo implode(PHP_EOL, str_split($test, $W2)) . PHP_EOL;
