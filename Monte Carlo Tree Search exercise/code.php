<?php

class Node {
    private $name;
    private $visited;
    private $children;
    private $score;

    public function __construct(string $name, float $score) {
        $this->name = $name;
        $this->children = [];

        if($name == "root") {
            $this->visited = 0;
            $this->score = 0.0;
        } else {
            $this->visited = 1;
            $this->score = $score;
        }
    }

    public function updateInfo(float $score): void {
        $this->visited++;
        $this->score += $score;
    }

    public function getScore(): float {
        return $this->score;
    }

    public function getVisited(): int {
        return $this->visited;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getChild(string $name): ?Node {
        return isset($this->children[$name]) ? $this->children[$name] : null;
    }

    public function addChild(string $name, float $score): void {
        $this->children[$name] = new Node($name, $score);
    }

    public function UCB(float $C): ?Node {
        $bestScore = 0.0;
        $bestName = "";

        if(count($this->children) == 0) return null;

        foreach($this->children as $name => $node) {
            $score = $node->getScore() / $node->getVisited() + ($C * sqrt(log($this->visited) / $node->getVisited()));

            //Best score or same score & 'smaller letter'
            if($score > $bestScore || ($score == $bestScore && ord($name) < ord($bestName))) {
                $bestScore = $score;
                $bestName = $name;
            }
        }

        return $this->children[$bestName];
    }
}

$root = new Node("root", 0.0);

fscanf(STDIN, "%d %f", $N, $C);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%s %f", $playout, $score);

    $node = $root;
    $index = 0;

    while(true) {
        $node->updateInfo($score);

        $child = $node->getChild($playout[$index]);

        if($child === null) break;
        else {
            $node = $child;
            ++$index;
        }
    }

    $node->addChild($playout[$index], $score);
}

$sequence = "";
$node = $root;

while(true) {
    $next = $node->UCB($C);

    if($next === null) break;
    else {
        $sequence .= $next->getName();
        $node = $next;
    }
}

echo $sequence . PHP_EOL;
