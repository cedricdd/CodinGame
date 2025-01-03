# Puzzle
**Mandelbrot Set Approximation** https://www.codingame.com/training/easy/mandelbrot-set-approximation

# Goal
The Mandelbrot set is the set of all complex numbers c that do not diverge (don't get bigger and bigger) when you repeatedly apply the function:
```
z(n+1) = z(n)^2 + c

with z(0) = 0.
```

For example, if c = 1 then z(0)=0, z(1) = 0^2+1 = 1, z(2) = 1^2 + 1 = 2, z(3) = 2^2 + 1 = 5, etc. - so for c = 1, it diverges (it gets bigger each time).

c can be any complex number, which can be simplified as a 2-column vector [a,b] where 'a' is the 'real' part and 'b' is the 'imaginary' part.   
[a,b]^2 is defined as [a^2-b^2, 2*a*b] (if your coding language doesn't natively support complex arithmetic).

Given an input n which is the number of rows of output to give in your answer, with the number of columns being 1.5*(n-1), each having the same step size - step = 2/(n-1).  
Approximate the Mandelbrot set by checking whether each point on the 2D region from x = -2 to +1 and y = -1 to +1 is still 'small' after 10 iterations of the function.  
'Small' is defined here by whether the absolute value of z(10) (the 10th iteration) is <= 1.  
```
e.g. for c = [0.5,0.5], z(0) = [0,0], z(1) = [0.5,0.5],
z(2) = [0.5,0.5]^2+[0.5,0.5] = [0.5^2-0.5^2, 2*0.5*0.5]+[0.5,0.5] = [0,0.5]+[0.5,0.5] = [0.5,1]
z(3) = ...
z(20) ≈ [9.263696725417487e+35,-2.9948397573321135e+35]
|z(20)| ≈ 9.735766132801658e+35 <- definitely not in the set
```
Print the 2D grid with n evenly spaced points in -1≤y≤1 and 1.5*(n-1) + 1 points in -2≤x≤1 and display points that diverge as a space ' ' and points in the set as a '*'. (Leave trailing spaces so the grid is a square)

# Input
* n: the (integer) number of rows for your 2D grid, number of columns = 3*(n-1)/2.

# Output
* n lines: the approximated Mandelbrot set with points in the set shown as '*' and points that diverged shown as a space ( ).

# Constraints
* 2 ≤ n ≤ 25 (25 rows and 36 columns at most)
* n is always odd
