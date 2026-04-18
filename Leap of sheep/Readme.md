# Puzzle
**Leap of sheep** https://www.codingame.com/contribute/view/146700c60c02a58fbcf8bc5cf176089475a2c9

# Goal
Bob is training his sheep for the annual competition Leap of Sheep.

His training ground is composed of N piles of dirt of varying heights, evenly spaced.

A leap is a jump between 3 piles of dirt in increasing index order (of heights h1, h2, h3), where the middle pile is strictly higher than the other two. The piles do not have to be next to each other: the sheep can jump over any number of piles, regardless of their height.  
The difficulty of a leap is the difference between h2 and h1 plus the difference between h2 and h3.

Bob asks you to find the most difficult leap in his training ground, in order to perform well on the competition.

# Input
* Line 1: An integer N for the length of the training ground.
* Line 2: N space separated integers representing the ordered heights of each pile of dirt in the training ground.

# Output
* Line 1: The maximal difficulty of leaps in Bob's training ground as explained above.

# Constraints
* 3 ≤ N ≤ 10 000
* 1 ≤ height of a pile of dirt ≤ 1 000 000
* It is guaranteed that there is at least one valid leap in the training ground, i.e. there is at least one combination of 3 piles where the middle pile is strictly higher than the other two.
