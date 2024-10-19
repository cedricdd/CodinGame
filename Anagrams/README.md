# Puzzle
**Anagrams** https://www.codingame.com/training/medium/anagrams

# Goal
You will be given a scrambled word phrase. You must unscramble the letters to reveal the original phrase.  
Each phrase has been scrambled by the following process:   

1) Find every 2nd letter of the alphabet in the phrase (B, D, F, etc.) and reverse their order within the phrase.

For example:  
Phrase: MOSTLY HARMLESS  
2nd letters: TLHRL  
Reversed: LRHLT  
Result: MOSLRY HALMTESS  

2) Find every 3rd letter of the alphabet in the phrase (C, F, I, etc.) and shift their positions one to the right, with the last letter wrapped around to the first position.

For example:  
Phrase: MOSLRY HALMTESS  
3rd letters: OLRL  
Shifted: LOLR  
Result: MLSOLY HARMTESS  

3) Find every 4th letter of the alphabet in the phrase (D, H, L, etc.) and shift their positions one to the left, with the first letter wrapped around to the last position.

For example:
Phrase: MLSOLY HARMTESS  
4th letters: LLHT  
Shifted: LHTL  
Result: MLSOHY TARMLESS  

4) Count the number of letters in each word, and reverse that list of numbers, re-applying the revised word lengths to the letter sequence.

For example:  
Phrase: MLSOHY TARMLESS  
Word lengths: 6, 8  
Reversed: 8, 6  
Result: MLSOHYTA RMLESS  

Therefore, if your input is scrambled phrase MLSOHYTA RMLESS, you must return MOSTLY HARMLESS.

# Input
* Line 1: A scrambled word phrase

# Output
* The unscrambled phrase

# Constraints
* Only upper-case characters [A-Z] are used.
