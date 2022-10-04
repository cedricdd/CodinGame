<?php

const DIRECTIONS = [
    "A"  => [0 => "N", 1 => "NE", 2 => "E", 3 => "SE", 4 => "S", 5 => "SW", 6 => "W", 7 => "NW"],
    "S"  => [6 => "W", 5 => "SW", 4 => "S", 3 => "SE", 2 => "E"],
    "SE" => [4 => "S", 3 => "SE", 2 => "E"],
    "E"  => [2 => "E", 4 => "S", 3 => "SE", 2 => "E", 1 => "NE", 0 => "N"],
    "NE" => [2 => "E", 1 => "NE", 0 => "N"],
    "N"  => [2 => "E", 1 => "NE", 0 => "N", 7 => "NW", 6 => "W"],
    "NW" => [0 => "N", 7 => "NW", 6 => "W"],
    "W"  => [0 => "N", 7 => "NW", 6 => "W", 5 => "SW", 4 => "S"],
    "SW" => [6 => "W", 5 => "SW", 4 => "S"],
];

class Node
{
    public $x;
    public $y;
    public $givenCost;
    public $finalCost;
    public $parent;

    public function __construct(int $x, int $y) {
        $this->x = $x;
        $this->y = $y;
        $this->givenCost = 0.00;
        $this->finalCost = 0.00;
    }

    //Get coordinate of the node
    public function coordinate(): string {
        return $this->x . " " . $this->y;
    }

    //Get the max distance (x axis or y axis) between 2 nodes
    public function diffNodes(Node $target): int {
        return max(abs($target->x - $this->x), abs($target->y - $this->y));
    }

    //Get the distance on the y axis between 2 nodes
    public function diffNodesCol(Node $target): int {
        return abs($target->y - $this->y);
    }

    //Get the distance on the x axis between 2 nodes
    public function diffNodesRow(Node $target): int {
        return abs($target->x - $this->x);
    }

    //Get the next node given a distance and a direction
    public function getNextNode(int $distance, string $direction): Node {
        switch($direction) {
            case "N":  return new Node($this->x, $this->y - $distance);
            case "NE": return new Node($this->x + $distance, $this->y - $distance);
            case "E":  return new Node($this->x + $distance, $this->y);
            case "SE": return new Node($this->x + $distance, $this->y + $distance);
            case "S":  return new Node($this->x, $this->y + $distance);
            case "SW": return new Node($this->x - $distance, $this->y + $distance);
            case "W":  return new Node($this->x - $distance, $this->y);
            case "NW": return new Node($this->x - $distance, $this->y - $distance);
        }
    }

    //Check if a node is in the exact direction
    public function isInExactDirection(Node $target, string $direction): bool {
        switch($direction) {
            case "N": return $target->y < $this->y && $target->x == $this->x;
            case "W": return $target->y == $this->y && $target->x < $this->x;
            case "S": return $target->y > $this->y && $target->x == $this->x;
            case "E": return $target->y == $this->y && $target->x > $this->x;
        }
    }

    //Check if a node is in a general direction
    public function isInGeneralDirection(Node $target, string $direction): bool {
        switch($direction) {
            case "NW": return $target->y <= $this->y && $target->x <= $this->x;
            case "NE": return $target->y <= $this->y && $target->x >= $this->x;
            case "SW": return $target->y >= $this->y && $target->x <= $this->x;
            case "SE": return $target->y >= $this->y && $target->x >= $this->x;
        }
    }

    //Get the octile distance between 2 nodes
    public function octileDistance(Node $target): float {
        $dx = abs($target->x - $this->x);
        $dy = abs($target->y - $this->y);
        return $dx + $dy + ((sqrt(2) - 2) * min($dx, $dy));
    }  
}

function isCardinal(string $direction): bool {
    return in_array($direction, ["N", "E", "S", "W"]);
}

function isDiagonal(string $direction): bool {
    return in_array($direction, ["NE", "NW", "SE", "SW"]);
}

function getNextNodeToCheck(array &$queue): array {
    $nextIndex = null;
    $nextCost = INF;

    foreach($queue as $index => [$node, $direction]) {
        if($node->finalCost < $nextCost) {
            $nextIndex = $index;
            $nextCost = $node->finalCost;
        }
    } 

    [$node, $direction] = $queue[$nextIndex];
    unset($queue[$nextIndex]);
    
    return [$node, $direction];
}


fscanf(STDIN, "%d %d", $width, $height);
fscanf(STDIN, "%d %d %d %d", $startX, $startY, $targetX, $targetY);

$start = new Node($startX, $startY);
$start->parent = new Node(-1, -1);
$target = new Node($targetX, $targetY);

fscanf(STDIN, "%d", $open);
for ($i = 0; $i < $open; $i++) {
    fscanf(STDIN, "%d %d %d %d %d %d %d %d %d %d", $x, $y, $N, $NE, $E, $SE, $S, $SW, $W, $NW);

    $distances[$y][$x] = [$N, $NE, $E, $SE, $S, $SW, $W, $NW];
}

$closedList = [];
$queue = [$start->coordinate() => [$start, "A"]];

// game loop
while (count($queue)) {

    //Get the next node we need to check
    [$currentNode, $direction] = getNextNodeToCheck($queue);

    echo $currentNode->coordinate() . " " . $currentNode->parent->coordinate() . " " . number_format($currentNode->givenCost, 2) . PHP_EOL;

    //Check all the moves based on the direction to reach the current node
    foreach(DIRECTIONS[$direction] as $index => $newDirection) {
        $newSuccessor = null;

        //Goal is closer than wall distance or closer than or equal to jump point distance
        if(isCardinal($newDirection) && $currentNode->isInExactDirection($target, $newDirection) && $currentNode->diffNodes($target) <= abs($distances[$currentNode->y][$currentNode->x][$index])) {
            $newSuccessor = $target;
            $givenCost = $currentNode->givenCost + $currentNode->diffNodes($target);
        } //Goal is closer or equal in either row or column than wall or jump point distance
        elseif(isDiagonal($newDirection) && $currentNode->isInGeneralDirection($target, $newDirection) && $currentNode->diffNodesRow($target) > 0 && $currentNode->diffNodesCol($target) > 0 && ($currentNode->diffNodesRow($target) <= abs($distances[$currentNode->y][$currentNode->x][$index]) || $currentNode->diffNodesCol($target) <= abs($distances[$currentNode->y][$currentNode->x][$index]))) {
            $minDiff = min($currentNode->diffNodesRow($target), $currentNode->diffNodesCol($target));
            $newSuccessor = $currentNode->getNextNode($minDiff, $newDirection);
            $givenCost = $currentNode->givenCost + (sqrt(2) * $minDiff);
        } //Jump point in this direction
        elseif($distances[$currentNode->y][$currentNode->x][$index] > 0) {
            $newSuccessor = $currentNode->getNextNode($distances[$currentNode->y][$currentNode->x][$index], $newDirection);
            $givenCost = $currentNode->diffNodes($newSuccessor);
            if (isDiagonal($newDirection)) $givenCost *= sqrt(2);
            $givenCost += $currentNode->givenCost;
        }

        //We can reach another node from the current node
        if($newSuccessor !== null) {

            //We have reached the target node
            if($newSuccessor === $target) {
                echo $target->coordinate() . " " . $currentNode->coordinate() . " " . number_format($givenCost, 2) . PHP_EOL;
                exit();
            }

            $newSuccessor->parent = $currentNode;
            $newSuccessor->givenCost = $givenCost;
            $newSuccessor->finalCost = $givenCost + $newSuccessor->octileDistance($target);

            //The node is not in the queue and not in the list of nodes already checked
            if(!isset($queue[$newSuccessor->coordinate()]) && !isset($closedList[$newSuccessor->coordinate()])) {
                $queue[$newSuccessor->coordinate()] = [$newSuccessor, $newDirection];
            } //The node is in the queue & givenCost is lower, updating the queue
            elseif(isset($queue[$newSuccessor->coordinate()]) && $givenCost < $queue[$newSuccessor->coordinate()][0]->givenCost) {
                $queue[$newSuccessor->coordinate()] = [$newSuccessor, $newDirection];
            } 
        }
    }

    $closedList[$currentNode->coordinate()] = 1; //We only want to check a node once
}

echo "NO PATH" . PHP_EOL;
?>
