# Puzzle
**Body weight is a girl's secret** https://www.codingame.com/training/easy/body-weight-is-a-girls-secret

# Goal
Five girls wanted to step on a scale to measure their weights. However, as boys were nearby watching, they did not want their individual weights to be disclosed.

They chose to pair up to go on the scale. Two girls at a time, they got 10 measurements by doing 10 different pairings.

Afterwards, a problem arose. How could the 10 measurements be converted back to 5 individual weights for each of the girls?

# Input
* Line 1: Ten integers in ascending order, with a space between each two numbers.
  
These are the 10 pairwise weight measurements of the girls. The weights can be in kg, lb, catty, ton...whatever applicable. 
You just need to know they are measured in the same unit.

# Output
* Line 1: Five integers in ascending order, with a space between each two numbers, and no space after the last number.

These are the individual weights of the 5 girls.  
We assume all individual weights and paired weights are integers.  
There shall be a unique solution for each test case.  

# Constraints
* 2 ≤ each paired weight ≤ 2000
* 1 ≤ individual weight
