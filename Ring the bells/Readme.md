# Puzzle
**Ring the bells** https://www.codingame.com/training/medium/ring-the-bells

# Goal
If you have 4 bells (say 1, 2, 3 and 4), you can ring them in 24 ways: for example, 1, 2, 4 then 3: 1 2 4 3 or 3, 1, 2 then 4: 3 1 2 4. You can ring the 24 melodies one by one; but how can someone (a monk or a priest) learn the full pattern of 24 melodies? They have developed mnemotechnical ways to remember them all and not to forget even one with what we call mathematical permutations.
Plain Bob Minimus is such an algorithm. Here is its beginning:
```
1 2 3 4→2 1 4 3→2 4 1 3→4 2 3 1→4 3 2 1→3 4 1 2
```

A permutation of a set is a bijection (a one-to-one function) from the set onto itself, like a shuffle of the elements of the set.  
We can describe Plain Bob Minimus’ permutations as (1 2)(3 4)→(1 4)→(2 4)(1 3)→(2 3)→(4 3)(2 1).  
First, (1 2)(3 4) exchanges the bells 1 and 2, 3 and 4.  
Then (1 4) exchanges the bells 1 and 4.  
Then (2 4)(1 3) exchanges the bells 2 and 4, 1 and 3. And so on.  
In blue, it’s a list of bells, a melody with four bells. In yellow, it’s the permutation that rearranges the bells from a melody to the next melody.  

A permutation can move more than two bells. (1 4 5) is the permutation that sends 1→4, 4→5 and 5→1 and does not move neither 2 nor 3 nor any other number (it’s a 3-cycle).

Beware, because permutations are functions, you must compute them from right to left.

You have to print the resulting permutation from a succession of permutations, that is a product of disjoint cycles (no number may appear in more than one cycle).

Note that (1 4)(2 3) = (4 1)(2 3) = (3 2)(4 1) and so on. Write down the first in the lexicographic order where (1 4)(2 3)<(3 2)(4 1)<(4 1)(2 3).  
Don’t print the 1-cycle permutations like (1) or (3) that move nothing in the decomposition even if they might be present as input. There might be only one permutation and the result might be the original. If the permutation moves nothing, print () (two parentheses).
Look at the examples below.

Example, (1 3)(1 2 3)(1 3):
```
1→3 then 3→1 then 1→3
2→2 then 2→3 then 3→1
3→1 then 1→2 then 2→2
```
Conclusion, (1 3)(1 2 3)(1 3) = (1 3 2) (a 3-cycle).

The last example, (1 2 3)(1 4 3):
```
1→4 then 4→4
2→2 then 2→3
3→1 then 1→2
4→3 then 3→1
```
Conclusion, (1 2 3)(1 4 3) = (1 4)(2 3) (two disjoint 2-cycle).

# Input
* Single line The succession of permutations.

# Output
* Single line The result of their product.

# Constraints
* The input is properly formatted (no unpaired parentheses, etc.)
* 1 ≤ input ≤ 5
