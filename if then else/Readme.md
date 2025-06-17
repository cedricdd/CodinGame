# Puzzle
**if then else** https://www.codingame.com/training/medium/if-then-else

# Goal
```
begin
  if (condition1) then
    action1
  else
    action2
  endif
  
  if (condition2) then
    action3
  else 
    action4
  endif
end
```

How many different results this program can produce?  
Answer is 4.  

By varying combination of condition1 and condition2, there are 4 possible different results:  
* action1, action3
* action1, action4
* action2, action3
* action2, action4

In this puzzle, our focus is to evaluate the program logical structure.  
We do not care what conditions are given nor what actions are to happen.  
We just want to know the number of result combinations.  

To ease evaluation, we normalize the syntax of the program.  

* "if...then" is represented by "if". We assume there should always be a condition, hidden, after "if".
* We assume following an "if" line there is always one (no more, no less) related "else" line. "if..else" will be finalized by an "endif" line to make a complete statement.
* Nested conditions are allowed.
* Action statements are represented by "S". It can appear anywhere within the program to perform actions. We are lazy sometimes we may omit writing it but you have to assume within an if-else-endif structure there is always at lease one action statement (can be hidden) for the "true" condition and another one (also can be hidden) for the "false" condition.
* The whole program is enclosed by begin and end
* We do not indent the lines; we do not insert blank lines.

The above example program can be normalized as:
```
begin
if
else
endif
if
else
endif
end
```

Your task is to evaluate some normalized program structures to tell the number of result combinations.

# Input
* Line 1 : N, the number of lines in the program.
* The following N lines are the normalized program codes.
* There is no unnecessary space at the front or end of the lines.
* You can assume all given codes are syntactically correct.

# Output
* Line 1 : The number of result combinations

# Constraints
* 2 ≤ N ≤ 195
