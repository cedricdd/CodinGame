# Puzzle
**Ways to make change** https://www.codingame.com/training/medium/ways-to-make-change

# Goal
Given a non-negative amount N and a set of S coins of positive values Vi, return the number of ways to reach the required amount using the coins.

NB : You have an unlimited number of each coin at your disposal.

For example, given N = 10, S = 2 and the set of values V1 = {1, 5} , you should return 3. Indeed, there are 3 ways to sum coins of values {1, 5} up to 10 : 1*10, 5*2 and 1*5 + 5*1.

# Input
* Line 1 : A non-negative integer N for the target amount.
* Line 2 : A positive integer S for the number of possible values coins.
* Line 3 : S space-separated non-negative integer Vi for the value of the i-th coin.

# Output
* An integer representing the number of ways to sum the coins up to N (0 if there is no way to reach the target amount).

# Constraints
* 0 <= N <= 2000
* 0 < S <= 10
* 0 < Vi <= 500
