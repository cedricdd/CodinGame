# Puzzle
**Bin Packing** https://www.codingame.com/training/medium/bin-packing

# Goal
There is an array of items of various weights.  
There is a number of identical bins. The bins are large enough to hold any combinations of items.

Instead of throwing all items into one bin, the requirement is to meticulously distribute the weights of the items into the given bins evenly.

After loading, all the bins should have the same weight. No one bin is heavier or lighter than the others.

Each item must be placed in exactly one bin. Items cannot be split into parts.

Mathematicians described bin packing as an NP-hard problem. To mitigate the difficulty, you do not need to tell how the items should be distributed.  
You just need to tell whether "even distribution" is achievable.

# Input
There are multiple test cases in each test set.

* Line 1: an integer n for the number of test cases.
* Following n lines: each line is an independent test case, having space-separated integers b m w1 w2 w3 ... wm

b is the number of bins for items to fill in,  
m is the number of items to pack into bins,  
followed by m integers for the weights of every item.  

# Output
* n lines: for each test case, write a line either yes or no.
  
Write yes if all the items can be evenly distributed by weight among all the bins. Write no if it is impossible.

# Constraints
* 1 ≤ n ≤ 100
* 1 ≤ b ≤ 6
* 1 ≤ m ≤ 20
* 1 ≤ w1 w2 w3 ... wm ≤ 1000
