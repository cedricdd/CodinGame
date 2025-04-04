# Puzzle
**Function notation** https://www.codingame.com/training/medium/function-notation

# Goal
Given a function that is exclusively the outcome of function compositions and function sums, rewrite it by replacing the composition operator . with the reverse composition operator |>.

The reverse function composition operator behaves, unsurprisingly, by reversing the order of function application, that is:
```
(f |> g) (x) = g(f(x))
```
Examples:
```
f . g         --   g |> f
f + g         --   f + g
f . g + h     --   g |> f + h
(f + h) . g   --   g |> (f + h)
f . (g + h)   --   (g + h) |> f
g + f . h     --   g + h |> f
```

*Notes:*  
1) Function names are only one lowercase English letter.
2) The + and . operators are given between spaces for easier visualization.
3) As shown in the example, parentheses are relevant.
4) The expressions are well behaved. They don't contain unnecessary parentheses like f . (( g + h )) or consecutive + signs etc.
5) For debugging, notice how the transformation from . to |> is symmetric, and that the same logic, from |> to . should give back the original test.

# Input
* Line 1: An string function representing a function that is exclusively the outcome of function compositions and function sums.

# Output
* One line containing the original function rewritten with the |> operator.

# Constraints
* Function names are only one lowercase English letter.
* 0 < length function < 256
