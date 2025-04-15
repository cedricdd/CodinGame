# Puzzle
**Rocky Pohp's Concert Date** https://www.codingame.com/contribute/view/119838f4d78eac9aab5c8ec10056e8de3723ef

# Goal
To celebrate his ten-year career, pop star Rocky Pohp decides to organize an amazing pop concert where only his biggest fans will receive ultra-VIP tickets. To select these fans, he launches a puzzle and states that the first 100 people to solve it before the concert date is announced will each receive an ultra-VIP ticket.

The goal of this puzzle is to determine the concert date, and only two pieces of information have been provided: a number and the procedure used to obtain this number.

Rocky Pohp explains that he obtained the mysterious number in three steps:  
1. Concatenation : He concatenated the year, month, and day of the concert to form a number.
2. Factorization : He decomposed this number into two factors a and b that are as close as possible, meaning that the absolute difference |a - b| is minimized.
3. Final number : He obtained the mysterious number by concatenating a and b.

Example :  
- The date 2078-12-08 leads to the number 20781208.
- The closest factorization is 20781208 = 4471 × 4648.
- The mysterious number is thus 44714648 (or 46484471, which gives the same result lexicographically).

It is guaranteed that the year, month, and day of the concert follow these formats:  
- YYYY (Year)
- MM (Month, between 01 and 12)
- DD (Day, between 01 and 31)
- The date format is YYYY-MM-DD.

For each given mysterious number, it is guaranteed there is a unique valid date that corresponds to it.

# Input
* A single line containing a single integer N : the mysterious number.

# Output
* A single line containing the unique valid date in the format YYYY-MM-DD.

# Constraints
* 10^5 < N < 10^10
* The unique valid date is always guaranteed to exist.
