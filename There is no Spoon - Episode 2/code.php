<?php
/**
 * The machines are gaining ground. Time to show them what we're really made of...
 **/

 class Grid
 {
    private $width;
    private $height;
    private $nodeCount = 0;
    private $grid = [];
    private $nodes = [];
    private $links = [];
    private $forbiddenLinks = [];

    public function __construct(int $width, int $height) {
        $this->width = $width;
        $this->height = $height;
    }

    public function __clone() {
        $this->nodes = array_map(function ($node) {
            return clone $node;
        }, $this->nodes);
    }

    //Add a line in the grid
    public function addLine(String $line) {
        $this->grid[] = $line;
    }

    //Add a node in the grid
    public function addNode(Node $node) {
        $index = $node->getIndex();

        $this->nodes[$node->getIndex()] = $node;
        $this->nodeCount++;

        //Search for the node's neighbors on right (nodes are added from right to left)
        for($x = ($node->x + 1); $x < $this->width; ++$x) {
            if($this->grid[$node->y][$x] == '#') {
                $neighbor = $x . " " . $node->y;

                $this->nodes[$index]->neighbors[$neighbor] = "R";
                $this->nodes[$neighbor]->neighbors[$index ] = "L";
                break; //Can only have 1 direct neighbor on each direction
            }
        }

        //Search for the node's neighors on top
        for($y = $node->y - 1; $y >= 0; --$y) {
            if($this->grid[$y][$node->x] == '#') {
                $neighbor = $node->x . " " . $y;

                $this->nodes[$index]->neighbors[$neighbor] = "T";
                $this->nodes[$neighbor]->neighbors[$index ] = "B";
                break; //Can only have 1 direct neighbor on each direction
            }
        }
    }

    //Get the name of a link between 2 nodes.
    //Always use the same name for 2 given nodes no matter the order of the nodes
    public function getLinkName(Node $n1, Node $n2) {
        if($n1->x < $n2->x) return $n1->getIndex() . " " . $n2->getIndex();
        elseif($n1->x > $n2->x) return $n2->getIndex() . " " . $n1->getIndex();
        elseif($n1->y < $n2->y) return $n1->getIndex() . " " . $n2->getIndex();
        else return $n2->getIndex() . " " . $n1->getIndex();
    }

    //Set links that are 100% sure
    public function searchLinks() {
        $linkAdded = false;

        foreach($this->nodes as $node) {

            //When setting links, node can be removed if all their connections have been set
            if(isset($this->nodes[$node->getIndex()]) == false) continue;

            $possibleLinks = [];

            foreach($node->neighbors as $neighbor => $direction) {

                $nodeN = $this->nodes[$neighbor]; 

                $linkName = $this->getLinkName($node, $nodeN);
                //The # of links we can still add between the 2 nodes
                $possibleLinks[$neighbor] = min((2 - ($this->links[$linkName] ?? 0)), $node->weight, $nodeN->weight);
            }

            //The total # of links that can still be created for this node
            $possibleLinksCount = array_sum($possibleLinks);

            foreach($possibleLinks as $neighbor => $value) {

                //If we don't create a link between this node and this neighbor there are not enough potential links left, this link has to be created
                if($node->weight > ($possibleLinksCount - $value)) {
                    $this->addLinks($node->getIndex(), $neighbor);

                    $possibleLinksCount--;

                    $linkAdded = true;
                }
            }
        }

        return $linkAdded;
    }

    //Create a link between 2 nodes
    private function addLinks($index1, $index2) {
        $n1 = $this->nodes[$index1];
        $n2 = $this->nodes[$index2];
        $linkName = $this->getLinkName($n1, $n2);
      
        //Save the link
        $this->links[$linkName] = ($this->links[$linkName] ?? 0) + 1;

        //Update weight of remove node1
        if($n1->weight == 1) {
            $this->removeNode($n1);
        } else $this->nodes[$index1]->weight--;
        
        //Update weight of remove node2
        if($n2->weight == 1) {
            $this->removeNode($n2);
        } else $this->nodes[$index2]->weight--;

        //Both nodes are still present + we reach the maximum number of links between them, they are not considered as neighbors anymore
        if(isset($this->nodes[$index1]) && isset($this->nodes[$index2]) && $this->links[$linkName] == 2) {
            unset($this->nodes[$index1]->neighbors[$index2]);
            unset($this->nodes[$index2]->neighbors[$index1]);
        }

        //Remove the potential links that would cross the newly created link
        $this->removeCrossingLinks($n1, $n2);
    }

    //Remove a node from the grid (all the links required for this node have been found)
    private function removeNode(Node $node) {
        //If this node was the neighbor of other nodes, remove him, can't create link to it anymore
        foreach($node->neighbors as $neighbor => $direction) {
            unset($this->nodes[$neighbor]->neighbors[$node->getIndex()]);
        }

        //Remove the node from node list
        unset($this->nodes[$node->getIndex()]);
    }

    //Links can't cross each others, when a link is added we check if some potential links left would be a crossing link
    //A link was created between $n1 & $n2
    private function removeCrossingLinks(Node $n1, Node $n2) {

        //The link is vertical
        if($n1->x == $n2->x) {
 
            for($y = max($n1->y, $n2->y) - 1; $y > min($n1->y, $n2->y); --$y) {
                for($x = ($n1->x - 1); $x >= 0; --$x) {

                    //The first node left to the newly created link
                    if($this->grid[$y][$x] == "#") {
                       
                        $nodeIndex = $x . " " . $y;

                        //This node is still in the list
                        if(isset($this->nodes[$nodeIndex])) {
                            foreach($this->nodes[$nodeIndex]->neighbors as $neighbor => $direction) {
                                if($direction == "R") {
                                    unset($this->nodes[$nodeIndex]->neighbors[$neighbor]);
                                    unset($this->nodes[$neighbor]->neighbors[$nodeIndex]);
                                    break;
                                }
                            }
                        }

                        continue 2; //We only want to check the first node on each line
                    }
                }
            }
        } //The link is horizontal
        else {

            for($x = min($n1->x, $n2->x) + 1; $x < max($n1->x, $n2->x); ++$x) {
                for($y = ($n1->y - 1); $y >= 0; --$y) {

                    //The first node above to the newly created link
                    if($this->grid[$y][$x] == "#") {

                        $nodeIndex = $x . " " . $y;
                        
                        //This node is still in the list
                        if(isset($this->nodes[$nodeIndex])) {
                            foreach($this->nodes[$nodeIndex]->neighbors as $neighbor => $direction) {
                                if($direction == "B") {
                                    unset($this->nodes[$nodeIndex]->neighbors[$neighbor]);
                                    unset($this->nodes[$neighbor]->neighbors[$nodeIndex]);
                                    break;
                                }
                            }
                        }

                        continue 2; //We only want to check the first node on each column
                    }
                }
            }
        }
    }

    //We can't set any more links with certanty, we guess a link to add
    public function guessLink() {
        foreach($this->nodes as $node) {
            foreach($node->neighbors as $neighbor => $direction) {

                $nodeN = $this->nodes[$neighbor];
                $linkName = $this->getLinkName($node, $nodeN);

                //This link is forbidden, we ended up with a non-solvable grid
                if(isset($this->forbiddenLinks[$linkName])) continue;

                $this->addLinks($node->getIndex(), $neighbor);

                return $linkName;
            }
        }

        return null;
    }

    //Mark a link as forbidden, this link can't be created anymore
    public function addForbiddenLink(string $link) {
        $this->forbiddenLinks[$link] = 1;
    }

    /*
     * Return the status of the current grid
     * -1 finding a valid set of links is impossible
     * 0 finding a valid set of links is still possible
     * 1 a valid set of links has been found
     */
    public function getStatus() {

        foreach($this->links as $link => $value) {

            list($x1, $y1, $x2, $y2) = explode(" ", $link);

            $nodeLinks[$x1 . " " . $y1][] = $x2 . " " . $y2;
            $nodeLinks[$x2 . " " . $y2][] = $x1 . " " . $y1;
        }

        foreach($this->nodes as $node) {

            $possibleLinksCount = 0;

            foreach($node->neighbors as $neighbor => $direction) {

                $nodeN = $this->nodes[$neighbor]; 
                $linkName = $this->getLinkName($node, $nodeN);

                $nodeLinks[$node->getIndex()][] = $nodeN->getIndex();

                $possibleLinksCount += min((2 - ($this->links[$linkName] ?? 0)), $node->weight, $nodeN->weight);
            }

            //We can't create any links to this node anymore => un-solvable with current config
            if($node->weight > $possibleLinksCount) return -1;
        }

        //Check that no nodes group is isolated from the others
        $reached[array_key_first($nodeLinks)] = 1;
        $toCheck[] = [array_key_first($nodeLinks)];
        $step = 0;

        do {
            foreach($toCheck[$step] as $node) {
                foreach($nodeLinks[$node] as $destination) {
                    //We can reach a new node
                    if(!isset($reached[$destination])) {
                        $reached[$destination] = 1;
                        $toCheck[$step + 1][] = $destination; 
                    }
                }
            }
        } while(isset($toCheck[++$step])); 

        //Some group of nodes are isolated, not a valid solution
        if(count($reached) != $this->nodeCount) return -1;

        //Grid is not un-solvable
        if(count($this->nodes) == 0) return 1;
        else return 0;
    }

    public function getLinks() {
        return $this->links;
    }
 }

 class Node
 {
    public $x;
    public $y;
    public $weight;
    public $neighbors = [];

    public function __construct(int $x, int $y, int $weight) {
        $this->x = $x;
        $this->y = $y;
        $this->weight = $weight;
    }

    //Get the index of the node
    public function getIndex() {
        return $this->x . " " . $this->y;
    }
 }


// $width: the number of cells on the X axis
fscanf(STDIN, "%d", $width);
// $height: the number of cells on the Y axis
fscanf(STDIN, "%d", $height);

$grid = new Grid($width, $height);

for ($y = 0; $y < $height; $y++) {
    $line = stream_get_line(STDIN, 31 + 1, "\n");// width characters, each either a number or a '.'

    $grid->addLine(preg_replace("/[0-8]/", '#', $line));

    preg_match_all("/[0-8]/", $line, $matches, PREG_OFFSET_CAPTURE);

    //We want to add the node from right to left
    foreach (array_reverse($matches[0]) as $match) {
        list($value, $x) = $match;
        $grid->addNode(new Node($x, $y, $value));
    } 
}

function solve(Grid $grid) {

    $backups = [];

    while(true) {

        //Set all the links that are 100% sure based on current config
        do {
            $linkAdded = $grid->searchLinks();
        } while($linkAdded);

        //Get the status of the current grid
        switch($grid->getStatus()) {
            case 1:
                //We are done, we found all the links
                return $grid->getLinks();
            case 0:
                //Grid is still solvable but now we have to guess a link
                $backupGrid = clone $grid;
                $link = $grid->guessLink();

                //Nothing left to guess, can't be solved, revert to last backup
                if(empty($link)) {
                    list($grid, $badLink) = array_pop($backups);
                    $grid->addForbiddenLink($badLink);
                } //Save backup info if we need to revert
                else {
                    $backups[] = [$backupGrid, $link];
                }
                break;
            case -1:
                //Grid is un-solvable, revert to last backup
                list($grid, $badLink) = array_pop($backups);
                $grid->addForbiddenLink($badLink);
       
                break;
        }
    }
}

foreach(solve($grid) as $link => $value) {
    echo $link . " " . $value . "\n";
}
?>
