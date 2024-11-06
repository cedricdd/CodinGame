# Puzzle
**Binary Sequence** https://www.codingame.com/training/medium/binary-sequence

# Goal
Find the digit at the given indexes in the sequence of the bits of the binary natural numbers in order.

The binary sequence starts with 0=0, 1=1, 10=2, 11=3, 100=4, 101=5, 110=6, 111=7, 1000=8, 1001=9, ...  
Putting it all together it gives
```
01101110010111011110001001...
| |   |   |
```

Indexes are given in binary (zero based).  
So for example, the bits at indexes 0=0, 10=2, 110=6 and 1010=10 (the ones marked) are 0, 1, 1 and 0. 

# Input
* Line 1: An integer N for the number of indexes.
* Next N lines: The binary integer of each index.

# Output
* N lines: The digit (0 or 1) present at the corresponding index

# Constraints
* 1 ≤ N ≤ 20
* 0 ≤ index < 2^31
