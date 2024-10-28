# Puzzle
**CG Chat interpreter** https://www.codingame.com/training/expert/cg-chat-interpreter---part-1

# Goal
You have found hidden meaning in the inane babblings of CG Chat. Write a program to make sense of the madness.  
This first puzzle introduces the concepts of numeric constants, arithmetic, and stack operations.

NOTE: CG Chat is case insensitive. Also, punctuation is ignored.

*NICKS*  
Nicknames (nicks) can be at the start of a line in angle brackets (< >) to indicate the current speaker:

<jim> Hello!

Nicks can also be mentioned by a speaker. The mentioned nick is surrounded by asterisks (*) to emphasize the reference:

<woody> Get over here, *buzz*!

*SET CONTEXT COMMAND*  
Each nick can only talk to one other nick at a time. This is the context of the conversation:

<john> Hey, *jude*!

jude is john's context. Context statements look like:

<{nick}> {flavor text} *{nick}* {flavor text}

Context can also be asserted for the current statement (takes place immediately) if *nick* occurs at the beginning of the statement.  
Once context is set for a nick, it persists until a new context is set.

*CONSTANTS*  
Constants are phrases that represent signed integers, and look like:

{a/an} {adjective(s)} {noun}

The "noun" (which may not actually be a noun) is from a provided list of "good" and "bad" nouns. Good nouns represent the value 1.  
Bad nouns represent the value -1. All words between a/an and noun are adjectives. Each adjective multiplies noun by 2. So for the phrase:

a slimy, sad eel

If eel is a bad noun, this phrase represents the constant -4: 2 x 2 x -1

*SPECIAL CONSTANTS*  
Represent the top value from the specified stack:
- "me" => the speaker's stack
- "you", "u" => the context's stack
- *{nick}* => nick's stack (no context change in this situation)

The referenced value is not removed from the corresponding stack.

*ARITHMETIC CONSTANTS*  
Arithmetic phrases can be used anywhere a {constant} can be used:
- {constant} squared
- {constant} and {constant} too => (a + b)
- {constant} but not {constant} though => (a - b)
- {constant} by {constant} multiplied => (a * b)

*ASSIGNMENT COMMAND*  
Words indicating the start of an assignment: "youre", "your", "ur"

This looks like:

{keyword} {flavor text} {constant}

For example:

<tom> *tina* UR such a good girl. U love u momma.

This pushes the value 2 onto the top of tina's stack

*STACK COMMANDS*  
- The keyword listen duplicates the top value of the context's stack
- The keyword forget pops the top value off the context's stack
- The keyword flip exchanges the top two values of the context's stack

*OUTPUT COMMAND*  
Each instance of the following words will pop then print the top value of the context's stack:
- "tell", "telling" - Print the top value as an integer

*HINT*  
All tests in this puzzle have one nick who explains what's happening. Pay attention to this.

# Input
* Line 1: Two space-separated integers, numGood and numBad indicating the number of "good" and "bad" nouns that will be declared. 
* Line 2: A space-separated list of numGood "good" nouns. (Blank line if numGood == 0)
* Line 3: A space-separated list of numBad "bad" nouns. (Blank line if numBad == 0)
* Line 4: An integer, numLines, indicating the number of lines in the chat transcript
* Next numLines lines: The chat transcript to be interpreted

# Output
* The output of the program

# Constraints
* Each line may contain multiple constants, but will only contain a single command.  
* The exception to this is if a context change occurs as the first word in a line. 
* In this instance, the context is changed immediately for that line (and all subsequent lines) and another command can be given on that same line.
