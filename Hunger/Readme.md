# Puzzle
**Hunger** https://www.codingame.com/training/medium/hunger

# Goal
There are n foods in order, given to you in the form of an array. each one has a certain sweetness.   
A food is "good" if the sweetness is greater or equal to k. And a feast (a subarray of all the foods) is "good" if the amount of "good" foods is strictly greater than the amount of non - "good" foods.   
You are to output the length of the longest "good" feast possible.  

# Input
* Line 1: Two space-separated integers - n (amount of food), k (minimum sweetness)
* Line 2: n space-separated integers (the sweetness of each food in order)

# Output
* Line 1: An integer for the length of the longest possible "good" feast

# Constraints
* 1 <= n <= 3,000
* 0 <= k < 100
