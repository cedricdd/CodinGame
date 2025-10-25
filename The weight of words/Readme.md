# Puzzle
**The weight of words** https://www.codingame.com/training/easy/the-weight-of-words

# Goal
You have to decrypt a h x w grid of encrypted text.

Each row/column of the grid has its own weight, which is the sum of the binary representation of its letters in ASCII (A=65, B=66, ...., Z=90).  
For example the row ABCD has a weight of 266 (65 + 66 + 67 + 68). 
The grid only contains uppercase letters from A to Z  

To decrypt the grid you'll have to:
* First, for each of the w columns move the letters down a row weight of the column times
* And then, for each of the h rows move the letters to the column at their right weight of the row times

The rows/columns form a cycle, if a letter should leave the grid from one side, make it appear at the other side

For example (we'll assume for this example that all the weights are equal to 1):
```
ABC
DEF
GHI
```
The letters of each column move downward 1 time:
```
GHI
ABC
DEF
```
Then the letters of each row move to the right 1 time:
```
IGH
CAB
FDE
```
Note that in the tests, each row/columns will have its own weight !

Repeat this process steps times and you'll get the decrypted grid of text.

# Input
* Line 1 : An int steps for the number of times you'll have to repeat the process
* Line 2 : An int h for the number of rows
* Line 3 : An int w for the number of letters in a row
* h next lines : A string of w uppercase letters

# Output
* h lines : A row of the decrypted grid

# Constraints
* 3 <= steps <= 5000
* 2 <= h <= 16
* 4 <= w <= 20
