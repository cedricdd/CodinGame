# Puzzle
**Palindromic Decomposition** https://www.codingame.com/training/medium/palindromic-decomposition

# Goal
We say a tuple of three strings (P, Q, R) is a palindromic decomposition of string S if P+Q+R=S and all of P, Q and R are palindrome. Note that P, Q and R can be the empty string ε.

Given string S, calculate the number of the palindromic decompositions of S.

For example, if you are given abab, you should answer 6 because (ε, a, bab), (ε, aba, b), (a, ε, bab), (a, bab, ε), (aba, ε, b) and (aba, b, ε) are the palindromic decompositions of abab.

# Input
* A string S.

# Output
* The number of palindromic decompositions of S.

# Constraints
* 1 ≤ length of S ≤ 4000.
* S is consisting of lowercase English letters.
