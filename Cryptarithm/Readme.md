# Puzzle
**Cryptarithm** https://www.codingame.com/training/hard/cryptarithm

*The program:*  
A cryptarithm is an equation where all digits have been replaced with a letter, e.g. AA + BB = CC - this one may have several solutions, with A=1, B=2 and C=3, or A=2, B=3 and C=5, etc.

Your program must read the description of a cryptarithm and output the solution to it.

*In this puzzle:*  
- the supplied cryptarithms are all carried out as an addition,
- they always have one single solution,
- each letter is assigned to a unique digit between 0 and 9 (i.e. two different letters cannot be assigned to the same digit),
- the initial letter of a word can never be assigned to 0.

# INPUT
* Line 1: N, the number of words to add up.
* N next lines: a string word containing a word to add up.
* Next line: a string total containing a word representing the sum of all previous words.

# OUTPUT
* X lines: a letter and the digit assigned to it, separated by a space. X is the number of distinct letters in the cryptarithm.
* The letters must be given in alphabetical order

# CONSTRAINTS
* 2 ≤ N ≤ 5
