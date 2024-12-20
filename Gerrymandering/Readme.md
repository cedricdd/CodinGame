# Puzzle
**Gerrymandering** https://www.codingame.com/training/hard/gerrymandering

# Goal
You're in charge of redefining electoral districts in your county, in order to win the next elections.

The county starts as a single rectangular district. A single district can be split vertically or horizontally in two new districts.  
This ensures that all districts remain rectangular. Your objective is to find the optimal cuts to maximize the number of voters granted by your districts.

Each district will grant you a certain amount of voters, depending solely on its dimensions. The input is a table of number of voters for each possible shape.  
The dimensions are not symmetrical, i.e. a 5x3 area may not have the same value as a 3x5 one.

Example: in the first testcase, a 1x1 rectangle is worth 7 voters, a 2x1 is worth 8, a 1x2 is worth 10, a 2x2 is worth 41, etc.  
The optimal solution in that case is to split the initial 5x4 district vertically into a 4x4 and a 1x4 district.   
Then, the resulting 4x4 district is split horizontally in two districts of size 4x2.  
The resulting score is then 39 + 96 + 96 = 231, which is the highest possible amount of voters in that case. 

# Input
* Line 1: Two integers W and H, the width and height of your county.
* Next H lines: W integers representing the amount of voters given by a district of shape hxw

# Output
* Line 1: A single integer representing the maximum amount of voters you can get by redefining electoral districts.

# Constraints
* 1 ≤ W ≤ 40
* 1 ≤ H ≤ 40
* 0 ≤ voters ≤ 10000
