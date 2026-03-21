<?php

class Node {
    public  $ID;
    private $parent;
    private $children;
    private $hydra;
    private $childrenCount;

    public function __construct(int $ID) {
        $this->ID = $ID;
        $this->parent = null;
        $this->children = [];
        $this->childrenCount = 0;
        $this->hydra = 0;
    }

    public function __destroy() {
        unset($this->children);
    }

    public function addChild(Node $node): void {
        $this->children[] = $node;
        $this->childrenCount++;

        $node->setParent($this);
    }

    public function getChildren(): array {
        return $this->children;
    }

    public function getChildrenCount(): int {
        return $this->childrenCount;
    }

    public function setParent(Node $node): void {
        $this->parent = $node;
    }

    public function getParent(): ?Node {
        return $this->parent;
    }

    public function isRoot(): bool {
        return $this->parent === null;
    }

    public function addHydra(int $count): void {
        $this->hydra += $count;
    }

    public function getHydraCount(): int {
        return $this->hydra;
    }

    public function killAllChildren(): void {
        $this->childrenCount = 0;

        foreach($this->children as $index => $child) unset($child);

        unset($this->children);
    }
}

function makeTree(int $index, Node $root, array &$links): void {
    foreach(($links[$index] ?? []) as $child) {
        $node = new Node($child);

        $root->addChild($node);

        makeTree($child, $node, $links);
    }
}

function solve(Node $node, int &$cuts): void {
    error_log("check children as $node->ID");

    while(true) {
        foreach($node->getChildren() as $child) {
            if($child->getChildrenCount()) {
                error_log("{$child->ID} isn't just a head");

                solve($child, $cuts);

                continue 2;
            }
        }

        break;
    }

    error_log("{$node->ID} only has heads, we can add hydras");

    $count = $node->getChildrenCount() + $node->getHydraCount();
    $cuts += $count;
    
    if($node->isRoot() === false) $node->getParent()->addHydra($count * ($count - 1));

    $node->killAllChildren();
}

$cuts = 0;
$links = [];
$root = new Node(0);

fscanf(STDIN, "%d", $n);
fscanf(STDIN, "%d", $m);

for ($i = 0; $i < $m; $i++) {
    fscanf(STDIN, "%d %d", $parent, $child);

    error_log("$parent $child");

    $links[$parent][] = $child;
}

error_log(var_export($links, 1));

makeTree(0, $root, $links);

solve($root, $cuts);

echo $cuts . PHP_EOL;
