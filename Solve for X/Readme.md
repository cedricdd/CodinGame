# Puzzle
**Solve for X** https://www.codingame.com/training/hard/solve-for-x

# Goal
This puzzle builds on the concepts explored in the puzzle 24: The Long Game by @jddingemanse.   
Significant insight can be gained by solving that puzzle before working through this one: https://www.codingame.com/training/hard/24-the-long-game

In this puzzle, you are given an equation with a variable x somewhere in that equation.   
Your task is to REARRANGE the terms of the expressions on either side of the equal sign to produce an equation in the following form: x=expression

The expression on the right side of the equal sign must be in "standard form" per the rules identified in 24:   
The Long Game. For your convenience, those rules are copied below. To see these rules applied to a sample expression, please refer back to 24: The Long Game.

EXPRESSIONS, TERMS AND SUBEXPRESSIONS  
To understand the rules for rewriting expressions, we must distinguish expressions, terms and subexpressions.  

expression: Terms separated by mathematical operators that can be evaluated from left to right. For example: 1+2+3+18, 3*2*1*4, 24+10-6-4, 24/1/1/1 or 2*3*40/10.

term: A constant or a subexpression. The expression 3+7*(1+2) has two terms. The first term is the constant 3. The second term is the subexpression 7*(1+2) - which itself also consists of one constant 7 and one subexpression (1+2).

subexpression: A subexpression is an expression that must be evaluated before the parent expression can be evaluated. The expression (1+2)*(9-1) consists of two terms, both of which are subexpressions: (1+2) and (9-1). The expression 20+6/3+2 consists of three terms, of which one is a subexpression: 6/3 (the other two terms are the constants 20 and 2).

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
- This does not apply to operators in two different subexpressions: in (3-1)*(5+7), the - and + are not part of the same subexpression, so their order is not decided by this rule (instead, use rule 3c for this case).

3. For cases not decided by rule 2, sort terms of expressions and subexpressions
1) Sort constants in ascending order: 3*(16-5-3)→3*(16-3-5), 4+5*4*1→4+1*4*5, 25-10/5/2→25-10/2/5
2) Place constants before subexpressions: (16-3-5)*3→3*(16-3-5), 5*8/4+14→14+5*8/4
3) Sort two subexpressions according to their numerical value: 4*5+1*4→1*4+4*5 (1*4 < 4*5), (5+7)*(3-1)→(3-1)*(5+7) (3-1 < 5+7)  
In the case of equal value, sort the subexpressions as strings, based on the ASCII value of characters: 48/4+3*4→3*4+48/4 ('3*4' < '48/4')

# Input
* Line 1: An integer numEquations indicating the number of equations to be solved (rearranged).
* Next numEquations lines: A string equation.

# Output
* Line 1: A string 'x=expression' with the expression rewritten in standard form.

# Constraints
* numEquations <= 40
* length(equation) < 100
* equation is always a valid equation and contains only one x, one =, and the characters 0 to 9, +, -, *, /, ( and ).
* The following two constraints ensure each equation is in the set of equations fully covered by the rules of 24: The Long Game.
* There is no explicit zero term anywhere in any equation.
* No expression or subexpression in the equation will ever begin with a negative sign (-).
