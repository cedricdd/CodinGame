# Puzzle
**2-player game on a calculator** https://www.codingame.com/training/medium/2-player-game-on-a-calculator

# Goal
A number N is displayed on the calculator.  
First player picks a digit d between 1 and 9.  
N is replaced by N - d.  
Second player does the same thing, but has to choose a key which is adjacent to the last one (but not the same one, you cannot repeat the digit select by the opponent).

Note: detailed specification of what is "near".

When 1 was selected, then 2, 4 or 5 can be selected.  
When 2 was selected, then 1, 3, 4, 5 or 6 can be selected.  
When 3 was selected, then 2, 5 or 6 can be selected.  
When 4 was selected, then 1, 2, 5, 7, or 8 can be selected.  
When 5 was selected, then 1, 2, 3, 4, 6, 7, 8 or 9 can be selected.  
When 6 was selected, then 2, 3, 5, 8 or 9 can be selected.  
When 7 was selected, then 4, 5 or 8 can be selected.  
When 8 was selected, then 4, 5, 6, 7 or 9 can be selected.  
When 9 was selected, then 5, 6, or 8 can be selected.  

# Input
* Line 1 : An int N : the starting number

# Output
* Line 1 : 0 to 9 ints, separated with spaces, from lowest to highest. These are the winning moves when playing first and N is the starting number

# Constraints
* 0 < N ≤ 100000
