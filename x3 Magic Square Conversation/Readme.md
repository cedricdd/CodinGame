# Puzzle
**x3 Magic Square Conversation** https://www.codingame.com/contribute/view/64893845f0d0c150d3be439fb3740d4ce82d4

# Goal
A magic square is a square grid of distinct numbers where diagonals, rows, and columns, all add to the same number.  
For instance, a magic square of size 3 often uses 15 as its magic value (all diagonals, rows, and columns add to 15) and positive integers 1 to 9 as its distinct numbers.  

There are multiple solutions to the magic square mentioned above (where size is 3, magic number is 15, and distinct numbers are positive integers 1 to 9).  
Your goal is to output the number of solutions after each hint received.  

# Input
* Line 1 : An integer N the number of following hints
* N next lines :M on SR or M on X,Y

- M a number of the magic square
- S one of these characters: /,\,R,C
- R a rank of row/column
- X the rank of the column
- Y the rank of the row
- \ Means the number is on the top-left/bottom-right diagonal (R is ignored)
- / Means the number is on the top-right/bottom-left diagonal (R is ignored)
- RM Means the number is on the Mth row (0 is the top row, 2 is the bottom one)
- CM Means the number is on the Cth column (0 is the left column, 2 is the right one)
- X,Y Means the number is on the Xth column and the Yth row

# Output
- N line: S the number of solutions or NO SOLUTIONS! if S is equal to 0
If S is equal to 1:  
- 3 next lines : The rows of the unique solution with spaces separating numbers.

# Constraints
- 1 <= N <= 10
- 1 <= M <= 9
- 0 <= R <= 2
- 0 <= X <= 2
- 0 <= Y <= 2
