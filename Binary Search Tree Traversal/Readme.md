# Puzzle
**Binary Search Tree Traversal** https://www.codingame.com/training/medium/binary-search-tree-traversal

# Goal
Insert n values in a given order one after the other into an initially empty binary seach tree. Then, output all values in Pre-Order, In-Order, Post-Order and Level-Order.

A binary search tree is a tree-like data structure. Values are represented as nodes and every node can have at most 2 child nodes (leaves), one left and one right. The firstly inserted node is called root node. It is usually the upmost node (the tree is visualized upside down compared to an actual tree in the real world).

When inserting a new value into a binary search tree, start by comparing the new value to the root node's value. If it's smaller, continue to the left. Else, continue to the right. Repeat the process with the appropriate root child (left or right) and continue until there is no more child to compare the value to. At this position in the tree, actually insert the value as a new node.

The example test case of inserting [8, 6, 13, 10, 5] can be visualized like this:
```
........8..........
....../....\.......
....6.....13....
../........./......
5........10......
```
There are different ways to run through ("traverse") all nodes of a binary search tree, always starting at the root node:  
* Pre-Order: output current value, consider left subtree, consider right subtree
* In-Order: consider left subtree, output current value, consider right subtree
* Post-Order: consider left subtree, consider right subtree, output current value
* Level-Order: output all values from top to bottom level and from left to right within each level

Need more context? https://en.wikipedia.org/wiki/Tree_traversal

# Input
* Line 1: An integer N for the number of values.
* Line 2: N space-separated values vi for the values to be inserted into a binary search tree.

# Output
* 4 lines of N space-separated values each.
* Line 1: Pre-Order-Traversal.
* Line 2: In-Order-Traversal.
* Line 3: Post-Order-Traversal.
* Line 4: Level-Order-Traversal.

# Constraints
* 1 ≤ N ≤ 50
* -10^9 < vi < 10^9
  
All values vi are distinct.
