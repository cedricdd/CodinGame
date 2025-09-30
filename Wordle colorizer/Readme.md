# Puzzle
**Wordle colorizer** https://www.codingame.com/training/easy/wordle-colorizer

# Goal
You are given the answer to today's Wordle and a list of N attempts to solve it.  
For each attempt you must print the corresponding result.  
Each result must have 5 characters corresponding to the 5 letters of attempt:
- the character X if the letter is not in answer
- the character O if the letter is in answer but at another place
- the character # if the letter is at the right place

Example:  
If answer is POLKA and attempt is SOLAR, then result should be X##OX:
- S is not in answer
- O is at the right place
- L is at the right place
- A is in answer but at another place
- R is not in answer

If the same letter is repeated in attempt, the result should be based on the following priority:
1. \# for the letter appearing at the right place
2. O for the letter's earlier occurrences in attempt
3. X for the letter's remaining occurrences

# Input
* Line 1: An uppercase word which is the answer to today's Wordle
* Line 2: An integer N, the number of attempts to solve the Wordle
* N next lines An uppercase word which is an attempt to solve the Wordle

# Output
* N Lines Each containing the result for an attempt to solve the Wordle

# Constraints
* 1 ≤ N ≤ 6
* Answer and attempt always have a length of 5 letters
