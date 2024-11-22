# Puzzle
**Enigma - 3 rotors without plugboard** https://www.codingame.com/training/medium/enigma---3-rotors-without-plugboard

# Goal
The Enigma machines were a series of rotor cypher machines. Such machine is made of four main elements:
- a keyboard,
- a plugboard to substitute letters,
- several rotors and a reflector,
- lamps to read the result.

For this puzzle, we will always use three rotors and no plugboard.

*The rotors*  
A rotor consists of 26 wires linking an alphabet on one side to different positions in another alphabet on the other side.   
For example, B on one side might connect to K on the other side. When a key is pressed, electric signal passes through one wire each of three rotors in sequence, then through the reflector, then back through the rotors in the opposite direction.

The rotors will rotate, wires change position and the alphabet substitutions will change.

*Effect of a rotation*  
Let's take rotors with only 5 letters (A, B, C, D, E).  
There are wires that set substitutions:  
A - B, B - D, C - E, D - C, E - A  
After both alphabets rotate around these wires, the substitution will become:  
E - A, A - C, B - D, C - B, D - E, then D - E, E - B, A - C, B - A, C - D,

Conditions leading to a rotation

Each rotor has a triggering position (defined as letter) that may have effects on rotation depending on rotors position.  
To make it simple:  
* All rotations are done before coding and ouput is based on new positions.
* The first rotor rotate when a key is pressed.
* If first rotor reaches its triggering position, the second rotor will rotate at the next input.
* If second rotor reaches its triggering position, at next input, the third rotor and the second rotor (once again) will rotate.

*Usage of an Enigma machine*  

Cypher keys are set based on the three rotors' starting position and wires on plugboard.

Input wires describe the rotor at position A. One rotation -> position B. Another rotation -> position C.

In order to process a message, we have to take each input letter, make it go through all the rotors (from 1 to 3), then the reflector, and finally through all the rotors in reverse order (so, from 3 to 1).

*Example*  
In Test 1 below, rotor 1 starts in position A, which includes the wire Y-C. Pressing the X key causes rotor 1 to rotate such that that wire is now X-B. Wire T-P becomes S-O.  
Then the input X becomes B, B becomes J, J becomes T. The reflector swaps T to Z. Returning through the rotors, Z becomes M, M becomes O, and O becomes S.

*References*  
If you want to learn more about Enigma, you can look at this page: https://meinenigma.com/enigma-simulators/ .

# Input
* Wire are written as "A-B" or "C-D"
* Line 1 rotor 1: 26 wire space separated
* Line 2 rotor 1 triggering position char
* Line 3 rotor 2: 26 wire space separated
* Line 4 rotor 2 triggering position char
* Line 5 rotor 3: 26 wire space separated
* Line 6 rotor 3 triggering position char
* Line 7 reflector: 26 wire space separated
* Line 8 starting position each rotor: char char char
* Line 9 message: string

# Output
* The string obtained by typing the given message on the enigma machine described in the inputs.

# Constraints
* There will always be three rotors and one reflector, each operating on the letters from 'A' to 'Z'.
* Message Length < 1000 characters
