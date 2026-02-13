<?php

fscanf(STDIN, "%d", $n);
$path[0] = stream_get_line(STDIN, $n + 1, "\n");
$path[1] = stream_get_line(STDIN, $n + 1, "\n");
$blank = str_repeat("o", $n);

error_log($path[0] . "\n" . $path[1] . "\n");

if($path[0] == $blank && $path[1] == $blank) exit("0");

$turn = 0;

while(true) {
    //People on the top that can move directly right
    preg_match_all("/R+(?=$|o)/", $path[0], $matches, PREG_OFFSET_CAPTURE);

    // error_log(var_export($matches[0], 1));

    foreach($matches[0] as [$string, $offset]) {
        $path[0] = substr(substr_replace($path[0], 'o' . strtolower($string), $offset, 1 + strlen($string)), 0, $n); 
    }

    // //People on the top that can move right after someone moves down
    // preg_match_all("/R+(?=L.{" . ($n - 1) . "}o)/", $path[0] . $path[1], $matches, PREG_OFFSET_CAPTURE);

    // // error_log(var_export($matches[0], 1));

    // foreach($matches[0] as [$string, $offset]) {
    //     $path[0] = substr(substr_replace($path[0], 'o' . strtolower($string), $offset, 1 + strlen($string)), 0, $n); 
    //     $path[1][$offset + strlen($string)] = 'l';
    // }

    //People on the bottom that can move directly left
    preg_match_all("/(?<=^|o)L+/", $path[1], $matches, PREG_OFFSET_CAPTURE);

    // error_log(var_export($matches[0], 1));

    foreach($matches[0] as [$string, $offset]) {
        if($offset == 0) $path[1] = substr(strtolower($string), 1) . 'o' . substr($path[1], strlen($string));
        else $path[1] = substr(substr_replace($path[1], strtolower($string) . 'o', $offset - 1, 1 + strlen($string)), 0, $n); 
    }

    // //People on the bottom that can move left after someone moves up
    // preg_match_all("/(?<=o.{" . ($n - 1) . "}R)L+/", $path[0] . $path[1], $matches, PREG_OFFSET_CAPTURE);

    // // error_log(var_export($matches[0], 1));

    // foreach($matches[0] as [$string, $offset]) {
    //     $offset -= $n;

    //     $path[0][$offset - 1] = 'r';
    //     $path[1] = substr(substr_replace($path[1], strtolower($string) . 'o', $offset - 1, 1 + strlen($string)), 0, $n); 
    // }

    //Ring around the rosse
    preg_match_all("/(?:^|(?<=[oL]))R+L/", $path[0], $matches, PREG_OFFSET_CAPTURE);

    // error_log(var_export($matches[0], 1));

    foreach($matches[0] as [$string, $offset]) {
        $len = strlen($string);

        if(preg_match("/^.{" . $offset . "}RL{" . ($len - 1) . "}(?:$|(?=[oR]))/", $path[1])) {
            // error_log(var_export("here", 1));
            $path[0] = substr_replace($path[0], str_repeat('r', $len), $offset, $len);
            $path[1] = substr_replace($path[1], str_repeat('l', $len), $offset, $len);
        } 
    }

    // error_log($path[0] . "\n" . $path[1] . "\n");
    // die();

    //Person on top that wants to go left moves down if possible
    preg_match_all("/L(?=.{" . ($n - 1) . "}o)/", $path[0] . $path[1], $matches, PREG_OFFSET_CAPTURE);

    // error_log(var_export($matches[0], 1));

    if(count($matches[0]) > 0) {
        foreach($matches[0] as [$string, $offset]) {
            [$path[0][$offset], $path[1][$offset]] = [strtolower($path[1][$offset]), strtolower($path[0][$offset])];
        }

        continue;
    }

    //Person on bottom that wants to go right moves up if possible
    preg_match_all("/o(?=.{" . ($n - 1) . "}R)/", $path[0] . $path[1], $matches, PREG_OFFSET_CAPTURE);

    // error_log(var_export($matches[0], 1));
    if(count($matches[0]) > 0) {
        foreach($matches[0] as [$string, $offset]) {
            [$path[0][$offset], $path[1][$offset]] = [strtolower($path[1][$offset]), strtolower($path[0][$offset])];
        }

        continue;
    }

    //Person on top that wants to go left and person on bottom that wants to go right swap
    preg_match_all("/L(?=.{" . ($n - 1) . "}R)/", $path[0] . $path[1], $matches, PREG_OFFSET_CAPTURE);

    // error_log(var_export($matches[0], 1));

    if(count($matches[0]) > 0) {
        foreach($matches[0] as [$string, $offset]) {
            [$path[0][$offset], $path[1][$offset]] = [strtolower($path[1][$offset]), strtolower($path[0][$offset])];
        }

        continue;
    }
    
    //People stuck on the bottom that move right as fallback
    preg_match_all("/[R]+(?=$|o)/", $path[1], $matches, PREG_OFFSET_CAPTURE);

    // error_log(var_export($matches[0], 1));

    foreach($matches[0] as [$string, $offset]) {
        $path[1] = substr(substr_replace($path[1], 'o' . strtolower($string), $offset, 1 + strlen($string)), 0, $n); 
    }

    //People stuck on the top that move left as fallback
    preg_match_all("/(?<=^|o)[L]+/", $path[0], $matches, PREG_OFFSET_CAPTURE);

    // error_log(var_export($matches[0], 1));

    foreach($matches[0] as [$string, $offset]) {
        if($offset == 0) $path[0] = substr(strtolower($string), 1) . 'o' . substr($path[0], strlen($string));
        else $path[0] = substr(substr_replace($path[0], strtolower($string) . 'o', $offset - 1, 1 + strlen($string)), 0, $n);
    }

    error_log($path[0] . "\n" . $path[1] . "\n");

    ++$turn; 

    if($path[0] == $blank && $path[1] == $blank) break;

    if(strpos($path[0], 'l') === false && strpos($path[1], 'l') === false && strpos($path[0], 'r') === false && strpos($path[1], 'r') === false) exit("Congestion");

    $path[0] = strtr($path[0], "lr", "LR");
    $path[1] = strtr($path[1], "lr", "LR");
}

echo $turn . PHP_EOL;
