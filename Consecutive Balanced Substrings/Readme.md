# Puzzle
**Consecutive Balanced Substrings** https://www.codingame.com/training/medium/consecutive-balanced-substrings/solution

# Goal
A binary substring is balanced if the number of 1s in it is equal to the number of 0s.

Given a binary string S, find the maximum number of consecutive balanced substrings. The substring must not be overlapping (e.g. 010 contains one balanced substring either 01 or 10). Also, the binary substring must not be empty.

*Example:*  
For example if S=0010110101, the result is 4 ( the substring 01011010 contains 4 consecutive balanced substrings, 01 01 10 10, all four appear next to each other).  
Another example is: for S = 0010100010010100011100110, the result is 6. Because, the substring 10100011100110 contains six consecutive balanced substrings: 10 10 0011 10 01 and 10.  

# Input
* Line 1: N An integer denoting the number of characters in S.
* Line 2: A binary string S.

# Output
* The maximum number of consecutive balanced substrings in S.

# Constraints
* 1 <= N <= 3000
