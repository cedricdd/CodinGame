<?php

$start = microtime(1);

fscanf(STDIN, "%d %d %d", $nBans, $nSubstitutions, $nNicknames);

for ($i = 0; $i < $nBans; $i++) {
    $bannedWords[] = trim(fgets(STDIN));
}
for ($i = 0; $i < $nSubstitutions; $i++) {
    $substitution = str_replace(" ", "", trim(fgets(STDIN)));

    foreach(str_split($substitution) as $c) $substitutions[$c] = $substitution;
}

//For each characters in the banned words we use the substitutions if they exist and we escape non alphanumerial characters
foreach($bannedWords as $i => $word) {
    $updatedWord = "";

    foreach(str_split($word) as $c) {
        if(isset($substitutions[$c])) $updatedWord .= "[" . preg_replace("/([^a-zA-Z0-9])/", "\\\\$1", $substitutions[$c]) . "]";
        else $updatedWord .= (ctype_alnum($c) ? "" : "\\") . $c;
    }

    $bannedWords[$i] = $updatedWord;
}

$wordBanned = 0;

for ($i = 0; $i < $nNicknames; $i++) {
    $nickname = trim(fgets(STDIN));

    //Check if the nickname is contained in any of the banned words with regex
    foreach($bannedWords as $word) {
        if(preg_match("/.*" . $word . ".*/", $nickname)) {
            ++$wordBanned;
            break;
        }
    }
}

echo $wordBanned . PHP_EOL;

error_log(microtime(1) - $start);
