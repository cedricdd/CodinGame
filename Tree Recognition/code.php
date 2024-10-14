<?php

class Node {
    public $value;
    public $left;
    public $right;

    public function __construct(int $value) {
        $this->value = $value;
        $this->left = null;
        $this->right = null;
    }

    public function addValue(int $value) {
        if($value < $this->value) {
            if($this->left === null) $this->left = new Node($value);
            else $this->left->addValue($value);
        } else {
            if($this->right === null) $this->right = new Node($value);
            else $this->right->addValue($value);
        }
    }

    public function getShape(): array {
        $shape = [];

        $this->setShape($shape, 0, 0);

        return $shape;
    }

    private function setShape(array &$shape, int $depth, int $index) {
        $shape[$depth][$index] = "*";

        if($this->left !== null) $this->left->setShape($shape, $depth + 1, $index * 2);
        if($this->right !== null) $this->right->setShape($shape, $depth + 1, $index * 2 + 1);
    }

    private function getDepth(): int {
        $depthLeft = $this->left === null ? 0 : $this->left->getDepth();
        $depthRight = $this->right === null ? 0 : $this->right->getDepth();

        return 1 + max($depthLeft, $depthRight);
    }
}

$shapes = [];

fscanf(STDIN, "%d %d", $n, $k);

for ($i = 0; $i < $n; $i++) {
    $inputs = explode(" ", trim(fgets(STDIN)));

    //Create the BST tree
    $root = new Node($inputs[0]);

    for($j = 1; $j < $k; ++$j) $root->addValue($inputs[$j]);

    //Get the shape of the tree
    $shape = $root->getShape();
    
    //Shape is an array, convert it to a string and only keep unique shapes
    $shapes[md5(serialize($shape))] = 1;
}

echo count($shapes) . PHP_EOL;
