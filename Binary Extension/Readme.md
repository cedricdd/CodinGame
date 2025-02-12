# Puzzle
**Binary Extension** https://www.codingame.com/training/hard/binary-extension

# Goal
Given an integer n and the coordinates of some goals and some bombs, you must build a binary search tree containing the integers from 1 to n in such a way that the graphical representation of the tree reaches the goals and does not touch bombs.

You give, one by one, a list of distinct integers, from 1 to n, in any order. Each integer k is added to the binary search tree using the classical definition of how to add a number to a binary search tree:  
* If the tree has no root, a root r is added to the tree, with empty left and right subtrees, and is attached to the value v(r) = k;
* Otherwise, the integer is recursively added to the left subtree of r if v(r) < k, and to the right subtree if v(r) > k.

Due to this definition, each new node is always a new leaf of the tree.  
The tree is initially empty.  

Graphical representation of the tree  
The tree, the bombs and the goals are drawn on a grid with integer coordinates.  
Each time an integer is added to the tree, the drawing is updated using the following rules. The tree is drawn in a rectangle with a given odd width and a given height, the coordinates vary between (0, 0) and (width - 1, height - 1). The root of the tree is always placed at coordinates ((width - 1)/ 2, 0). The left child (respectively the right child) of a node with coordinates (x, y) is placed at coordinates (x - 1, y + 1) (respectively (x + 1, y + 1)).  
On the graphical interface of the game, the root is drawn in blue, some coordinates are unreachable (for instance the coordinate (0, 0) and are drawn in gray.  
  
You loose if:  
* by adding an integer to the tree, it is placed out of the bounds (the x-coordinate should be between 0 and width-1, and the y-coordinate should be between 0 and height - 1;
* by adding an integer to the tree, it is placed on a bomb;
* after adding all the integers to the tree, a goal is not reached;
* by adding an integer to the tree, it is placed at the same coordinates than another integer;
* you do not supply an integer between 1 and n;
* you supply the same integer twice;
* you do not supply a valid integer in time.

You win when all the goals are reached. It is allowed to place only a part of the integers between 1 and n.

If you are given the following values:
```
5 for the width and 3 for the height
4 for n
1 bomb at (3, 1)
1 goal at (2, 2) 
```

If you output 4 then 1 then 2:  
* The 4 is placed at the root of the tree, at position ((width - 1)/ 2, 0) = (2, 0).
* The 1 is placed as a left child of 4, thus at position (1, 1).
* The 2 is placed as a right child of 1, thus at position (2, 2).

The goal is reached, and the bomb has not exploded. You win.

If you output 3 then 1 then 4 then 2:  
* The 3 is placed at the root of the tree, at position ((width - 1)/ 2, 0) = (2, 0).
* The 1 is placed as a left child of 3, thus at position (1, 1).
* The 4 is placed as a right child of 3, thus at position (3, 1).

The bomb is touched and explodes. The 2 is not placed. You loose.

# Input
* Line 1: five integers width, height, n , bombsCount and goalsCount.
* Next bombsCount lines: two integers x and y corresponding to the coordinates of each bomb.
* Next goalsCount lines: two integers x and y corresponding to the coordinates of each goal.

# Output
* At most n lines containing each a distinct integer between 1 and n

# Constraints
* width ≤ 15
* height ≤ 12
* n ≤ 50
* goalsCount ≤ 20
  
