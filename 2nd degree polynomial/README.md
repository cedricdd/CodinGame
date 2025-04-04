# Puzzle
**2nd degree polynomial** https://www.codingame.com/training/easy/2nd-degree-polynomial---simple-analysis

# Goal
Given a polynomial y = ax² + bx + c, calculate :  
- the roots (intersections with the X axis), if existing (there can be 0, 1 or 2),
- the only intersection with the Y axis (always existant in our situation).

Output those points, from left-most to right-most.

To get the root(s) abscissa(s), first calculate delta = b² - 4·a·c.  
If delta < 0, there are no roots (our graph will remain strictly above or below the X axis);  
If delta = 0, there is a unique root (that is also the minimum or maximum of the function);  
If delta > 0, there are 2 roots.  
Then, the root abscissas are given by the formula : [x1, x2] = (-b ± sqrt(delta)) / (2·a).  

Be aware that...  
If a = 0, we obtain a straight line, crossing the X axis in (-c / b, 0).  
If a = 0 and b = 0, we have a horizontal line y = c.  
In the special case a, b, c = 0, we have y = 0 and the only point to output will be (0,0).  

# Input
* Line 1 : 3 decimal numbers a, b, c, representing the polynomial coefficients.

# Output
* Line 1 : a comma-separated list of P points (intersections with the X & Y axis), ordered from left to right, 
with each point formatted as (x,y) without spaces.

Every x and y coordinate, at display time, must be rounded to maximum 2 decimals (only the meaningful ones) :  
5.000  => 5  
1.2001 => 1.2  
0.1256 => 0.13  

# Constraints
* -100 < a < 100
* -100 < b < 100
* -100 < c < 100
* 1 ≤ P ≤ 3
