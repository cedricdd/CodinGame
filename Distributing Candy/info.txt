https://www.codingame.com/training/easy/distributing-candy

Goal
An elementary school teacher has n bags of candy with each bag containing a variable amount of candy. 
After the class, the teacher wants to distribute the candy amongst m students such that each student gets one bag.

Since the amount of candy in the bags is variable, the teacher wants to distribute the bags as fairly as possible, 
minimizing the difference between the kid obtaining the maximum amount of candy and the kid obtaining the minimum amount of candy.
Given n, m and the amount in each bag, what is the minimum unfairness achievable?

Example:

Suppose that we have n=6, m=3 and the number of candy in each of the six bags as follows: 7 1 3 10 12 10. 
The distribution that would minimize the unfairness is 10 10 12. Thus the difference between the kid getting a bag of 12 candy (maximum) pieces and the kid getting 10 (minimum) is 2. 
Therefore, unfairness is equal to 2.

Input
Line 1: Two integers separated by space, n and m
Line 2: A list of integers separated space, denoting the number of candy in each bag.

Output
An integer denoting the minimum unfairness achievable.

Constraints
0<n<300
0<m<n
0<=Ci<=200 with Ci the number of candy in bag i.
