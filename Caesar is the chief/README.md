# Puzzle
**Caesar is the chief** https://www.codingame.com/training/easy/caesar-is-the-chief

# Goal
During the galactic war against the Zorglons, the Earth Intelligence Agency intercepted a lot of messages.

It is your task to decode them.

You know that :  
1/ The messages are always in capital letter. Words are separated with white spaces. You don't have to decode these spaces.  
2/ They are coded with a caesar cypher.  
3/ The Zorglons always include the word "CHIEF" in them to be sure there are true messages. Be careful, this must be a separated word: a message such as "HANDKERCHIEF" is not a true message.

Note that the caesar cipher is a shift in the alphabet : for example, with a right shift of 3, A becomes D, B becomes E ... and Z becomes C.

Given a message, you must decode it (i.e. find the correct shift and output the text containing the word "CHIEF") or output "WRONG MESSAGE" if it is not a true message.

# Input
* Ligne 1 One string to decode

# Output
* Ligne 1 One decoded string or "WRONG MESSAGE"
