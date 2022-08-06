<?php

fscanf(STDIN, "%d", $N);
$piles = array_map('intval', explode(" ", fgets(STDIN)));
$turn = 1;

//Search for the loop
while($turn++) {
    $piles = array_filter($piles); //Remove piles that are empty

    sort($piles);
    $state = implode(" ", $piles); //The  state of the piles

    //Stop if we reach a loop 
    if(isset($history[$state])) exit(strval($turn - $history[$state]));
    else $history[$state] = $turn;

    array_walk($piles, function(&$v) { return $v--; }); //Remove 1 from each piles

    $piles[] = count($piles); //New pile size is just the count of existing piles
}
?>
