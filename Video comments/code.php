<?php

const PRIORITY = ["Pinned" => 0, "Followed" => 1, "none" => 2];

function sortComments(array $a, array $b) {
    if($a[3] == $b[3]) {
        if($a[2] == $b[2]) return $b[1] <=> $a[1]; //Sort by date
        else return $b[2] <=> $a[2]; //Sort by likes
    }
    else return PRIORITY[$a[3]] <=> PRIORITY[$b[3]]; //Sort by priority
}

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $comment = rtrim(fgets(STDIN));
    //It's a reply
    if($comment[0] == " ") $replies[array_key_last($comments)][] = explode("|", $comment);
    //It's a comment
    else $comments[] = explode("|", $comment);
}

uasort($comments, "sortComments");

foreach($comments as $i => $comment) {
    echo implode("|", $comment) . PHP_EOL;
    
    //Sort & display replies to the comment
    if(isset($replies[$i])) {
        usort($replies[$i], "sortComments");
        echo implode("\n", array_map(function($reply) {
            return implode("|", $reply);
        }, $replies[$i])) . PHP_EOL;
    }
}
