# Puzzle
**The Resistance** https://www.codingame.com/training/expert/the-resistance

# Goal
You work in the National Resistance Museum and you just uncovered hundreds of documents which contain coded Morse transmissions.   
In the documents, none of the spaces have been transcribed to separate the letters and the words hidden behind the Morse sequence.   
Therefore, there may be several interpretations of any single decoded sequence.  

Your program must be able to determine the number of different messages that it’s possible to obtain from one Morse sequence and a given dictionary.

*Rules*  
Morse is a code composed of dots and dashes representing the letters of the alphabet. Here is the transcription of an alphabet in Morse:
```
 A  .- 	   B  -... 	 C  -.-. 	 D  -..
 E  . 	   F  ..-. 	 G  --. 	 H  ....
 I  .. 	   J  .--- 	 K  -.- 	 L  .-..
 M  -- 	   N  -.     O  --- 	 P  .--.
 Q  --.-   R  .-. 	 S  ... 	 T  -
 U  ..-    V  ...- 	 W  .-- 	 X  -..-
 Y  -.--   Z  --..
``` 
 
Since none of the spaces have been transcribed, there may be several possible interpretations.   
For example, the sequence -....--.-. could be any of the following: BAC, BANN, DUC, DU TETE, ...  

A human being can recognize where the segmentations should be made due to their knowledge of the language, but for a machine, it’s harder.   
In order for your program to do the same, you are given a dictionary containing all of the right words.

However, even with a dictionary, it’s possible that a sequence might correspond to several valid messages (BAC, DUC, DU and TETE might be present in the dictionary of the previous example).

# Input
* Line 1: a Morse sequence with a maximum length L
* Line 2: an integer N corresponding to the number of words in the dictionary
* The N following lines: one word from the dictionary per line. Each word has a maximum length M and only appears once in the dictionary.

# Output
* An integer R corresponds to the number of messages that it is possible to generate with the Morse sequence and the dictionary.

# Constraints
* 0 < L < 100000
* 0 < N < 100000
* 0 < M < 20
* 0 ≤ R < 2^63
