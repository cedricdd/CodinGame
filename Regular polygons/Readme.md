# Puzzle
**Regular polygons** https://www.codingame.com/training/medium/regular-polygons

# Goal
John has to draw a lot of regular polygons with an increasing number of sides.  
More precisely, John has got two numbers a and b and he must draw regular polygons with the number of sides: a, a+1, a+2, ..., b-2, b-1, b.  

For example, if a = 3 and b = 6, John must draw an equilateral triangle, a square, a regular pentagon, and a regular hexagon.

Because John wants to do the job precisely, he intends to draw as many polygons as possible by geometric constructions (it means using only a straightedge and compass).

Based on Gauss–Wantzel theorem we know that:  
* A regular n-gon (that is, a polygon with n sides) can be constructed with compass and straightedge if and only if n is the product of a power of 2 and any number of distinct Fermat primes (including none).
* A Fermat prime is a prime number of the form 2^(2^m)+1. Where m is a natural number.

Help John and write a program that will calculate how many polygons from the given range can be drawn using geometric construction.

# Input
* Two space separated integers a and b for limits of range of polygons to draw.

# Output
* Number of polygons from given range that John can draw by geometric constructions.

# Constraints
* 3 ≤ a ≤ b < 2^31
