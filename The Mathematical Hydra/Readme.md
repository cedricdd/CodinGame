# Puzzle
**The Mathematical Hydra** https://www.codingame.com/contribute/view/5130688de683c3585faf326361251a771321

# Goal
You are facing a strange version of the legendary Hydra.

The Hydra is represented as a rooted tree:
* Node 0 is the root and represents the body.
* All nodes with no children are heads.
* You will cut off heads one by one. When you cut a head, the Hydra may grow new parts.

Rules:
* You can only cut a head (a node with no children).
* If the head is directly connected to the root (its parent is node 0):
  * The head is removed permanently & nothing grows back.
* Otherwise:
  * Let x be the parent of the head.
  * Let y be the parent of x.
  * Remove the head.
  * Then attach two copies of the subtree rooted at x as children of y.
  * The process continues until only the root remains.

Your task is to compute the total number of cuts required to completely destroy the Hydra.

# Input
* First line: integer n, the number of nodes.
* Second line: integer m, the number of edges.
* Next m lines: each line contains two integers: parent child

# Output
* Print a single integer, the total number of cuts.
