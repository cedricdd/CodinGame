# Puzzle
**Simplified Monopoly Turns Prediction** https://www.codingame.com/training/medium/simplified-monopoly-turns-prediction

# Goal
Your goal is to recreate a simplified turns prediction for the Monopoly™ game.

You'll be given a list of players with their names and their initial positions, a list of dice rolls, and a list of names of all the game board positions.   
You'll need to find the latest position for each player after all the given dice rolls.

GAME BOARD  
The game is played on a circular game board.  
There are 40 positions on the board, indexed from 0 to 39.  

BASIC RULES  
Each player rolls two dice, and moves forward the sum of the dice rolled positions.  
Multiple players can occupy the same position.  
If a player reaches position 39 and still needs to move forward, he'll continue from position 0. In other words, positions 38, 39, 0, 1, 2 are contiguous.  
Unless something special happens (see below), his turn ends after moving.  

DOUBLE RULES  
A double refers to a roll where both dice have the same value.  
If the player rolls a double, then he rolls the dice and moves again.  
If the player rolls a double three times in a row, then he immediately goes to jail (see below) and his turn ends there.  

JAIL RULES  
The Visit Only / In Jail position has a dual nature: the player is either visiting only, or actually in jail, depending on how he got there.  

If at the end of a basic move, the player lands on Go To Jail, then he immediately moves to the position Visit Only / In Jail and is in jail. His turn ends.  
If the player rolls a double for the third time in a single turn, then he immediately moves to the position Visit Only / In Jail and is in jail. His turn ends.  

If after moving, the player lands on Visit Only / In Jail, he is visiting only and is not in jail.

While the player is in jail, he still rolls the dice on his turn as usual, but doesn't move until either:  
(a) he rolls a double, or  
(b) he fails to roll a double for three throws (i.e. his previous two turns after moving to jail and his current turn).  
If either (a) or (b) happens in the player's turn, then he moves forward the sum of the dice rolled positions and his turn ends.   
He doesn't roll the dice again even if he has rolled a double.  

Note: Visit Only / In Jail is at position 10. Go To Jail is at position 30.  

# Input
* Line 1: An integer P for the number of players
* Next P lines: One line for each player, containing the name and the initial position, separated with a space
* Next line: An integer D for the number of dice rolls in playing order
* Next D lines: One line for each dice roll (space-separated)
* Next 40 lines: One line for the name of each board position. Note that these aren't actually needed to solve the puzzle.

# Output
* P lines: One line for each player, containing the name and the latest position, separated with a space. 
* The output should follow the same order of the players as given in the input.

# Constraints
* 2 ≤ P ≤ 6
* Players' names do not contain any spaces.
* Players never start on Go To Jail or in jail.
* The game board is constant.
