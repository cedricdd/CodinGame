# Puzzle 
**Agent X, Mission 3—The Bottle In The Sea** https://www.codingame.com/contribute/view/868058fdaa6cff707bbad53b205a2320dbdaf

# Goal
[Agent Y to Base]  
I've just arrived at the port, so there's no sign of Agent X yet.  
[Base]  
Look for information, he must have left us a trail.  
[Agent Y]  
I've just found a bottle floating. I'm going to check it out.  
[Base]  
OK, got it.  
[Agent Y]  
I've found a message left inside by Agent X. This time it's encrypted using the Vigenère method. Fortunately, he left us the size of the key to use. What's more, it seems to me that you know the words that Agent X uses all the time.  
[Base]  
Ok, send us the data we will decrypt this.  

The Vigenère cipher is a secure method of encrypting text through polyalphabetic substitution, using a keyword to shift letters in the message being encrypted.

1st - Select a Keyword: Choose a keyword, for instance, ABC.

2nd - Prepare the Message: Take your message, say CODINGAME.

3rd - Align Keyword: Repeat the keyword to match the message's length. For CODINGAME, you'd get ABCABCABC.

4th - Shift Letters: Shift each letter in your message based on the corresponding letter in the keyword. The shift amount comes from the letter's position in the alphabet (A=0, B=1, C=2, etc.). And Encrypt the Message: Apply the shifts to each letter with wrap-around when needed in CODINGAME, creating an encrypted message that's only decipherable with the keyword ABC. Here the encrypted message is CPFIOIANG.

When we repeat the keyword, we ignore any non-letter characters. For example, the pattern of the keyword ABC to apply to AGENT X is ABCAB C.

Note that the shifting is case insensitive but conserves case, also Non-letter characters are kept unchanged.

The Vigenère cipher's use of different shifts, based on the keyword, makes it harder to crack than simple substitution ciphers. Despite this, with enough text and some knowledge of the underlying language, it's still vulnerable to specific cryptanalysis techniques.

You'll have to decrypt the message left by Agent X. By knowing the key_length of the key and a word in the message

Words are always separated by Space character, ,, ., ?, ;, : and !

# Input
* Line 1 message : The encrypted message
* Line 2 key_length : The size of the key
* Line 3 word : A word that is guaranteed to be in the decrypted message, in upper case.

# Output
* Line 1 key : The key used for encrypting the message
* Line 2 decrypted_message : the all decrypted message or the first 900 characters if there are more than 900

# Constraints
* Word are longer than key.
* With the given input you can always deduce 1 and only 1 solution
