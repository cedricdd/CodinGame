# Puzzle
**Rocky Pohp's Concert Date** https://www.codingame.com/training/easy/rocky-pohps-concert-date/discuss

# Goal
To celebrate his ten-year career, pop star Rocky Pohp decides to organize an amazing pop concert where only his biggest fans will receive ultra-VIP tickets. To select these fans, he launches a puzzle and states that the first 100 people to solve it before the concert date is announced will each receive an ultra-VIP ticket.

The goal of this puzzle is to determine the concert date, and only two pieces of information have been provided: a number and the procedure used to obtain this number.

Rocky Pohp explains that he obtained the mysterious number in three steps:  
1. Concatenation : He concatenated the year, month, and day of the concert to form a number.
2. Factorization : He decomposed this number into two factors a and b that are as close as possible, meaning that the absolute difference |a - b| is minimized.
3. Final number : He obtained the mysterious number by concatenating a and b.

Example :  
- The date 2078-12-08 leads to the number 20781208.
- The different factorizations of 20781208 are : 1 x 20781208, 2 x 10390604, 4 x 5195302, 7 x 2968744, 8 x 2597651, 14 x 1484372, 17 x 1222424, 28 x 742186, 34 x 611212, 56 x 371093, 68 x 305606, 83 x 250376, 119 x 174632, 136 x 152803, 166 x 125188, 238 x 87316, 263 x 79016, 332 x 62594, 476 x 43658, 526 x 39508, 581 x 35768, 664 x 31297, 952 x 21829, 1052 x 19754, 1162 x 17884, 1411 x 14728, 1841 x 11288, 2104 x 9877, 2324 x 8942, 2822 x 7364, 3682 x 5644, 4471 x 4648
- The closest factorization is 4471 × 4648 because |4471 - 4648| is the smallest difference.
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
