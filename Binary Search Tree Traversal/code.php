<?php

//output current value, consider left subtree, consider right subtree
function preOrder(Leaf $leaf, array &$results) {
    $results[] = $leaf->value;
    if($leaf->left !== null) preOrder($leaf->left, $results);
    if($leaf->right !== null) preOrder($leaf->right, $results);
}

//consider left subtree, output current value, consider right subtree
function inOrder(Leaf $leaf, array &$results) {
    if($leaf->left !== null) inOrder($leaf->left, $results);
    $results[] = $leaf->value;
    if($leaf->right !== null) inOrder($leaf->right, $results);
}

//consider left subtree, consider right subtree, output current value
function postOrder(Leaf $leaf, array &$results) {
    if($leaf->left !== null) postOrder($leaf->left, $results);
    if($leaf->right !== null) postOrder($leaf->right, $results);
    $results[] = $leaf->value;
}

//output all values from top to bottom level and from left to right within each level
function levelOrder(Leaf $leaf, array &$results) {
    $toCheck = [$leaf];

    while($toCheck) {
        $leaf = array_shift($toCheck);
        $results[] = $leaf->value;
        if($leaf->left !== null) $toCheck[] = $leaf->left;
        if($leaf->right !== null) $toCheck[] = $leaf->right;
    }
}

class Tree {
    public $root;

    public function __construct(int $root) {
        $this->root = new Leaf($root);
    }

    public function insert(int $value) {
        $leaf = $this->root;

        while(true) {
            //Value is smaller it goes on the left
            if($value < $leaf->value) {
                if($leaf->left === null) {
                    $leaf->left = new Leaf($value);
                    break;
                }
                else $leaf = $leaf->left;
            } //Value is bigger it goes on the right
            else {
                if($leaf->right === null) {
                    $leaf->right = new Leaf($value);
                    break;
                }
                else $leaf = $leaf->right;
            }
        }
    }
}

class Leaf {
    public $left;
    public $right;
    public $value;

    public function __construct(int $value) {
        $this->value = $value;
        $this->left = null;
        $this->right = null;
    }
}

fscanf(STDIN, "%d", $n);
$inputs = array_map("intval", explode(" ", fgets(STDIN)));

$tree = new Tree(array_shift($inputs));

while($inputs) $tree->insert(array_shift($inputs));

foreach(["preOrder", "inOrder", "postOrder", "levelOrder"] as $name) {
    $results = [];
    $name($tree->root, $results);
    echo implode(" ", $results) . PHP_EOL;
}
