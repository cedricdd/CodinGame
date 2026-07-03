<?php

const COLORS = [
    'Red' =>    [0, -32],
    'Yellow' => [5, -993],
    'Green' =>  [10, -31745],
    'Blue' =>   [15, -1015809],
    'White' =>  [20, -32505857],
    'Black' =>  [25, -1040187393],
    'Orange' => [30, -33285996545],
    'Pink' =>   [35, -1065151889409],
    'Gray' =>   [40, -34084860461057],
];
const SCORE_LEN = [0, 1, 2, 4, 7, 0, 15];

/**
 * For each of the tickets we are searching for all the paths (route needed) to validate the ticket
 */
function findAllTicketPaths(array &$tickets, array $links): int {
    $lostScore = 0; //A ticket that's imposible to validate is sure to produce a negative score

    foreach ($tickets as $ticketIndex => [$points, $startCity, $targetCity]) {
        $pathsForThisTicket = [];
        $queue = [[$startCity, [$startCity => -1]]];

        while($queue) {
            [$city, $path] = array_pop($queue);

            //We reached the target
            if($city == $targetCity) {
                $pathsForThisTicket[] = $path;
                continue;
            } 

            foreach(($links[$city] ?? []) as $neighbor => $routeIDs) {
                //Don't go to the same town twice
                if(!isset($path[$neighbor])) {
                    foreach($routeIDs as $routeID) $queue[] = [$neighbor, $path + [$neighbor => $routeID]];
                }
            }
        }

        //It's impossible to complete this ticket
        if(count($pathsForThisTicket) == 0) {
            unset($tickets[$ticketIndex]);

            $lostScore += $points;
        } else {
            $ticketMasks = [];

            //Get the mask of the routes needed to complete the ticket
            foreach($pathsForThisTicket as $list) {
                $mask = 0;
                
                foreach($list as $routeID) {
                    if($routeID == -1) continue;

                    $mask |= (1 << $routeID);
                }

                $ticketMasks[] = $mask;
            }

            //Sort masks by bit count (shortest paths first), the less route used the highest the chance we match early
            usort($ticketMasks, function($a, $b) { 
                return substr_count(decbin($a), '1') <=> substr_count(decbin($b), '1');
            });
            
            $tickets[$ticketIndex][3] = $ticketMasks;
        }
    }

    return $lostScore;
}

/**
 * Get the score from tickets with the given routes
 */
function getTicketScore(int $build): int {
    global $tickets, $lostScore;
    static $history = [];

    if(isset($history[$build])) return $history[$build];

    $score = $lostScore * -1;

    foreach($tickets as $i => [$points, $_, $_, $masks]) {
        //Test all the ways to complete this ticket
        foreach($masks as $mask) {
            //This ticket is completed
            if(($mask & $build) == $mask) {
                $score += $points;

                continue 2;
            }
        }

        $score -= $points;
    }

    return $history[$build] = $score;
}

function solve(int $index, int $trainCars, int $cards, $currentScore = 0, int $build = 0) {
    global $routes, $maxScore, $bestScore, $maskTicket;
    static $history = [];

    //We know we can't beat our current best score
    if($index >= 0 && $currentScore + getTicketScore($build | $maskTicket[$index]) + $maxScore[$index][$trainCars] <= $bestScore) return;

    if(isset($history[$cards][$build])) return;
    $history[$cards][$build] = true;

    $Gray = ($cards >> 40) & 0x1F;

    $routeBuild = false;

    for($routeIndex = $index; $routeIndex >= 0; --$routeIndex) {
        [$length, $requiredEngines, $colorRoute, $cityA, $cityB] = $routes[$routeIndex];

        //Impossible to build that route, ressources missing
        if($length > $trainCars || $requiredEngines > $Gray) continue;

        $onlyGrayUsed = false;

        if($colorRoute == "Gray") {
            //For grey route we can use any colors
            foreach(COLORS as $color => [$shift, $mask]) {
                if($color === 'Gray') continue;

                $colorCount = ($cards >> $shift) & 0x1F;

                if($colorCount == 0 && $onlyGrayUsed) continue; //We have already used only engines

                if($colorCount + $Gray >= $length) {
                    $colorUsed = min($colorCount, $length - $requiredEngines); //We used as few engines as possible
                    $engineUsed = $length - $colorUsed;

                    $cardsUpdated = $cards;
                    $cardsUpdated &= $mask;
                    $cardsUpdated |= (($colorCount - $colorUsed) << $shift);

                    $cardsUpdated &= COLORS['Gray'][1];
                    $cardsUpdated |= (($Gray - $engineUsed) << 40);

                    solve($routeIndex - 1, $trainCars - $length, $cardsUpdated, $currentScore + SCORE_LEN[$length], ($build | (1 << $routeIndex)));

                    $routeBuild = true;
                    if($colorCount == 0) $onlyGrayUsed = true; //If we use only engines we don't want to repeat it several times
                }
            }
        } else {
            $shift = COLORS[$colorRoute][0];
            $mask = COLORS[$colorRoute][1];
            $color = ($cards >> $shift) & 0x1F;

            //Not enough cards to build that route
            if(($color + $Gray) < $length) continue;

            $colorUsed = min($color, $length - $requiredEngines);
            $engineUsed = $length - $colorUsed;

            $cardsUpdated = $cards;
            $cardsUpdated &= $mask;
            $cardsUpdated |= (($color - $colorUsed) << $shift);

            $cardsUpdated &= COLORS['Gray'][1];
            $cardsUpdated |= (($Gray - $engineUsed) << 40);

            solve($routeIndex - 1, $trainCars - $length, $cardsUpdated, $currentScore + SCORE_LEN[$length], ($build | (1 << $routeIndex)));

            $routeBuild = true;
        }
    }

    if($routeBuild == false) {
        $score = $currentScore + getTicketScore($build);

        if($score > $bestScore) $bestScore = $score;
    }
}

$bestScore = PHP_INT_MIN;
$tickets = [];
$routes = [];
$links = [];
$routeIndex = 0;
$start = microtime(1);

fscanf(STDIN, "%d %d %d", $trainCars, $numTickets, $numRoutes);
fscanf(STDIN, "%d %d %d %d %d %d %d %d %d", $Red, $Yellow, $Green, $Blue, $White, $Black, $Orange, $Pink, $Gray);

//We store all the cards in a single int
$cards = $Red | ($Yellow << 5) | ($Green << 10) | ($Blue << 15) | ($White << 20) | ($Black << 25) | ($Orange << 30) | ($Pink << 35) | ($Gray << 40);

for ($i = 0; $i < $numTickets; $i++) {
    fscanf(STDIN, "%d %s %s", $points, $cityA, $cityB);

    $tickets[] = [$points, $cityA, $cityB];
}

for ($i = 0; $i < $numRoutes; $i++) {
    fscanf(STDIN, "%d %d %s %s %s", $length, $requiredEngines, $color, $cityA, $cityB);

    if($color != 'Gray' && ($$color + $Gray) < $length) continue; //Not enough cards for this route
    elseif($requiredEngines > $Gray) continue; //Not enough engines for this route
    elseif($length > $trainCars) continue; //Not enough cars for this route
    else {
        $routes[$routeIndex] = [$length, $requiredEngines, $color, $cityA, $cityB];

        $links[$cityA][$cityB][] = $routeIndex;
        $links[$cityB][$cityA][] = $routeIndex;

        $routeIndex++;
    }
}

$numRoutes = count($routes); //Don't count the one we might have already eliminated

if($numRoutes == 0) die("" . (array_sum(array_column($tickets, 0)) * -1)); //No routes, all the tickets fail

$lostScore = findAllTicketPaths($tickets, $links);

//For each route index with every possible number of cars left we want to know how much points we can still gain from routes (ignoring the cards)
$maxScore = array_fill(-1, $numRoutes + 1, array_fill(0, $trainCars + 1, 0));
for($i = 0; $i < $numRoutes; ++$i) {
    $length = $routes[$i][0];
    $score = SCORE_LEN[$length];

    for($t = 0; $t <= $trainCars; ++$t) {
        //We can't build the route
        if($t < $length) $maxScore[$i][$t] = $maxScore[$i - 1][$t];
        else $maxScore[$i][$t] = max($maxScore[$i - 1][$t], $maxScore[$i - 1][$t - $length] + $score);
    }
}

unset($links); //Don't need these anymore

//Generate the mask to simulate the construction of all the possible routes left at a given index
for($i = 1; $i <= $numRoutes; ++$i) $maskTicket[$i - 1] = (1 << $i) - 1;

solve($numRoutes - 1, $trainCars, $cards);

echo $bestScore . PHP_EOL;
error_log(microtime(1) - $start);
