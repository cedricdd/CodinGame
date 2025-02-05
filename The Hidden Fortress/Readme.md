# Puzzle
**The Hidden Fortress** https://www.codingame.com/training/hard/the-hidden-fortress

# Goal
“I have enjoyed the journey. The happiness of these days, I would have never known living in the castle. I've seen people as they are, without pretense. I've seen their beauty and their ugliness with my own eyes.” — Princess Yuki

Hidden fortresses are placed on a size x size grid.  
You don't know their number and you don't know their locations.  
For each cell of the grid, you're given the number of fortresses that share the same row and/or the same column.  
Those numbers are joined together to form a grid of size rows of size characters.  
To describe every possible number with one character, the following symbols are used in order:  
"0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"  
so numbers [10-35] are given with [a-z] and numbers [36-61] are given with [A-Z].  

You must deduce the fortresses' locations and output the grid of revealed fortresses.

For example in the following example, there's a 3 in cell (1, 0), meaning that there are a total of 3 fortresses in row 1 and/or column 0. In the solution, you can see that these fortresses are located at cells (0, 0), (1, 0) and (1, 2).

# Input
* Line 1 : An integer size.
* size next lines : A string of length size.

# Output
* size lines : A string of length size, with "." representing an empty cell and "O" a fortress.

# Constraints
* 3 ≤ size ≤ 31
