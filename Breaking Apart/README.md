# Puzzle
**Breaking Apart** https://www.codingame.com/training/hard/breaking-apart

# Goal
In the wonderful words of Servatta they use a very peculiar language.  
They utilize the English alphabet for their writing, their vowels are "aeiou", the consonants are the rest.  
Words can be broken into syllables, a syllable consists of a vowel with at most two consonants on each side of it (so syllables can be of the form e, te, et or tet). Consonants tend to belong to the next vowel in the word, unless there's two of them next to each other (in which case they split Ser|vat), or it's the last letter in the word (Ser|vat).   
Having two consonants at the end of a word is not grammatically correct.  
When breaking up words at the end of the line, a hyphen gets placed at the end of one of the syllables, and the rest of the word continues on the next line:  
```
Servat-
ta
```

Lemi is the only journalist in the entire country and he types out every article in a very basic monospace text editor.  
He has the following way of breaking up lines manually: he tries to fill the current line with as many words as possible, then he tries to fit partial words into the remaining space. After this he moves onto the next line. He always pays attention so that he never breaks up a word if it would mean only one letter would be left before the hyphen though, so the following is invalid:  
```
a-
tara
```

One day Lemi has decided that he had enough, and swore to never type anything ever again, but because he doesn't want to get fired, he asked you to write a program that would do this for him instead.

# Input
* Line 1: An integer N for the width of the page in characters
* Line 2: The text S that needs to be handled

# Output
* Some number of lines with at most N characters each including the hyphens broken up by Lemi's method.

# Constraints
* 10 ≤ N ≤ 100
* 1 ≤ Length of S ≤ 500
* 1 ≤ Length of one word ≤ 200
* S consists of only upper and lowercase letters and spaces, for the purposes of this challenge, the text doesn't contain punctuation
