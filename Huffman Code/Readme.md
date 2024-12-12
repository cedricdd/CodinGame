# Puzzle
**Huffman Code** https://www.codingame.com/training/medium/huffman-code

# Goal
Huffman Coding is an algorithm for doing data compression and it forms the basic idea behind file compression.   
Instead of allowing every character to occupy 8 bits in a file, we use variable-length encoding to assign each symbol a unique binary code according to the frequency of the character in the file, without any ambiguities.

To put this into perspective: Suppose a file contains a string “aabacdeade”, where frequency of characters a, b, c, d and e is 4, 1, 1, 2 and 2 respectively.   
We assign binary codes to each character as follows:
```
a --> 00	  b --> 010	  c --> 011	  d--> 10	  e--> 11 
```

The process of encoding can be divided into two parts:

Part 1: Building a Huffman tree  
First, assume all of the characters as individual trees with frequency as their weight.   
Now, we use a greedy approach to find the two trees with the smallest weights.   
Then, join them to create a new tree with the sum of those two as its weight and repeat this process until we have a single tree remaining.  

For the above example:  
```
Step 1:   [a] [d] [e]    #      --> Here: a = 4, d = 2, e = 2, (bc) = 2
                        / \
                      [b] [c]

Step 2:   [a]    #          #      --> Here: a = 4, (bc) = 2, (de) = 4
                / \        / \
              [b] [c]    [d] [e]

Step 3:       #            #      --> Here: (de) = 4, (a(bc)) = 6
             / \          / \
           [a]  #       [d] [e]
               / \
             [b] [c]

Step 4:        #             --> Here: ((de)(a(bc))) = 10
              / \   
             /   \  
            /     \   
           #       #  
          / \     / \
       [a]   #  [d] [e]
            / \
          [b] [c]
```

Part 2: Assigning binary codes to each symbol by traversing Huffman tree  
Generally, bit ‘0’ represents the left child and bit ‘1’  
represents the right child  
```
                   #                          
                0 / \ 1  
                 /   \  
                /     \
               /       \
              #         #
           0 / \ 1   0 / \ 1
            /   \     /   \
         [a]     #  [d]   [e]
              0 / \ 1
               /   \
             [b]   [c]
```

Thus by going through the tree, we will come up with:
```
a = 00, b = 010, c = 011, d = 10, e = 11
```

Test Case 1  
n = 5  
frequencies = 4 1 1 2 2  
bit length for each test case in order = 2 3 3 2 2 [see above for clarification]  
total bit count = 4 * 2 + 1 * 3 + 1* 3 + 2 * 2 + 2 * 2 = 22  

0utput : 22  

# Input
* Line 1: A single integer N representing the number of characters
* Line 2: An ordered sequence of frequency values separated by space, where
* 1 2 3 ... N represents char1 = 1, char2 = 2, char3 = 3 ... charN = N

# Output
* A single value representing the least number of bits used to store the complete file.

# Constraints
* 1 ≤ N ≤ 3000
