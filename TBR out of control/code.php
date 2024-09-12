<?php

fscanf(STDIN, "%d", $b);
for ($i = 0; $i < $b; $i++) {
    $titles[] = trim(fgets(STDIN));
}

$titles = array_flip($titles);
$maxRank = 0;
$freed = 0;

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    preg_match("/(.*) ([0-9]+|None)/", trim(fgets(STDIN)), $matches);

    //It's a book we haven't read yet, we can't remove it
    if($matches[2] == 'None') {
        unset($titles[$matches[1]]); //We don't want duplicate
        $booksToBeRead[] = $matches[1];
    } else {
        if($matches[2] > $maxRank) $maxRank = $matches[2]; //Get the highest ranking

        if(!isset($titles[$matches[1]])) $books[$matches[2]][] = $matches[1];
        else $freed++; //It's a duplicate, remove the one we currently have
    }
}

ksort($books);

$placesNeeded = count($titles); //How many books we need to remove from the bookshelf

foreach($books as $rank => $list) {
    if($rank == $maxRank) break;

    unset($books[$rank]); //Remove all the books with this ranking

    if(($freed += count($list)) >= $placesNeeded) break; //We have removed enough books
}

if($freed >= $placesNeeded) {
    $bookshelf = array_merge(array_keys($titles), $booksToBeRead);

    foreach($books as $list) $bookshelf = array_merge($bookshelf, $list);

    sort($bookshelf, SORT_NATURAL); //Books composing her bookshelf ordered by alphabetical

    echo implode("\n", $bookshelf) . PHP_EOL;
} else echo "Your TBR is out of control Clara!" . PHP_EOL;
