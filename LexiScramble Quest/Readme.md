# Puzzle
**LexiScramble Quest** https://www.codingame.com/training/medium/lexiscramble-quest

# Goal
You will be given a word word which shall be scrambled in all possible ways to form a dictionary. Your program must find the index of the word word in the dictionary so formed.

For example, if abcd is the word, you must return 1. And for the word abdc, it is 2.

Here is a sample of a dictionary formed by bac,  
1) abc  
2) acb  
3) bac  
4) bca  
5) cab  
6) cba

The order of "bac" in this dictionary is 3.  

Note:
1) The words are all arranged alphabetically in the dictionary.
2) Do not forget to eliminate the duplicate words.
3) The word can contain repeating letters as well, like in mississippi.
4) Optimize your code to handle longer words as well.
5) The words formed by the jumbling can be meaningful or meaningless.
6) The word in the input is always in lowercase.

# Input
* Line 1: A word word in lowercase

# Output
* Line 1: A num indicating the order of the word in the dictionary so formed.

# Constraints
* 0 < length word < 50
* word is lowercase
