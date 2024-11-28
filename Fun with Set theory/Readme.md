# Puzzle
**Fun with Set theory** https://www.codingame.com/training/medium/fun-with-set-theory

# Goal
Write a program that, given an expression composed of finite sets, unions, intersections, differences and parentheses, returns the values contained in the resulting set.

# Input
* A string consisting of N sets, unions ('U'), intersections ('I'), differences ('-') and parentheses.
* A set can be written with brackets [ ], or braces { }. It contains whole numbers, positive or negative, separated by semicolons ';'.
    - If the set is written with braces, then it contains only the values between braces, eg {4;3;-2} contains only the values 4, 3 and -2.
    - If the set is written with brackets, then it is an interval, eg: [-2;2] contains the values -2, -1, 0, 1 and 2.

Pay attention to the orientation of the brackets: the set can also be noted [a;b[ for example, in this case it contains all the values of a included to b excluded. You will encounter all the variants: ]a;b[, ]a;b], [a;b[ and [a;b].

Sets' endpoints with braces are not necessarily ordered, while sets' endpoints with brackets are always ordered.

Pay attention to parentheses, which prioritize some operations over others.

# Output
* All the numbers contained in the resulting set, ordered, separated by spaces.
* If the resulting set is empty, instead print EMPTY.

# Constraints
* 1 ≤ N ≤ 10
* -100 ≤ numbers ≤ 100
