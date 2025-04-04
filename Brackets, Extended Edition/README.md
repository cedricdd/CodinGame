# Puzzle
**Brackets, Extended Edition** https://www.codingame.com/training/medium/brackets-extended-edition

# Goal
You must determine whether a given expression's bracketing can be made valid by flipping them in-place.  
An expression has a valid bracketing when all the parentheses (), square brackets [], curly braces {} and angle brackets <> are correctly paired and nested.

You can flip a bracketing element in-place by replacing it with its counterpart, e.g. replace a ( with a ), or a > with a <.   
For example, converting the second parenthesis in the expression below would make it valid:
```
<{[(abc(]}> → <{[(abc)]}>
```

# Input
* Line 1: the number N of expressions
* Next N lines: an expression

# Output
* N lines: true if the expression can be made valid by flipping elements in-place; false otherwise.

# Constraints
* N ≤ 50
* expression length ≤ 10000
* number of bracketing elements ≤ 25
* The expression contains no whitespace.
