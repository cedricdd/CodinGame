# Puzzle
**Agent X, Mission 1 — The Caesar Cipher** https://www.codingame.com/training/easy/agent-x-mission-1-the-caesar-cipher

# Goal
[Crackling static]  
Agent X to Base, respond, over.  
[Base responds]  
Base here, we read you, Agent X, over.  
[Agent X]  
I've intercepted an enemy message, but it appears to be encoded with a Caesar cipher. I need to decrypt it quickly to foil their plans. The problem is, I don't know the key... Fortunately, I have a word that should appear in the decrypted message. I need your help to find the key and the original message, over.  
[Base]  
Understood, Agent X. Send us the data, and we'll decrypt the message, over.  

The Caesar cipher used by Agent X works by substituting each character in the original message by another character a fixed number of positions (called the key) down the ASCII code range of 32 to 126 on a wrap-around basis. key is non-negative in this puzzle.

For example, with a key of 3:
- a becomes d
- w becomes z
- x becomes {
- ! becomes $
- , becomes /
- SP (space character) becomes #
- A becomes D
- W becomes Z
- ~ becomes "

Words are always separated by SP, ,, ., ?, ;, : and !

# Input
* Line 1 ciphertext : The encrypted message to be decrypted.
* Line 2 word : A word that is guaranteed to appear in the decrypted message

# Output
* Line 1 key : The key of the Caesar cipher.
* Line 2 plaintext : The decrypted message.
  
# Constraints
* Length of word<25
