# Puzzle
**Dynamic sorting** https://www.codingame.com/training/medium/dynamic-sorting

# Goal
Sorting in a webApi should be tricky as you have to pass all your parameters in a single URL in a GET request, your team decided to do use this convention to order the result by prop1 ascending, then by prop2 descending, then by prop3 ascending.  
+prop1-prop2+prop3

You have to read the given items and print their Ids ordered by the given sorting expression.

# Input
* Line 1 : The sorting expression
* Line 2: The associated types of previously given properties separated by ","
* Line 3 : An integer N of the next input lines
* N next lines an object formatted like this: prop1:value1,prop2:value2,prop3:value3

# Output
* The sorted objects ids (there will always be an id property which is an integer).
* In case all property fields have the same values, sort it by the id acsendingly.

# Constraints
* Types can be "int" or "string"
