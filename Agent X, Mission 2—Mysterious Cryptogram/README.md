# Puzzle
**Agent X, Mission 2—Mysterious Cryptogram** https://www.codingame.com/training/medium/agent-x-mission-2mysterious-cryptogram

# Goal
[Base]  
Agent X, the enemy knows where you are.  
*** crackling ***  
[Base]  
Are you here ?  
*** sizzle ***  
[Base to Agent Y]  
Agent Y, I think the enemy has captured Agent X can you go and see.  
[Agent Y]  
Yes, right away.  
(Some time later)  
[Agent Y]  
I'm at his hideout but there's nothing left, I think he's just tried to leave us a coded message.  
[Base]  
Send us the messages left by agent X.  
[Agent Y]  
He gave us messages encrypted by substitution. To help us, he's only using words from the register.  
[Base]  
Roger, we'll take care of decrypting the messages left by agent X.  

The substitution code works by replacing each character in a language with another or a symbol, without any particular logic. The substitution table is the set of associations defined between the original characters and their substituted characters (The substitution table can be seen as a permutation of letters). Unlike the Caesar cipher (see Agent X, Mission 1 — The Caesar Cipher), which would use an offset to build its substitution table, there is no particular logic here.

Your objective is to use a register of N words and a message (ciphertext), encrypted with a substitution table that you don't know, to find the decrypted message (plaintext) and part of the substitution table.

Not every word in the register is in the message, but all words in the message are in the register.

The substituted characters are only letters, all non-letter characters are kept unchanged. Also the letter substitution is case-insensitive, but the case is kept, i.e. if a is substituted by e, then A would be substituted by E.

Words are always separated by Space character, ,, ., ?, ;, : and !

# Input
* Line 1 ciphertext : The encrypted message that needs to be decrypted.
* Line 2 N : The number of words in the word register.
* Next N Lines word : A word of the register used by Agent X to write the message. word is in upper case only and may contain '

# Output
* Line 1 plaintext : The decrypted message.
* Next 26 Lines char_substitution : The substitution for each character in upper case, in the format of original_letter -> substitute_letter (e.g. A -> E), or Na if there is no information on the substitution of the character.

# Constraints
* With the given input you can always deduce 1 and only 1 solution
