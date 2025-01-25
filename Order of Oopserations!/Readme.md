# Puzzle
**Order of Oopserations!** https://www.codingame.com/training/hard/order-of-oopserations

# Goal
Will has a low IQ. In order to show everyone what he is made of, he decided to write his own programming language.  
However, his low IQ got the better of him and he implemented the order of operations incorrectly!  

From highest to lowest priority, here are the operators and what they mean:
* \- (Unary): Negation
* \+: Addition
* \/: Division
* \-: Subtraction
* \*: Multiplication

For example, the statement 6+-3*5 would be interpreted as (6 + (-3)) * 5 because - (Unary) has a higher priority than +, which has a higher priority than *.

Your goal is to evaluate the given expression and output the correct answer with these jumbled order of operations.

# Input
* An N character string expression containing the expression you need to evaluate.
* The expressions contains only decimal digits and operators. No whitespace or parentheses.

# Output
* A number representing the result of the expression.

# Constraints
* 1 <= N <= 200
* Operations are left-associative.
