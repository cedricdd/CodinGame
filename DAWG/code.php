<?php

const ALPHABET = ['a' => 0,'b' => 1,'c' => 2,'d' => 3,'e' => 4,'f' => 5,'g' => 6,'h' => 7,'i' => 8,'j' => 9,'k' => 10,'l' => 11,'m' => 12,'n' => 13,'o' => 14,'p' => 15,'q' => 16,'r' => 17,'s' => 18,'t' => 19,'u' => 20,'v' => 21,'w' => 22,'x' => 23,'y' => 24,'z' => 25];

class Tree {
    private $root;

    public function __construct() {
        $this->root = new Node("", false);
    }

    public function insert(string $word) {
        $node = $this->root;
        $len = strlen($word);

        error_log('adding ' . $word);

        for($i = 0; $i < $len; ++$i) {
            $index = ALPHABET[$word[$i]];

            if($node->hasChild($index) == false) {
                $newNode = new Node($word[$i], ($i == $len - 1));
                $node->addChild($index, $newNode);
            } 
            
            $node = $node->getChild($index);
        }
    }

    public function getNodeCount(): int {
        return $this->root->getChildCount();
    }

    public function minimize() {
        $node = $this->root;

        while(true) {
            error_log("at node " . $node->character);
            $childs = $node->getChilds();

            //If there's only on child, there's nothing to do
            if(count($childs) == 1) {
                $node = reset($childs);
            } else {
                foreach($childs as $i => $child1) {
                    foreach($childs as $j => $child2) {
                        if($i >= $j) continue;

                        error_log("need to compare $i & $j");
                    }
                }

                break;
            }
        }
    }
}

class Node {
    public $character;
    private $childs;
    private $wordEnd;
    private $counted;

    public function __construct(string $character, bool $wordEnd) {
        $this->character = $character;
        $this->wordEnd = $wordEnd;
        $this->childs = [];
        $this->counted = false;
    }

    public function hasChild(int $index): bool {
        return isset($this->childs[$index]);
    }

    public function addChild(int $index, Node $node) {
        $this->childs[$index] = $node;
    }

    public function getChild(int $index): Node {
        return $this->childs[$index];
    }

    public function getChilds(): array {
        return $this->childs;
    }
}

$tree = new Tree();

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $tree->insert(trim(fgets(STDIN)));
}

error_log(var_export($tree, true));

$tree->minimize();

// echo $tree->getNodeCount() . PHP_EOL;
