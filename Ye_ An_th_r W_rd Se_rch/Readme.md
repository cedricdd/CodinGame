# Puzzle
**Ye_ An_th_r W_rd Se_rch** https://www.codingame.com/training/medium/ye_-an_th_r-w_rd-se_rch

# Goal
Although you may use any language you wish to complete this puzzle, the playground is written for the Python programmer. Most importantly, the reusable Algorithm X Solver provided in the playground is written in Python. If you follow the directions in the playground and use Python, this puzzle should be significantly easier than if you choose another language or algorithm.

**Task Overview:**   
While cleaning out the storage closet at CodinGame HQ, a handful of word search puzzles were found. Due to water damage, some letters on the grid are smudged and illegible. Find the words and print out the solution. Words can be hidden in any direction, including horizontally, vertically, diagonally, forward or backward.

# Input
* Line 1: Two space-separated integers, the height and width of the word search grid.
* Next height lines: A row of letters in the word search grid. Illegible letters are represented with a (.).
* Next line: A string words, a sequence of space-separated words hidden in the word search.

# Output
* height lines: A row of the solution grid with the hidden words displayed. All locations that are not part of the solution must be replaced with a space. Do NOT trim any trailing spaces from the lines of your solution.

# Constraints
* 7 <= height, width < 50.
* All test cases have a unique solution.
