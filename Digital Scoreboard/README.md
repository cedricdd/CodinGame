# Puzzle
**Digital Scoreboard** https://www.codingame.com/ide/puzzle/digital-scoreboard

# Goal 
There is a digital scoreboard showing 2 digits.

1. First part of input shows the starting score
2. Second part of input shows what lights will be turned OFF
3. Third part of the input shows what additional lights will be turned ON

What is the newScore?

To see example of a digital scoreboard and how each of the 10 digits is displayed:  
Each horizontal line is ~~~  
Each vertical line is |  


Alternative image (if needed): https://www.vectorstock.com/royalty-free-vector/digital-numbers-digits-display-vector-22893808

# Input
* Lines 1-7: Starting Scoreboard
* Next Line: The word Subtract to indicate what the following lines will show
* Next 7 Lines: Scoreboard showing the parts that will be turned off
* Next Line: The word Add to indicate what the following lines will show
* Next 7 Lines: Scoreboard showing the parts that will be turned on

# Output
* Line 1: A string, the 2 digits that will be the newScore

# Constraints
* Scoreboard is 17 characters wide (counting the borders)
* Scores are between 0 and 99 (inclusive)
* Scoreboard always has 2 digits. For example: 7 displays as "07"
