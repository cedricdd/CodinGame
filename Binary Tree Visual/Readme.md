# Puzzle
**Binary Tree Visual** https://www.codingame.com/training/medium/binary-tree-visual

# Goal
You must output a visual of the given binary tree of size N.  
A binary tree is a tree where each node has at most two children, called left child and right child.  
A value is stored in each node.  
Nodes have an id between 0 and N - 1 and are given in order.  
The id of the root is always 0.  

# Input
* Line 1 : An integer N for the number of nodes.
* N next lines : Three space separated integers for the value stored in the node and the id of its left and right children. The id is -1 if there is no child.

# Output
* Lines trimmed on the right representing the tree.
* Prior to trimming, the whole output can be seen as a big grid.
* The values are located in "cells" of width W where W is 1 + the maximum number of digits of a tree value. The values are right-justified within their cell.
* A node in the left sub-tree of a node is always represented to its left, a node in the right sub-tree of a node is always represented to its right.
* The width of the visual is N cells, which means a total width of N x W characters before the right trimming. In other words, every "column" of the big grid contains exactly one value.
* The nodes are connected with |, + and - as seen in the example.
* | and + are right-justified within their cell.
* The total height of the visual is L + 3 x (L - 1) lines where L is the number of levels, also knows as the "height" of the tree (each level brings one line for the values and 3 lines for the connections - except for the last level) .

# Constraints
* 1 ≤ N ≤ 20
