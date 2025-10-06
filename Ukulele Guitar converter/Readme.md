# Puzzle
**Ukulele Guitar converter** https://www.codingame.com/training/easy/ukuleleguitar-converter

# Goal
In this puzzle you have to create a ukulele/guitar converter.  
Given the position of a finger on the neck of a guitar, you will need to find the set of positions on the ukulele that produce the same frequency. And vice versa.  

We consider here a guitar with six strings and 21 frets with classical tuning (E2, A2, D3, G3, B3, E4) and a ukulele with 4 strings and 15 frets with classical tuning as well (G4, C4, E4, A4).

I'm just going to give the following indications : Going from fret N to fret N+1 on a ukulele or guitar neck for a given string is going to the next note and fret 0 corresponds to an "open" string, and therefore to the note specified in the part on tuning. The notes follow this pattern:
```
C0→C0#→D0→D0#→E0→F0→F0#→G0→G0#→A0→A0#→B0→C1→C1#→D1→...
```

Here is a representation of a guitar neck, the frets are the vertical bars and the strings are the horizontal ones, we place the fingers at the intersections between the strings and the frets:
```
  21 20 19 18 17 16 15 14 13 12 11 10 9  8  7  6  5  4  3  2  1  
--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|-- E2
--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|-- A2
--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|-- D3
--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|-- G3
--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|-- B3
--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|--|-- E4
```
Same thing for a ukulele:
```
   15  14  13  12  11  10  9   8   7   6   5   4   3   2   1  
---|---|---|---|---|---|---|---|---|---|---|---|---|---|---|--- G4
---|---|---|---|---|---|---|---|---|---|---|---|---|---|---|--- C4
---|---|---|---|---|---|---|---|---|---|---|---|---|---|---|--- E4
---|---|---|---|---|---|---|---|---|---|---|---|---|---|---|--- A4
```

Step-by-step explanation of the first test case:

You have to find where to put your finger on a ukulele neck to get the same note as if we placed our finger on the 8th fret of the third string of the guitar.  
First, we must calculate the note given by this position on the guitar.   
The note for this string when played without any resting fret is G3. We press the 8th fret so we get D4# (because G3→G3#→A3→A3#→B3→C4→C4#→D4→D4#).  

Then we move on to the ukulele. For strings n°1, 2 and 4 of the ukulele, the notes of the strings played without pressed frets are already after the desired notes in the scale (too high) and there is therefore no correspondence on these strings.  
The note of the third open string, which is C4, is well before the desired note. To obtain the desired note, you must move 3 times to the next note (C4→C4#→D4→D4#).  
So the third fret of the third string is the solution. As we number the strings from 0, the output must be 2/3.  


To solve this puzzle it is possible to focus on the note-frequency relationships rather than the order of the notes (even though it is not necessary).   
So here is some additional information about the frequencies:  
- Moving to the next note in the scale means multiplying the frequency by 2^(1/12)
- You will find in the "Table of note frequencies" part of this article the note/frequency correspondence: https://en.wikipedia.org/wiki/Scientific_pitch_notation

# Input
* Line 1 : Either guitar or ukulele. guitar if you need to convert from guitar to ukulele, ukulele if otherwise.
* Line 2 : An integer n for the number of positions to convert.
* n next lines : Two integers string and fret, separated by a space, string describes the string played and fret the fret pressed.
* If string is 0, it corresponds to the string at the bottom of the neck (E4 for guitar or A4 for ukulele), and then they are numbered from bottom to top.
* If fret is 0, it corresponds to a string played without any resting fret, if fret is 1, it corresponds to a string played with the first fret and so on...

# Output
* n lines : Each line is a list of pairs of integers string_out and fret_out, which correspond to a string and a fret on the other instrument which produce the same note. 
* Each pair must be must be written in the form string_out/fret_out and pairs are separated by a space. Pairs must be given in ascending order. If there is no match, return no match.

# Constraints
* 1 ≤ n < 10
