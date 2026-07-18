# Puzzle
**Hagrid speaking** https://www.codingame.com/contribute/view/1518480e8b0b6f175d3867ccf1ae8aeb13d0f0

# Goal
Help J. K. Rowling in her writing. Indeed, Hagrid has a distinctive way of speaking.

Replace the letter and the words  
The final letter of each word is replaced by ' if it is f, t, d or g or their capital letter.  
The first letter of each word is replaced by ' if it is h of H.  
The word you is replaced by the word yeh.  
The word to is replaced by the word ter.  
The word and is replaced by the word an'.  
The word me is replaced by the word meh.  

You have to be careful to modify only Hagrid's sentences.  
The sentences are considered as a Hagrid speaking if Hagrid is mentioned as the speaker, in other words, outside the quotation marks.  
For example :  
* ✅"You going to the forest?" Asked Hagrid. => Hagrid is the speaker in this sentence because he is mentionned outside the quotation marks.
* ❌"No it's ok Hagrid. I just want to reach the castle before lunch." Replied Harry fearfully. => Hagrid is NOT the speaker in this sentence because he is NOT mentioned outside the quotation marks.

The punctuation must not be altered.  
If a word is part of a hyphenated term like "can't", "right-handed" or "it's" it should not be modified.  
A word is considered a word when it is separated from its neighbors by a space. If a word ends with punctuation, care must be taken to modify it accordingly, as if the punctuation were not there.  

Take care of the case sensitive.  
The transformation must preserve the original case sensitivity.  

For example:  
* YoU => YeH
* going => goin'

# Input
* Line 1 : An integer N for the number of lines.
* N next lines : The lines to transform.

# Output
* N lines : The lines transformed.

# Constraints
* 1 ≤ N ≤ 20
* 20 ≤ line.length ≤ 120
