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

    public function addChild(Node $node, string $name): void {
        $this->children[$name] = $node;
    }

    public function UCB(float $C): ?Node {
        $bestScore = 0.0;
        $bestNode = null;

        if(count($this->children) == 0) return null;

        foreach($this->children as $name => $node) {
            $score = $node->getScore() / $node->getVisited() + $C * sqrt(log($this->visited) / $node->getVisited());

            error_log("$name $score");

            if($score > $bestScore) {
                $bestScore = $score;
                $bestNode = &$node;
            }
        }

        return $bestNode;
    }
}

$root = new Node("root", 0.0);

fscanf(STDIN, "%d %f", $N, $C);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%s %f", $playout, $score);

    error_log("$playout $score");

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

    error_log("we are at $index");

    $node->addChild(new Node($playout[$index], $score), $playout[$index]);
}

error_log(var_export($root, 1));

$sequence = "";
$node = $root;

while(true) {
    $next = $node->UCB($C);

    error_log(var_export($node->getName(), 1));
    error_log(var_export($next, 1));

    if($next === null) {
        error_log("here");
        break;
    }
    else {
        $sequence .= $next->getName();
        $node = $next;
    }
}

echo $sequence . PHP_EOL;
