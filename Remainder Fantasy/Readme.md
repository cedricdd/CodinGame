# Puzzle
**Remainder Fantasy** https://www.codingame.com/training/medium/remainder-fantasy

# Goal
This was a puzzle invented and solved by Chinese during the 3rd to 5th centuries AD, with innovative solution steps recorded in Mathematical treaties of that era. Translated the text into modern terminologies:

Let x be an integer. Divide x by 3, remains 2; divide x by 5, remains 3; divide x by 7, remains 2. Find the minimum value of x.

You are going to solve similar puzzles with the aid of state-of-the-art technologies and know-how. Take the challenge?


Beware, the moduli you are given may not be pairwise coprime. Moreover, your answer must always be as small as possible while being greater than or equal to every modulo in input. For instance, if you are asked for an integer x such that:
* it remains 3 when dividing x by 8
* it remains 11 when dividing x by 15
* it remains 1 when dividing x by 10  
Then the answer is 131. In this example, 11 is not a valid answer since it is less than 15 (the modulo in the second constraint).

# Input
* Line 1: An integer N for the number of given conditions.
* Next N lines: Two space separated integers m and r for the divisor and remainder of a condition where x mod m = r

# Output
* Line 1 : The minimum value of x fulfilling all the given conditions, and at the same time x >= all of the given m.

# Constraints
* 1 ≤ N ≤ 10
* 0 ≤ r
* 0 < x < 2 ^32
