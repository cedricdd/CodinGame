# Puzzle
**The Long Game** https://www.codingame.com/training/hard/24-the-long-game

# Goal
In the 24 Game, a given set of four numbers must be combined using only the arithmetic operations + - × ÷ with parentheses ( ) if necessary to define the order in which operations are carried out.   
All four numbers must be used so that the end result is 24. The given numbers may be rearranged in any order; that is, the original order need not be followed.   
Normally, one solution is enough - if you prefer that, you can solve the following puzzle:  

https://www.codingame.com/training/medium/24-game by @Smelty

For this puzzle, your program must provide the number of possible solutions (ns) and all those possible solutions, or not possible if there are no solutions.

Solutions must be printed as expressions without spaces, for example 3*(2*7-6). Only unique solutions should be included in the output. This requires rewriting expressions in a consistent way.

EXPRESSIONS, TERMS AND SUBEXPRESSIONS  
To understand the rules for rewriting expressions, we must distinguish expressions, terms and subexpressions.  

expression: Terms separated by mathematical operators that can be evaluated from left to right. For example: 1+2+3+18, 3*2*1*4, 24+10-6-4, 24/1/1/1 or 2*3*40/10.

term: A constant or a subexpression. The expression 3+7*(1+2) has two terms. The first term is the constant 3.   
The second term is the subexpression 7*(1+2) - which itself also consists of one constant 7 and one subexpression (1+2).  

subexpression: A subexpression is an expression that must be evaluated before the parent expression can be evaluated.   
The expression (1+2)*(9-1) consists of two terms, both of which are subexpressions: (1+2) and (9-1).   
The expression 20+6/3+2 consists of three terms, of which one is a subexpression: 6/3 (the other two terms are the constants 20 and 2).  

REWRITING EXPRESSIONS  
Only rewrite an expression such that it remains mathematically the same.  
Rewrite expressions according to the following three rules:  

1. Use as few parentheses as possible.
- Remove unnecessary parentheses: (1*2)*3*4→1*2*3*4
- Rewrite an expression, if necessary: 9+18-(2+1)→9+18-2-1, 12/(3/(2+4))→12*(2+4)/3

2. Sort operators: + before - and * before /.
- Change the order of terms such that for their connecting operators + comes before -, and * comes before /
- Do this within a parent expression: 8-3+9+10→8+9+10-3, 2/3*6*6→2*6*6/3, 8-2+3*6→8+3*6-2
- Do this within a subexpression: 3*(5-4+7)→3*(5+7-4), 8+6/3*8→8+6*8/3
- This does not apply to operators in two different subexpressions: in (3-1)*(5+7), the - and + are not part of the same subexpression, 
so their order is not decided by this rule (instead, use rule 3c for this case).

3. For cases not decided by rule 2, sort terms of expressions and subexpressions
- Sort constants in ascending order: 3*(16-5-3)→3*(16-3-5), 4+5*4*1→4+1*4*5, 25-10/5/2→25-10/2/5
- Place constants before subexpressions: (16-3-5)*3→3*(16-3-5), 5*8/4+14→14+5*8/4
- Sort two subexpressions according to their numerical value: 4*5+1*4→1*4+4*5 (1*4 < 4*5), (5+7)*(3-1)→(3-1)*(5+7) (3-1 < 5+7)
- In the case of equal value, sort the subexpressions as strings, based on the ASCII value of characters: 48/4+3*4→3*4+48/4 ('3*4' < '48/4')

EXAMPLE  
With values 2,2,3,5, there are 8 non-unique solutions, but after applying above described rules, only one unique solution remains.  
```
(2*5-2)*3→3*(2*5-2) [rule 3b]
(5*2-2)*3→3*(2*5-2) [rule 3a and rule 3b]
3*(2*5-2)
3*(5*2-2)→3*(2*5-2) [rule 3a]
((2*5)-2)*3→3*(2*5-2) [rule 1 and rule 3b]
((5*2)-2)*3→3*(2*5-2) [rule 1, rule 3a, rule 3b]
3*((2*5)-2)→3*(2*5-2) [rule 1]
3*((5*2)-2)→3*(2*5-2) [rule 1 and rule 3a]
```

SORTING MULTIPLE UNIQUE SOLUTIONS  
After applying above rules, you might still end up with multiple solutions. Output them in the following order:  
- Solutions without parentheses ( a+b+c+d )
- Solutions with one set of parentheses ( a*b*(c+d) )
- Solutions with two sets of parentheses ( (a+b)*(c+d) )
  
Multiple solutions within the same category should be sorted as strings, based on the ASCII value of the characters.

Credits to @Timinator for co-authoring the goal statement and some of the test cases

# Input
* Line 1: four space separated integers a, b, c, d

# Output
* Line 1: not possible or number of unique solutions (ns)
* Next ns lines: all unique solutions as expressions without spaces

# Constraints
* 0 <= a, b, c, d <= 100
