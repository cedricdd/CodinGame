# Puzzle
**Reconstruct a Tree** https://www.codingame.com/training/medium/reconstruct-a-tree

# Goal
Every tree has a unique "prufer code".  
For example, the following tree has prufer code of 2 2 1 3 3.  
```
     1          or     4 - 2 - 1 - 3 - 6
    /  \                   |       |
   2    3                  5       7
  / \  / \  
 4  5  6  7 
```

We can get the code from the following procedure:
* Step 1: from all the nodes which only have one connection to the other nodes (the ending points; could include the root, in case it only has one branch), choose the node with smallest number, trim it and record its "neighbor node" (its only neighbor, could be in reverse hierarchy) in the code.
* Step 2: repeat step 1 until there are only 2 nodes and stop.

For the example tree:  
* step 1: cut 4 (from 4 5 6 7) and record 2
* step 2: cut 5 (from 5 6 7) and record 2 2
* step 3: cut 2 (from 2 6 7) and record 2 2 1
* step 4: cut 1 (from 1 6 7) and record 2 2 1 3
* step 5: cut 6 (from 6 7) and record 2 2 1 3 3 and stop.

Now, given a prufer code, can you reconstruct the tree?  
Please use the following list format for a tree (in case we choose 1 as root):  
(1 (2 (4) (5)) (3 (6) (7)))  

note:  
1. The nodes are labelled with natural numbers starting from 1 and increasing consecutively. For example, a tree with 5 nodes will have nodes 1, 2, 3, 4 and 5.
2. A list format tree is represented by its nodes/elements enclosed within brackets. In every list/sublist, first element is the node and rest elements are its children node(s) (or sublists); leaf is a sublist with only one element.
3. Same level nodes follows the order from small to large.
4. Use one space to separate the elements/lists.
5. We fix node R as the root to present the tree.

One more example for the list format:
```
      ___1___         
     /   |   \       
    2    5    9    
  / |  / | \   \ 
 3  4 6  7  8   10
```

if we choose R=1 as root, the list will be:  
(1 (2 (3) (4)) (5 (6) (7) (8)) (9 (10)))  
if we choose R=5 as root, the list will be:  
(5 (1 (2 (3) (4)) (9 (10))) (6) (7) (8))  

# Input
* Line 1: The prufer code of a tree, a list of natural numbers, separated by space.
* Line 2: The R, the root to present the tree.

# Output
* A tree, in a list format, with R as root.
