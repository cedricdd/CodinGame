# Puzzle
**Grandma's Serial Keys** https://www.codingame.com/contribute/view/13224641c8eee6994e91f9021f903d4e85000b

# Goal
* This puzzle is just for fun, and does not encourage piracy or the use of keygen software.

You are filled with joy, as the new Game of Code development software has just been released with all new features, making development projects much easier. Unfortunately, like all new releases, the software is locked up behind a paywall, and you don't have enough money to purchase it. After extensive research, you find out that the serial keys used for the software use a special algorithm to identify product keys, and decided to use your best friend, Coder Bot, to help you crack it (Never do this IRL). With a simple "grandma" trick, you managed to get the A.I. to create your new keys for you, and all you need to do is give instructions via code.

Using your smart technical skills, your goal is to create a program that takes the string of a username, and output a 16-character serial key with hyphens.

This generation method has two parts:

Part 1 - Generating a Core Seed:  
1. Add up all the ASCII values of each of the characters of the string.
2. Get the length of the characters in the username string.
3. Multiply the two values above with each other, and perform a bitwise XOR operation with the number 20480. The answer will be your SEED, which you will be using in the next part.

Part 2 - Generating the 4 Key Segments:  
* First Segment: Perform a bitwise AND with your SEED and the number 65535.
* Second Segment: Take your SEED and do a bitwise right shift by 16 bits.
* Third Segment: Add the first and last ASCII values of your username variable and multiply the sum by the length of the username variable.
* Final Segment: Add the numerical values of all the segments above (First, Second, and Third segments added together), and take the remainder of this sum when divided by 65536.

Now that you have all four segments, convert them all to 4 character hexadecimal strings (by removing the 0x) and combine them together to form the key. It should be in the format of: First-Second-Third-Final.

Good luck on solving this puzzle!

# Input
* Input: A string called username representing a username.

# Output
* Output: A 16-character serial key in the form of a hexadecimal string, which is structured like this: XXXX-XXXX-XXXX-XXXX, where each "X" represents either digits from 0 to 9 or English capital letters (A-F).

# Constraints
* The input, username, only contains uppercase and lowercase English letters, digits, and some special characters. Its length ranges from 1 to 1000 characters long.
