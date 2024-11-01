# Puzzle
**Continuation of the sequence** https://www.codingame.com/contribute/view/1003684121d6184122768f4eed269db53bb889

# Goal
The integers A, B, C, ..., Z, and the starting integer already exist.  
To get the sequence you must:  
add to start integer A (to get new element),  
next add B to A,  
next add C to B  
...  
and finally add Z to Y  
Z does not change.  

You are given sequence with the number of elements N. If N < 29, then the last 29 - N variables are set to 0 (N+1 used).

Output the next element for the final sequence, in integer form.

*EXAMPLE:*  
```
A = 2, B = 3, C = 4, starting integer = 1.
Start from 1
1. starting integer + A = 1 + 2 = 3 - next element (add to start integer A (to get new element))
A = A + B = 2 + 3 = 5 (next add B to A)
B = B + C = 3 + 4 = 7 (next add C to B).
2. previous element + A = 3 + 5 = 8 - next element (add to previous element A (to get new element))
A = A + B = 5+7 = 12 (next add B to A)
B = B + C = 7 + 4 = 11 (next add C to B).
3. previous element + A = 8 + 12 = 20 - next element (add to previous element A (to get new element))
A = A + B = 12+11 = 23 (next add B to A)
B = B + C = 11 + 4 = 15 (next add C to B).
```
Answer = (20 + 23) = 43

To generate sequence do it for N - 1 steps.

# Input
* Line 1: An integer N for number of elements.
* Line 2: Sequence of N space-separated integers.

# Output
* Line 1: The N+1th element of the sequence.

# Constraints
* 2 ≤ N ≤ 29
* 0 ≤ starting integer ≤ 1000
* -1000 ≤ A, B, C, ... , Z ≤ 1000 (initially) (at the end -536870882000 ≤ A ≤ 536870882000, -536870911000 ≤ end integer ≤ 536870911000)
