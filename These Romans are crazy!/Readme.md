# Puzzle
**These Romans are crazy!** https://www.codingame.com/training/medium/these-romans-are-crazy!

# Goal
You are given 2 expressions representing 2 numbers written in roman numerals. 
You have to provide the result of the sum of these 2 numbers, also in roman numerals. 

I has a value of 1 (maximum 3 in a row)  
V has a value of 5 (maximum 1 in a row)  
X has a value of 10 (maximum 3 in a row)  
L has a value of 50 (maximum 1 in a row)  
C has a value of 100 (maximum 3 in a row)  
D has a value of 500 (maximum 1 in a row)  
M has a value of 1000 (maximum 4 in a row)  

The character I just before an V or X has a value of -1 (example IX equals 9)  
The character X just before an L or C has a value of -10 (example XL equals 40)  
The character C just before an D or M has a value of -100 (example CM equals 900)  

# Input
* Line 1 : Rom1 (the 1st number in roman numerals)
* Line 2 : Rom2 (the 2nd number in roman numerals)

# Output
* The result of Rom1 + Rom2 written in roman numerals

# Constraints
* 1 ≤ Rom1 ≤ 4999
* 1 ≤ Rom2 ≤ 4999
* 1 ≤ Rom1 + Rom2 ≤ 4999
