# Puzzle
**What's so complex about Mandelbrot?** https://www.codingame.com/training/easy/whats-so-complex-about-mandelbrot

# Goal
The Mandelbrot Set is the most well known set of complex numbers with fractal properties.

Members of the set are the complex numbers c such that the absolute value of the equation f(n) = f(n-1)^2 + c does not diverge as n approaches infinity, with f(0) = 0.

One property of this equation is that if its absolute value ever becomes larger than 2, we can be confident that it will diverge and therefore conclude that c is not in the set.   
However, an absolute value less than 2 does not guarantee that it will not diverge. Only additional iterations of the equation can help determine that.  

Since the equation will never diverge for numbers in the set, we would run an infinite number of iterations if we only stopped based on the absolute value.   
Therefore, we select another number, m, and give up after running m iterations of the equation.   
Higher values of m could have given us greater confidence that our number is in the set, but we don't have infinite time so we have to draw a line somewhere.  

For this puzzle, you will need to determine how many iterations are necessary to decide if a given complex number c is in the Mandelbrot set, using the absolute value heuristic described above, and given a maximum number of iterations m.

# Input
* Line 1: The complex number to evaluate c represented as (x+yi) where x and y are floating point values. If y is negative, the + will become a -.
* Line 2: An integer m indicating the maximum number of iterations to evaluate.

# Output
* Line 1 : An integer i indicating how many times you need to iterate to determine if the complex number c is in the Mandelbrot set or not.
