# Puzzle
**Bag of Balls** https://www.codingame.com/training/medium/bag-of-balls

# Goal
Imagine you have a bag, which is filled with N balls. Each ball can have the color black or white. You know that W balls in the bag are white.

If you extract a ball from the bag, the probability changes of the remaining balls.

Your job is it to output the ratio of the odds that you extracted k white balls after extracting s balls from the bag.  
Balls are never put back into the bag!

Example:  
You have 3 balls in the bag, 2 of which are white.  
What is the probability of having 2 white balls by extracting 2 balls?  

2/3 * 1/2 = 1/3

When A is the event of getting 2 white balls:  
P(A) = Probability of getting 2 white balls = 2/3 * 1/2 = 1/3  
P(!A) = Probability of not getting 2 white balls = 1-1/3 = 2/3  

So the ratio P(A) : P(!A) is 1:2 (read 1 to 2).

The ratio 2:4 would be the same ratio, but both numbers are divisible by 2, so you need to reduce the ratio.

# Input
* Line 1: An Integer N for the number of balls in your bag.
* Line 2: An Integer W for the number of white balls in your bag.
* Line 3: An Integer s for the size of your sample.
* Line 4: An Integer k for the desired number of white balls in your sample.

# Output
* Line 1: A : B, the odds ratio (in lowest terms) that k white balls are in your sample of s balls

# Constraints
* 0 ≤ N ≤ 60
* 0 ≤ W ≤ N
* 0 ≤ s ≤ N
* 0 ≤ k ≤ s
* 0 ≤ k ≤ W
