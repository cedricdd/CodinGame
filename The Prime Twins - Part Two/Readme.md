# Puzzle
**The Prime Twins - Part Two** https://www.codingame.com/training/medium/the-prime-twins---part-two

# Goal
Part one : https://www.codingame.com/training/easy/the-prime-twins---part-one

*Context:*  
五 and 七, two brilliant young students in middle school, have just finished creating their own secret language during the holidays. Proud of their creation, they speak confidently, convinced that no one will ever be able to decipher their messages.

*Encryption principles:*  
* i denotes the integer between a pair of prime twins. For example, between 5 and 7, i = 6.
* key represents the secret key agreed upon by 五 and 七.

*Transformation rules:*  
A is transformed into key + key. For subsequent letters like B and beyond, key is added to the integer located between the closest pair of prime twins that is strictly greater than the previous value. For example, if the previous value was i, the search for the next pair of twins starts from i + 1.

*Example:*  
If key = 3, A = 3 + 3 = 6. For B, the search for prime twins starts strictly above 6, and the closest twins will be 11 and 13, so i = 12 and B = 3 + 12 = 15. For C, starting strictly above 15, the next twins will be 17 and 19, so i = 18 and C = 3 + 18 = 21.

*Input format:*  
For an ENCODE operation, message contains only upper case letters and spaces.  
For a DECODE operation, message contains only upper case hexadecimal values and the upper case letter G.  

*Output format:*  
The resulting integers are then converted to hexadecimal in upper case, separated by G or GG for space. For example, ABC is transformed into 6, 15, 21, which is then converted to 6GFG15.

*Error case:*  
If message does not comply with its respective input format, you must return ERROR !!.

*Goal:*  
Develop code to decode or encode the secret language of 五 and 七.

# Input
* Line 1: string operation ENCODE/DECODE
* Line 2: integer key Secret key agreed upon by 五 and 七
* Line 3: string message

# Output
* encoded or decoded upper case letter message / "ERROR !!"

# Constraints
* 2 <= key <= 5*10⁶
* message contains only upper case letters and spaces
