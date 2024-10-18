# Puzzle
**Anagram to break the code!** https://www.codingame.com/training/easy/anagram-to-break-the-code

# Goal
You are given a word and a sentence. To break the code, you must identify the key, which is the first anagram of the word in the sentence.  
Then the code is a 4 digits code defined like that from left to right:  
1st digit : number of words found before the key  
2nd digit : number of words found after the key  
3rd digit : number of letters before the key  
4th digit : number of letters after the key  

# Rules
- For all numbers we keep only the rightmost digit
- If there is no anagram of the given word, print IMPOSSIBLE
- Words are separated by a space or by a punctuation mark
- A word is not an anagram of itself
- In the sentences, we can find only letters and the following punctuation marks: : . , ? ! But we count only letters for the code.

Example:  
god  
my dog scared them away  

The key is dog  
1st digit: 1 word before the key  
2nd digit: 3 words after the key  
3rd digit: 2 letters before the key  
4th digit: 14 letters after the key so rightmost digit is 4  
The code is: 1.3.2.4  

# Input
* Line 1: a word w for the word that match with an anagram in the following sentence
* Line 2: a sentence s for the sentence with an anagram

# Output
* The code with the following format: d.d.d.d where d is a digit.
