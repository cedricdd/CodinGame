# Puzzle
**Erase** https://www.codingame.com/contribute/view/53475d260b40fef5cc3d6c49be2c90b4ba43a

# Goal
Given two strings a and b, in how many ways we can erase characters from a such that we end up with the string b?  
Take in mind that the order of operations matters.

Explanation for example 1:  
aba -> ab -> b  
aba -> ba -> b  
Those transformations are considered different. 

# Input
* Line 1: String a
* Line 2: String b

# Output
* Line 1:The answer modulo (remainder when divided by) 998244353.

# Constraints
* 1 ≤ length of b ≤ length of a ≤ 500
* Both strings will only contain lowercase English letters.
