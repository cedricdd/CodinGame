# Puzzle
**The Michelangelo Code** https://www.codingame.com/training/easy/the-michelangelo-code

# Goal
Are secret messages hidden in famous texts?

Search the given TEXT for evenly spaced letters which form WORDs from the given list. Ignore punctuation, capitalization, and spacing.

Print the section of TEXT that contains the longest hidden WORD, in lowercase and omitting all non-letters.   
Highlight the hidden WORD with UPPERCASE. There will be only one such longest word. 

# Input
* Line 1: A string of TEXT to search in.
* Line 2: An integer N for the number of words in the list.
* Next N lines: A string of a WORD to search for.

# Output
* Line 1: The portion of TEXT which contains the longest WORD, in lowercase except for the evenly spaced letters of WORD, with all non-letters removed.

# Constraints
* Length of TEXT < 1000
* 1 ≤ N ≤ 2000
* Length of WORD < 25
