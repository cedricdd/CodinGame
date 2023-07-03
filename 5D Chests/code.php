<?php

function sieveOfEratosthenes(int $limit): array {

    // Initialise the sieve array
    $primes = array_fill(2, $limit, 1);

    for($i = 2; $i < $limit; ++$i) {
        //This number is still in the sieve, remove all it's multiples
        if(isset($primes[$i])) {
            for($j = $i * 2; $j < $limit; $j += $i) unset($primes[$j]);
        }
    }

    return $primes;
}

$start = microtime(1);

fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d", $C);

$primes = sieveOfEratosthenes(10000);


$visited = [];
$totalCoins = 0;
$numberOfRooms = 0;
$largestGold = 0;

for($v = 1; $v <= $N; ++$v) {
    for($w = 1; $w <= $N; ++$w) {
        for($x = 1; $x <= $N; ++$x) {
            for($y = 1; $y <= $N; ++$y) {
                for($z = 1; $z <= $N; ++$z) {
                    if(isset($visited[$v][$w][$x][$y][$z])) continue; //Already visited

                    //We are in a room, explore it
                    if(isset($primes[1 + (($v * $w * $x * $y * $z) % $C)])) {
                        ++$numberOfRooms;
                        $coins = 0;

                        $toVisit = [[$v, $w, $x, $y, $z]];

                        while(count($toVisit)) {
                            [$v2, $w2, $x2, $y2, $z2] = array_pop($toVisit);

                            if(isset($visited[$v2][$w2][$x2][$y2][$z2])) continue;
                            else $visited[$v2][$w2][$x2][$y2][$z2] = 1;

                            //We are still inside the room
                            if(isset($primes[1 + (($v2 * $w2 * $x2 * $y2 * $z2) % $C)])) {
                                ++$coins;
                                
                                if($v2 < $N) $toVisit[] = [$v2 + 1, $w2, $x2, $y2, $z2]; 
                                if($v2 > 1) $toVisit[] = [$v2 - 1, $w2, $x2, $y2, $z2];
                                if($w2 < $N) $toVisit[] = [$v2, $w2 + 1, $x2, $y2, $z2]; 
                                if($w2 > 1) $toVisit[] = [$v2, $w2 - 1, $x2, $y2, $z2];
                                if($x2 < $N) $toVisit[] = [$v2, $w2, $x2 + 1, $y2, $z2]; 
                                if($x2 > 1) $toVisit[] = [$v2, $w2, $x2 - 1, $y2, $z2];
                                if($y2 < $N)$toVisit[] = [$v2, $w2, $x2, $y2 + 1, $z2]; 
                                if($y2 > 1) $toVisit[] = [$v2, $w2, $x2, $y2 - 1, $z2];
                                if($z2 < $N)$toVisit[] = [$v2, $w2, $x2, $y2, $z2 + 1]; 
                                if($z2 > 1) $toVisit[] = [$v2, $w2, $x2, $y2, $z2 - 1];
                            }
                        }

                        $totalCoins += $coins;
                        $largestGold = max($largestGold, $coins);
                    } 
                }
            }
        }
    }
}

echo $totalCoins . PHP_EOL . $numberOfRooms . PHP_EOL . $largestGold . PHP_EOL;

error_log(microtime(1) - $start);
