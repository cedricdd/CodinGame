<?php

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $emails = explode(" ", trim(fgets(STDIN)));

    foreach($emails as $email1) {
        foreach($emails as $email2) {
            $links[$email1][] = $email2;
            $links[$email2][] = $email1;
        }

        $users[$email1] = 1;
    }
}

$groups = 0;

while($users) {
    ++$groups;

    $toCheck = [array_key_first($users)];

    //Find all the users that are connected to the one we have selected
    while($toCheck) {
        $user = array_pop($toCheck);

        if(!isset($users[$user])) continue;
        else unset($users[$user]);

        foreach($links[$user] as $linkedUser) {
            $toCheck[] = $linkedUser;
        }
    }
}

echo $groups . PHP_EOL;
