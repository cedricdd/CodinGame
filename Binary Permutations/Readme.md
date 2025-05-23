# Puzzle
**Binary Permutations** https://www.codingame.com/training/hard/binary-permutations

# Goal
Consider a permutation of a binary string of a given length N, that produces an output binary string of the same length, such that each bit of the output is equal to some bit of the input.  
The position of the input bit may not be the same as the position of the corresponding output bit, but all output bits are mapped from different input bits.

An example permutation is one that rearranges bits as follows:
```
b2 b1 b0 → b1 b0 b2
```
The result of the permutation (on different inputs) is:

binary 001 → 010 yields as integer 1 → 2  
binary 011 → 110 yields as integer 3 → 6  
binary 101 → 011 yields as integer 5 → 3  

For one such permutation, your program will receive a number of clues about the permutation in the following form:
```
Xi Yi
```
where Xi and Yi are base 10 numbers and Yi is the result of the permutation on Xi.

From the clues you must deduce the permutation and apply it to all values with a single '1' in their binary representation, that is: 1, 2, 4, 8 ... 2^(N-1).

# Input
* Line 1: The number of bits N followed by the number of clues C
* Next C Lines: Two integers Xi and Yi, where Yi is the result of the permutation on Xi

# Output
* A single line containing N space separated integers, where the integer at position i (starting from 0) is the result of the permutation applied to 2^i

# Constraints
* 2 ⩽ N ⩽ 8
* 1 ⩽ C ⩽ N
