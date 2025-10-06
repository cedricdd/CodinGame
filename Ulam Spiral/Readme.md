# Puzzle
**Ulam Spiral** https://www.codingame.com/training/easy/ulam-spiral

# Goal
The Ulam spiral or prime spiral is a graphical depiction of the set of prime numbers.   
It is constructed by writing the positive integers in a square spiral and specially marking the prime numbers.

You have to draw an Ascii representation of a Ulam spiral of size N×N.  
Use '#' for prime numbers.  
Use ' ' for others.  

Example with N = 3 :  
There are positions for the 3×3 Ulam spiral  
```
5 4 3
6 1 2
7 8 9
```

Start at the center and turn counterclockwise  
Then replace prime numbers with '#' and the others with ' ':
```
#   #
    #
#    
```

# Input
* Line 1: An integer N for the size of the spiral

# Output
* N lines: Space separated characters of a line from the Ascii representation of the spiral (don't delete trailing ' ')

# Constraints
* N is odd
* 1 ≤ N ≤ 21
