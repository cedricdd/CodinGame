<?php

$forumKeyword = stream_get_line(STDIN, 50 + 1, "\n");

fscanf(STDIN, "%d", $n);

for ($i = 0; $i < $n; $i++) {
    [$name, $comment] = explode(":", trim(fgets(STDIN)));

    if(!isset($users[$name])) $users[$name] = 0;

    if(strpos($comment, $forumKeyword) === false) $users[$name]++;
}

$users = array_filter($users); //Remove users that are not getting banned

if(count($users) == 0) echo "NO USERS TO BAN." . PHP_EOL;
else {
    foreach($users as $name => $count) {
        if($count == 1) echo $name . " HAS BEEN TEMPORARILY BANNED." . PHP_EOL;
    }
    foreach($users as $name => $count) {
        if($count > 1) echo $name . "'s ACCOUNT HAS BEEN PERMANENTLY SUSPENDED!" . PHP_EOL;
    }
}
