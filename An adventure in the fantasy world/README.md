# Puzzle 
**An adventure in the fantasy world** https://www.codingame.com/training/easy/an-adventure-in-the-fantasy-world

# Goal
You are a Warrior in the fantasy world.

You have a little money (50G) at the beginning.

The world is represented by a rectangular grid. A position is denoted by its row number and its column number like this: row number column number. 
Your initial position is 0 0.

You can move 1 unit in any one direction (Right or Left or Up or Down) at a time.   
You have planned the path you will take, and written it down in shorthand, using R, L, U, D to represent Right, Left, Up, Down respectively.

Each position in the world may contain money, an enemy or nothing. You have gathered the information in the following format:
position enemy type of enemy, or  
position money amount of money,   
for example:  
0 1 enemy slime  
2 5 money 10G  

When you get to a point of money or an enemy, you do the following:  
• If you find some money, you pick up all the money. so after you got the money, it disappears from the map.
• If you encounter an enemy which is not a goblin e.g. a slime, you fight it and stop moving further (i.e. ignore the remaining untaken path).
• If you encounter a goblin and you have less than 50G, you also fight it and stop moving further.
• If you encounter a goblin and you have enough money, you pay the goblin 50G. 
It will then let you pass and continue your adventure. Note though, the goblin does not go away, so if you revisit the point later on, you will have to pay it again or fight it!

Output the result of your adventure:  
• If you complete the planned path safely without fighting any enemies, output GameClear, your final position and the final amount of money you have, e.g. GameClear 2 5 30G.
• If you have to stop and fight an enemy, output your final position, the final amount of money you have and the name of the enemy, e.g. 2 3 32G goblin.

# Input
* Line 1: A string s for the path you have planned to take.
* Line 2: An integer n for the number of positions which you have information.
* Next n lines: A string m for the information on a position.

# Output
* Line 1: A string for the result of the adventure.
  
If you complete the planned path: GameClear, your final position and the final amount of money you have
Otherwise: your final position, the final amount of money you have and the name of the enemy

# Constraints
* 1 ≤ s.length ≤ 100
* s.length ≤ n ≤ s.length * 2
* row number and column number in m are always integers
* -50 ≤ row number, column number in m ≤ 50
* 1 ≤ money in m ≤ 100
