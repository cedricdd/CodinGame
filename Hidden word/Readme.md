# Puzzle
**Hidden word** https://www.codingame.com/training/medium/hidden-word

# Goal
You are given a grid of letters and a list of words.  
 
Strike the words in the grid. They can be written horizontally, vertically or diagonally, possibly reversed (in any direction) but always in a straight line.   
Each word is found only once in the grid, although they may overlap.  
A few letters will remain unstruck. Write them down, from left to right, top to bottom, and find the secret word.  

# Input
* Line 1: The number n of words
* Next n lines: A word
* Next Line: The heigth and width of the grid
* Next h lines: A string

# Output
* Print the word.

# Constraints
* The strings are not too long, ie their length is below 40.
* The length of the lines of the grid is the same.
* You can assume that every word and string contains only the 26 letters of the alphabet in capitals.
