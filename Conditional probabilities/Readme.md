# Puzzle
**Conditional probabilities** https://www.codingame.com/training/hard/conditional-probabilities

# Goal
You have to write a solver of a conditional probabilities exercise where A and B are two events.  
For readability, we will write that the probability of A is A.  
You are given three probabilities, for example:  

* A, B, A GIVEN B
* NOT A, A AND B, B GIVEN NOT A
* A, NOT A GIVEN B, B GIVEN A

Where:
* NOT A means the probability of the opposite of A,
* A AND B means the probability of the conjunction of A and B (ie A and B occur simultaneously),
* A GIVEN B means the probability of A if B occurs.

For example, you have these relations:  
```
A + NOT A = 1
A AND B + A AND NOT B = A
A AND NOT B = A × NOT B GIVEN A = NOT B × A GIVEN NOT B
```

Note that A AND B is B AND A (so we will use only the first one) but that A GIVEN B is not B GIVEN A (it’s a classical fallacy in psychology).  
You have to find all the probabilities you can build with the words A, B, NOT (unary operator), AND and GIVEN (binary operators).   
Write them in the lexicographic order: A before A AND B before A GIVEN B before A GIVEN NOT B but not B AND A.  

# Input
* FIRST PROBABILITY = value
* SECOND PROBABILITY = value
* THIRD PROBABILITY = value

# Output
* 16 sorted lines of the probabilities (written as reduced fractions) if the exercise is solvable, written as the input and including the input.
* If the given data are not enough to solve the exercise, print only the probabilities that you can calculate (and that you are given).
* IMPOSSIBLE if the solution is a contradiction (for example if a probability is <0 or >1 or if a probability has actually two different values).

# Constraints
* The probabilities are given as fractions of integers.
