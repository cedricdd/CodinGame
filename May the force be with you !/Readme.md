# Puzzle
**May the force be with you!** https://www.codingame.com/contribute/view/56842cbfd6ef3dbbb8cae1e5c61bbf6d235e1

# Goal
You are a new student in college and receive your credentials to access the digital learning environment on your first half-day of school.   
The administration hands you a letter containing the following information:  

"Dear Mr. Doe,
Welcome to our institution.

To access the digital resources you will need this year, as well as to use your email address, please take note of your credentials.

Login: john.doe@codingame.fr  
Password: Roh86*  

Sincerely,
The Administration"

After taking note of your credentials, you discreetly observe the passwords of your neighbors to the right and left:
* Password of the neighbor on the right: Kim22*
* Password of the neighbor on the left: Lel18*

You notice a similarity between these passwords and identify a common pattern:  
uppercase consonant - lowercase vowel - lowercase consonant - digit - digit - *

You wonder if it would be easy to access all your classmates' accounts. Skillfully, you manage to obtain the entire institution's database.   
In the 'user' table, you find your credentials. However, the stored password differs from the one you were given.   
In fact, the "password" field associated with your user account contains: b5e202e7e93b99c8007789650c295d62  

Darn! The password is hashed. So you cannot directly use the information in the database to access other user accounts.

After a quick analysis, you find that the institution uses the MD5 hash function.

With some free time at your disposal, you decide to create an algorithm to find the password corresponding to a given hash.

It is possible that the user has already changed their password and no longer follows the pattern provided by the administration.  
You will need to identify the hashes that correspond to modified passwords and return the string PASSWORD_CHANGED.

*Rules:*  
The password pattern provided by the administration is as follows: uppercase consonant - lowercase vowel - lowercase consonant - digit - digit - *.  
The password is stored in the database as an MD5 hash.  

*Note:*  
This exercise is a fiction and should not be applied to a real situation. Hacking is illegal.

# Input
* Line1 : A string representing the result of the MD5 hash function on a password

# Output
* Line1 : A string representing the decrypted hash or the string PASSWORD_CHANGED if the user has already changed their password.

# Constraints
* The input string is 32 characters, it always consists of numbers and lowercase letters only.
