# Puzzle
**orDer oF succeSsion** https://www.codingame.com/training/easy/order-of-succession

# Goal
You have to output the order of succession to the British throne of a list of given people.  
The order is simple:  
From a descendant A, the next in the order is A’s first child B.  
Then, the next one is B’s first child C if any and so on.  
If C has no child, then the next one is B’s second child D.  
Then D’s children if any. Then B’s third child E… then A’s second child F…  

Let’s draw it with a tree:
```
      A1
    ┌─┴─┐
    B2  F6
 ┌──┼──┐
 C3 D4 E5
```

You see the order of succession: begin on the left of the tree, walk to the next level whenever possible otherwise continue to the right. 
Repeat until the whole tree is covered.  
Thus, the order is A-B-C-D-E-F.  

In fact, in siblings of the same person, the male descendants are ordered before the female descendants.   
For example, if the order of birth of the children (M for male, F for female) is Fa Ma Me Fe then the order of succession in these siblings is Ma Me Fa Fe.  

Ordering rules  
1) in order of generation
2) in order of gender
3) in order of age (year of birth)

Outputting rules  
1) exclude dead people (but include siblings of dead people)
2) exclude people who are catholic (but include siblings of catholic people)

Note that this puzzle has been written in June, 2017 (some people might have died since this date).

# Input
* Line 1: The number of people n
* Next n lines: Name Parent Year of birth Year of death Religion Gender
* If the people is not dead then the year of death is replaced by the hyphen -.

# Output
* One name per line, in the order of succession to the throne: first the Queen, then all her descendants.

# Constraints
* Exactly one people does not have a parent (the parent’s name is replaced by the hyphen -).
* No two siblings of the same gender of a person have the same year of birth.
* 1 ≤ n ≤ 100
