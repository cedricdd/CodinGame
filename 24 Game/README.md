# Puzzle
**24 Game** https://www.codingame.com/training/medium/24-game/solution

# Goal
The 24 puzzle is an arithmetical puzzle in which the objective is to find a way to manipulate four integers so that the end result is 24.  
For example, for the numbers 4, 7, 8, 8, a possible solution is (7-8/8)*4 = 24  

You are given 4 integers, each ranging from 0-13. Determine whether it is possible to achieve the number 24 using only parenthesis, addition, subtraction, multiplication, and division while including every single given integer in your calculations.

**More Info**  
https://en.wikipedia.org/wiki/24_(puzzle)

**Examples**  
You can make 24 from 6, 6, 6, and 6  
With 6+6+6+6

You can make 24 from 1, 2, 3, and 4  
With 1*2*3*4

You can make 24 from 3, 3, 8, and 8  
With 8/(3-(8/3))

You can make 24 from 5, 5, 5, and 5  
With (5*5)-(5/5)

You can't make 24 from 1, 1, 1, and 1

You can't make 24 from 0, 1, 4, and 9

# Input
* Lines 1-4: An integer N

# Output
* Line 1: Whether or not it is possible to achieve 24 as a result of the 4 integers using the rules above, "true" if possible and "false" if not.

# Constraints
* The 4 integers N are between 0 and 13.
