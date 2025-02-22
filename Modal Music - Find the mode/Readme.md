# Puzzle
**Modal Music - Find the mode** https://www.codingame.com/contribute/view/89577b69420fda74872eb9ab520557679aca7

# Goal
This puzzle is about modal music, and the modal scales derived from the natural scale.  
For more information about modes in music, on https://en.wikipedia.org/wiki/Mode_(music) it's possible to hear the different modes discussed below.

The goal is to find the correct mode derived from the natural scale based on 7 given notes.  
Modes from the natural scale are Ionian, Dorian, Phrygian, Lydian, Mixolydian, Aeolian and Locrian and are more defined at the bottom.

Western music typically uses a system of 12 notes.  
These notes are named here following the international notation :  
A, A#, B, C, C#, D, D#, E, F, F#, G, G#.  
We can also write the notes using flats (b) instead of sharps (#). The notes become then :  
A, Bb, B, C, Db, D, Eb, E, F, Gb, G, Ab.  

In this system, there is no note between B and C and between E and F (on a keyboard, there is no black key between those), so there will be no E#, B#, Fb or Cb.  

Also, in this puzzle, flats (b) and sharps (#) will only be considered as below and above, so for example, A# and Bb must be treated as equivalent.

Then, the available notes are : A, A#/Bb, B, C, C#/Db, D, D#/Eb, E, F, F#/Gb, G, G#/Ab.

In this order, there is 1 semitone between two consecutive notes (as between two consecutive keys on a keyboard), and 1 between G#/Ab and A because the cycle repeats.  
For example, between a B and an Eb, there are 4 semitones (from B, count one for C, Db, D and finally Eb), and between an F# and a C#, there are 7 semitones (from F# count one for G, G#, A, A#, B, C and finally C#).  

In the input, as all the notes will be given in the right order, finding the mode only depends on the intervals between notes in this order. The output consists of the fundamental (or tonic) and the mode. The fundamental is the first note in the input, and it gives the tonality. The mode provides information about intervals used.  
For example : the input A B C D E F G must result in A Aeolian while C D E F G A B must result in C Ionian, even if the notes are the same.

Based on the number of semitones between the first given note (the fundamental) and the next 6, it is possible to find the mode by using the following table :
```
Semitones  | 0 |+1 |+2 |+3 |+4 |+5 | +6  |+7 |+8 |+9 |+10|+11|
Intervals  | - |2m |2M |3m |3M | 4 |4#/5b| 5 |6m |6M |7m |7M |
           |   |   |   |   |   |   |     |   |   |   |   |   |
Ionian     : x |   | x |   | x | x |     | x |   | x |   | x |
Dorian     : x |   | x | x |   | x |     | x |   | x | x |   |
Phrygian   : x | x |   | x |   | x |     | x | x |   | x |   |
Lydian     : x |   | x |   | x |   |  x  | x |   | x |   | x |
Mixolydian : x |   | x |   | x | x |     | x |   | x | x |   |
Aeolian    : x |   | x | x |   | x |     | x | x |   | x |   |
Locrian    : x | x |   | x |   | x |  x  |   | x |   | x |   |
```

For example, according to the table, the Dorian scale is made of the fundamental, a major second (+2 semitones), a minor third (+3), a perfect fourth (+5), a perfect fifth (+7), a major sixth (+9) and a minor seventh (+10).  

Then, the input E F# G A B C# D must result in E Dorian as if we count the semitones from E we have :
```
 E   F#   G   A   B   C#   D
 0   +2  +3  +5  +7   +9  +10
```

This pattern matches the Dorian scale.

The given lists of notes will always match one of these patterns.  

Note that for Latin-based languages C is Do or Ut, D is Ré or Re, E is Mi, F is Fa, G is Sol, A is La and B is Si or Ti.  
In German, Scandinavians and Slavs languages, the B used here is the H.  

# Input
* One line being a string of comma-separated notes.

# Output
* One line as Fundamental Mode (space-separated)

# Constraints
* Each note in notes can only be A, A#, Bb, B, C, C#, Db, D, D#, Eb, E, F, F#, Gb, G, G# or Ab
