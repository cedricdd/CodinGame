# Puzzle
**Calculator** https://www.codingame.com/training/easy/calculator/solution

Your task is to output the screen of a calculator when a key is pressed. For example:  
- Input 3: Output 3
- Input 4: Output 34
- Input +: Output 34
- Input 2: Output 2
- Input 3: Output 23
- Input -: Output 57
- Input 4: Output 4
- Input =: Output 53
- Input AC: Output 0

The calculator doesn't take into account the priority of the operators. If the user presses:
```
2 + 3 x 5
```
the final output will be 25  
The user may press two operation keys consecutively. In that case, the operation that must be taken into account is the second one.  
If the result has decimal numbers, it must be output with, at most, 3 decimal numbers. Otherwise, it must be output without a decimal point. Decimal numbers are also stored rounded with 3 decimal ciphers.  
If the user presses the = key consecutively, the last operation should be performed repeatedly. For example, 1 0 - 3 = = = is the same as calculating 10 - 3 - 3 - 3.  

# Input
* Line 1: An integer n for the number of keys to press.
* Next n lines: A string that shows the key pressed.

# Output
* n lines: The output of the screen after each key is pressed

# Constraints
* The key will be one of these: 0-9, +, -, x, /, =, AC
* Neither test cases nor validator will divide by zero. First key will always be a cipher.
