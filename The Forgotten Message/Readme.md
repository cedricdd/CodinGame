# Puzzle
**The Forgotten Message** https://www.codingame.com/contribute/view/10333828c2c7b635bb472ac367bbda2ff2070e

# Goal
Mr. Howard's curiosity grew as he realized that the message on the old phone wasn't just a random string of digits—it was an exact text, encoded with the same technique used on early mobile phones. Each digit could represent a specific letter based on how many times it was pressed, and there was even a way to switch between uppercase and lowercase letters.

Your task is to help Mr. Howard decode this message and reveal the exact words his friend wanted to send.

*Problem:*  
Given a string of digits and special characters representing a sequence of key presses on an old mobile keypad, decode the message into its exact text. The message is encoded as follows:
* 2 -> "ABC" ie. ( 2 -> "a", 22 -> "b", 222 -> "c")
* 3 -> "DEF"
* 4 -> "GHI"
* 5 -> "JKL"
* 6 -> "MNO"
* 7 -> "PQRS"
* 8 -> "TUV"
* 9 -> "WXYZ"
* 0 -> " " (space)
* \# -> Used to switch between lowercase and uppercase letters. Each # toggles the case.

# Input
* A string sequence consisting of digits from 0-9 and the character #.

# Output
* A string containing the decoded message with exact text, respecting the case and spacing as encoded.

# Constraints
* 1 <= len(sequence) <= 100
* The input string will not contain the digit 1.
* Consecutive presses of the same digit are guaranteed to represent a valid character.
* Space in input is just a pause time to separate two identical characters.
