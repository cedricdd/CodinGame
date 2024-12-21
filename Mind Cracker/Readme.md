# Puzzle
**Mind Cracker** https://www.codingame.com/contribute/view/68261c67ac49c4bd79a6676da3769515e658a

# Goal
In this coding challenge, you are tasked with deciphering a series of Mastermind riddles.   
Mastermind is a classic board game where players deduce a hidden color code through a process of elimination.   
In this digital version, your task is to efficiently determine the correct color combination based on the provided clues.  

Develop an algorithm that accurately deduces the unique solution for each riddle with minimal computational effort.  
Brute force solutions may struggle to meet performance requirements.

*Rules:*  
The game involves a grid of nColumns columns and nLines lines of color code guesses.

Each line contains a guess on what the color code is, as nColumns colors represented each by an integer between 0 to nColors – 1.

Next to each guess are the numbers of clues:  
- nBlackClues indicates the number of color matches in the correct position (black clues).
- nWhiteClues indicates the number of color matches in incorrect positions (white clues).

Check out the rules of Mastermind if needed: https://en.wikipedia.org/wiki/Mastermind_(board_game)#Gameplay_and_rules

It is guaranteed that there is always one unique solution.

# Input
* Line 1 nColors: Number of available colors.
* Line 2 nColumns: Number of colors in each guess.
* Line 3 nLines: Number of guesses.
* Next nLines lines each containing, separated by a space:
  * colors: a string of nColumns integers ( from 0 to nColors – 1) representing a guess
  * nBlackClues: Number of black clues received for that guess.
  * nWhiteClues: Number of white clues received for that guess.

# Output
* Output a string of nColumns integers (0 to nColors – 1) representing the unique solution that satisfies the provided clues.

# Constraints
* 3 ≤ nColors ≤10
* 3 ≤ nLColumns ≤7
* 2 ≤ nLines ≤11
