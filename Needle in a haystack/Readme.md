# Puzzle
**Needle in a haystack** https://www.codingame.com/training/medium/needle-in-a-haystack

# Goal
You are given a wall of characters, herein code-named the haystack, from which we want to find a needle, a sampling sub-string containing specific wanted elements.

All lines from the haystack should be concatenated into a long string. The haystack contains at most 36 different kinds of elements, represented by lower-case letters a-z and digits 0-9.

*Wanted elements*  

To define the wanted elements, we adopt a syntax commonly used by printers for defining pages, with modifications, like this:
```
[0-9] means [0 1 2 3 4 5 6 7 8 9] (all base-10 digits)
[a-e] means [a b c d e] (a sequence in alphabetical order)
[a-c,x-z,2,4,6,8] means [a b c x y z 2 4 6 8] (use hyphen and comma, without spaces)
[a-e,b] means [a b c d e] (in case of overlapping, deduplicate the result)
```

*Wanted needle*  

The ordering of elements is unimportant in our case. For example, if the wanted elements are [2-5], the target is to find a sub-string from the long haystack string such that the sub-string contains characters [2,3,4,5] in any order. Duplicates of characters are fine. Mixing in unwanted elements is also fine. A sub-string "3xx15443yy2" is a good match because all the four wanted digits are included. When the haystack is large enough, there can be many matches. We want the shortest sub-string fulfilling the requirements. "5443yy2" is a better match than the above one because it is shorter.

# Input
* Line 1: Integer w and h for the width and height of the haystack.
* Next h lines: String of characters of length w, making up the haystack.
* Next line: Integer n for the number of test cases based on the above haystack.
* Next n lines: Each line is an independent test case defining what kind of needle you need to find, written in the syntax described in the statement.

# Output
* Write n lines of answers corresponding to the test cases.
* Each line is composed of integers p q, space separated, marking the starting and ending indexes (0-based and inclusive) of a sub-string from the haystack that includes all wanted elements. The sub-string has to be as short as possible. If there is still a tie, choose one with the smallest p as the answer.

# Constraints
* 1 ≤ w ≤ 500
* 1 ≤ h ≤ 20
* 1 ≤ n ≤ 20
* The given haystack shall contain all wanted elements. There is always a unique solution to each test case.
