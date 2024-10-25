# Puzzle
**Buzzle** https://www.codingame.com/training/easy/buzzle

# Goal
Buzzle is a funny little math game about multiples.  
Here were added some difficulty levels which add more rules and make it more complex.  

*Buzzle - Level 1*  
Players have to alternately enumerate numbers from a to b, without forgetting to replace any number which ends with 7 or which is a multiple of 7 by "Buzzle".   
If a number verifies both rules (like 7 or 77), just replace it by "Buzzle"

*Buzzle - Level 2*  
Same rules as level 1, but you also have to replace the numbers by "Buzzle" when the sum of their digits is a Buzzle. For example, 88 -> 8+8=16 -> 1+6=7 -> Buzzle

*Buzzle - Level 3*  
Same rules as level 2, but it is not with 7. You have to adapt the rules for the k numbers num provided in input. They are all in the range [2,9]. 1≤k≤8

*Buzzle - Level 4*  
Same rules as level 3, but you have to apply them in base n. Continue to display numbers in decimal, but the "last digit" and "sum of the digits" rules are in base n.  
For example, in base 18, with num = 7 : 16 is not a Buzzle, because it consists in one single digit (G if we chose 0123456789ABCDEFGH as digits), so its sum is 16. 17 is not a Buzzle, because its last digit is H (17) and not 7. 48 is 2C in base 18, the sum is 2+C (2+12) = 14 which is a multiple of 7 ("multiple" rule doesn't change with the base).  
Warning : in base 18, 21 is not a multiple of 7 because it is the representation of 2*18 + 1 = 37. But 1H is a multiple of 7 because it represents the number 35 = 5×7.  
All the numbers provided in num are strictly inferior to n.  
1 ≤ k < n

Example: in base 12, with 7 and 9  
```
n = 12
k = 2
num = [7, 11]
a = 78
b = 96
```
```
78
Buzzle (67 in base 12 which ends with 7)
Buzzle (68 in base 12 -> 6+8=14 which is a multiple of 7)
81
82
Buzzle (6B in base 12 : last digit is "11" ("B"))
Buzzle (84 = 12×7 / 70 in base 12 -> 7+0=7)
85
86
87
Buzzle (88 = 8×11 / 74 in base 12 -> 7+4=11)
89
90
Buzzle (91 = 13×7 / 77 in base 12 -> ends with 7 or 7+7=14)
92
93
94
Buzzle (7B in base 12 -> 7+B=18 which is 16 in base 12 -> 1+6=7 / 7B ends with 11)
96
```

# Input
* First line : 3 space-separated integers n, a and b : The base and the bounds (a and b are included)
* Second line : One integer k, how many numbers have to be taken into account
* Third line : k space-separated integers for the numbers you have to use in the rules

# Output
* b-a+1 lines : A number or Buzzle

# Constraints
* 2 ≤ n ≤ 64
* 1 ≤ a < b ≤ 10000
* 1 ≤ k < n
* 2 ≤ numbers in num < n
