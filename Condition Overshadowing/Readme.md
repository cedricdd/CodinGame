# Puzzle
**Condition Overshadowing** https://www.codingame.com/training/medium/condition-overshadowing

# Goal
Condition overshadowing can be a possible cause for unreachable code in a computer program and solving this problem can help detect it.

Programs often define a chain of conditions in the form of: if ... else if ... else if ... else if  
Some of those conditions can be overshadowed by previous conditions.

The meaning is fairly intuitive: an overshadowed condition is a condition for which any values satisfying the condition also satisfy at least one previous condition, thus making the overshadowed block of code unreachable.

The goal is to detect all overshadowed conditions in a chain of conditions and output their serial position in the chain. The first condition has index 0.

Overshadowed conditions in real-life programs can be extremely hard to detect, but here the conditions are simplified to only an integer variable x compared to an integer constant c (and still this isn't so simple...)

Note: Partial overshadowing does not count, while complete overshadowing (which leads to totally unreachable code) counts.

*In the example:*  
* Condition (x == 9) is overshadowed by condition (x > 4).
* Condition (x < 6) is overshadowed by conditions (x > 4) and (x != 5).
* Condition (x != 5) is only partially overshadowed by condition (x > 4) and hence is not treated as part of the answer.

# Input
* N amount of conditions.

*Next N lines:*  
* A condition with a variable x compared to a constant c.
* A condition is one of:
    * x == c
    * x != c
    * x > c
    * x < c

Each line is split into tokens separated by spaces.

# Output
* The serial positions of all overshadowed conditions sorted from smallest to largest, in a single line separated by spaces.
* If no overshadowed conditions exist, output "ok".

# Constraints
* 1 ≤ N ≤ 10
* -2^30 < c < 2^30
* x is of type integer and c is an integer.
