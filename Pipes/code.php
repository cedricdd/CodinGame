<?php

//Flip an array diagonally 
function flipDiagonally($arr) {
    $out = array();
    foreach ($arr as $key => $subarr) {
        foreach (str_split($subarr) as $subkey => $subvalue) {
            $out[$subkey] = ($out[$subkey] ?? "") . $subvalue;
        }
    }
    return $out;
}

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $info[] = trim(fgets(STDIN));
    $infoToFind[] = str_split($info[$i]);
}

$connectionID = 0;
$connections = []; //0 is no connection, 1 is possible connection, 2 is a certain connection
$blocks = [];

for($y = 0; $y < $n; ++$y) {
    for($x = 0; $x < $n; ++$x) {
        if($x < $n - 1) {
            $blocks[$y][$x]['R'] = $connectionID; 
            $blocks[$y][$x + 1]['L'] = $connectionID; 
            $connections[$connectionID++] = 1;
        }

        if($y < $n - 1) {
            $blocks[$y][$x]['D'] = $connectionID; 
            $blocks[$y + 1][$x]['U'] = $connectionID; 
            $connections[$connectionID++] = 1;
        }
    }
}

//error_log(var_export($blocks, true));

//Remove 1-1 connections
for($y = 0; $y < $n; ++$y) {
    preg_match_all("/1(?=[|]?1)/", $info[$y], $matches, PREG_OFFSET_CAPTURE);

    foreach($matches[0] as [$string, $position]) {
        do {
            $connections[$blocks[$y][$position]['R']] = 0;
            $connections[$blocks[$y][$position + 1]['L']] = 0;
        } while($info[$y][++$position] != 1);
    }
}

$flipped = flipDiagonally($info);

error_log(var_export($flipped, true));

for($x = 0; $x < $n; ++$x) {
    preg_match_all("/1[|]?1/", $flipped[$x], $matches, PREG_OFFSET_CAPTURE);

    foreach($matches[0] as [$string, $position]) {
        do {
            $connections[$blocks[$position][$x]['D']] = 0;
            $connections[$blocks[$position + 1][$x]['U']] = 0;
        } while($info[++$position][$x] != 1);
    }
}

//error_log(var_export($connections, true));

$temp = 0;

while($infoToFind) {
    foreach($infoToFind as $y => $row) {
        if(count($row) == 0) {
            unset($infoToFind[$y]);

            continue;
        }

        foreach($row as $x => $value) {
            error_log("working on $x $y with $value");

            $pipes = intval(str_replace("|", 2, $value));
            $block = $blocks[$y][$x];
            $forced = 0;
            $possible = 0;

            foreach($block as $direction => $id) {
                if($connections[$id] == 2) ++$forced;
                elseif($connections[$id] == 1) ++$possible;
            }

            error_log("forced $forced -- possible $possible -- $pipes");

            if($value == '|' && ($forced + $possible) == 3) {

                error_log("forced bridge connect");

                if(!isset($block['L']) || $connections[$block['L']] == 0 || !isset($block['R']) || $connections[$block['R']] == 0) {
                    $connections[$block['U']] = 2;
                    $connections[$block['D']] = 2;

                    isset($block['L']) && $connections[$block['L']] = 0;
                    isset($block['R']) && $connections[$block['R']] = 0;
                } else {
                    $connections[$block['L']] = 2;
                    $connections[$block['R']] = 2;

                    isset($block['U']) && $connections[$block['U']] = 0;
                    isset($block['D']) && $connections[$block['D']] = 0;
                }

                $forced = 2;
                $possible = 0;
            }

            if($value == 2 && $forced == 1 && $possible == 2) {
                foreach($block as $direction => $id) {
                    if($connections[$id] == 2) {
                        switch($direction) {
                            case 'R': 
                                if(isset($block['L']) && $connections[$block['L']]) {
                                    $connections[$block['L']] = 0;
                                    $possible--;
                                }
                                break;
                            case 'L': 
                                if(isset($block['R']) && $connections[$block['R']]) {
                                    $connections[$block['R']] = 0;
                                    $possible--;
                                }
                                break;
                            case 'D': 
                                if(isset($block['U']) && $connections[$block['U']]) {
                                    $connections[$block['U']] = 0;
                                    $possible--;
                                } 
                                break;
                            case 'U': 
                                if(isset($block['D']) && $connections[$block['D']]) {
                                    $connections[$block['D']] = 0;
                                    $possible--;
                                } 
                                break;
                        }
                    }
                }
            }

            if($forced == $pipes) {
                error_log("ici2");

                //Remove all the possible that are left
                foreach($block as $direction => $id) {
                    if($connections[$id] == 1) {
                        $connections[$id] = 0;

                        error_log("setting id $id as 0");
                    }
                }

                unset($infoToFind[$y][$x]);
            }
            elseif($forced + $possible == $pipes) {

                error_log("ici");

                //Set all the possible as forced & update the neighbords
                foreach($block as $direction => $id) {
                    if($connections[$id] == 1) {
                        $connections[$id] = 2;

                        error_log("setting id $id as 2");
                    }
                }

                unset($infoToFind[$y][$x]);
            }
        }
    }

    if(++$temp == 25) {
        error_log('breaking!!!!!!!');
        break;
    }
}

error_log(var_export($connections, true));

$output = array_fill(0, $n * 3, str_repeat(" ", $n * 3));

foreach($blocks as $y => $row) {
    foreach($row as $x => $block) {
        $count = 0;

        foreach($block as $direction => $id) {
            if($connections[$id] == 0) continue;

            ++$count;

            switch($direction) {
                case 'R': $output[$y * 3 + 1][$x * 3 + 2] = '-'; break;
                case 'L': $output[$y * 3 + 1][$x * 3] = '-';     break;
                case 'D': $output[$y * 3 + 2][$x * 3 + 1] = '|'; break;
                case 'U': $output[$y * 3][$x * 3 + 1] = '|';     break;
            }
        }

        //This is a block connect
        if($info[$y][$x] == '|') {
            if((isset($block['D']) && $connections[$block['D']]) || (isset($block['U']) && $connections[$block['U']])) $output[$y * 3 + 1][$x * 3 + 1] = '|';
            else $output[$y * 3 + 1][$x * 3 + 1] = '-';
        } //Outgoing pipe or block with 2 or 3 adjacent pipes 
        else $output[$y * 3 + 1][$x * 3 + 1] = $count > 1 ? '+' : 'o';
    }
}

echo implode("\n", $output) . PHP_EOL;
