# Puzzle
**Hagrid speaking** https://www.codingame.com/training/easy/hagrid-speaking

# Goal
Help J. K. Rowling in her writing. Indeed, Hagrid has a distinctive way of speaking.

Apply letter and word transformations  
* The final letter of each word is replaced by ' if it is f, t, d or g (case-insensitive).
* The first letter of each word is replaced by ' if it is h or H.
* The transformation should only take place if the word is longer than two characters.  

* The word you is replaced by the word yeh.
* The word to is replaced by the word ter.
* The word and is replaced by the word an'.
* The word me is replaced by the word meh.

Word replacements are applied regardless of case. Letter transformations do not apply to words already modified by word replacements.

You have to be careful to modify only Hagrid's sentences.  
The sentences are considered as a Hagrid speaking if Hagrid is mentioned as the speaker, in other words, outside the quotation marks.  
For example :  
* ✅"You going to the forest?" Asked Hagrid. => Hagrid is the speaker in this sentence because he is mentionned outside the quotation marks.
* ❌"No it's ok Hagrid. I just want to reach the castle before lunch." Replied Harry fearfully. => Hagrid is NOT the speaker in this sentence because he is NOT mentioned outside the quotation marks.

Only the standalone word Hagrid (case-sensitive) counts, for example:  
❌ McHagrid
❌ Hagride
❌ hagrid
✅ Hagrid

The punctuation must not be altered.  
If a word is part of a hyphenated term like "can't", "right-handed" or "it's" it should not be modified.  
A word is considered a word when it is separated from its neighbors by a space. If a word ends with punctuation, care must be taken to modify it accordingly, as if the punctuation were not there.  

Take care of the letter case.  
The transformation must preserve the original case pattern. If the replacement is longer than the original word, any extra letters inherit the case of the last original letter.  

For example:
YoU => YeH  
going => goin'  
TO => TER  
mE => mEH  
Hello => 'ello  

# Input
* Line 1 : An integer N for the number of lines.
* N next lines : The lines to transform.

# Output
* N lines : The lines transformed.

# Constraints
* 1 ≤ N ≤ 20
* 1 ≤ length of line ≤ 150
* line contains either 0 or 2 ".
