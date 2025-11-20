# Puzzle
**Team Building** https://www.codingame.com/training/medium/team-building

# Goal
Given a list of names of available players, print all possible ways to construct N different teams of K different players each (a player can only belong to one team at a time).

The output should contain one possible way to form the teams per line, represented by team names separated by commas. The names of the teams on each line should be in alphabetical order.   
A team name is constructed by taking the first letter of each player's name (in alphabetical order).   
For example, a team of "Zidane", "Maradona" and "Ronaldo" would be called "MRZ", and a team of "Anna" and "Alfred" would be called "AA".   
Print the results in alphabetical order.  

Note that some players may be left without a team!  

# Input
* Line 1: Number of teams N
* Line 2: Number of players per team K
* Line 3: Number of players available M
* Next M lines Names of the available players

# Output
* O (number of possible teamings) lines: Names of the teams separated by comma

# Constraints
* 1 <= N <= 16
* 1 <= K <= 8
* N * K <= M
* M < 20
* 1 <= O <= 100
