# Puzzle
**Tricky Number Verifier** https://www.codingame.com/training/easy/tricky-number-verifier

# Goal
Social insurance numbers in Austria (Europe) are 10 digits long: LLLxDDMMYY

- The rightmost 6 digits represent the person's birthday DDMMYY.
- The leftmost 3 digits LLL represent a unique identifier starting with 100. Therefore the very first digit is never 0.
- The fourth digit is a check digit x which is computed from LLL and DDMMYY by a specific algorithm.

A string supposed to contain a social insurance number could be invalid for four reasons:

1. The check digit x is incorrect.
2. The length of the string is inappropriate.
3. The string contains invalid or misplaced characters.
4. The birthday DDMMYYYY is an invalid date. Consider that dates like the 31st of April or the 29th February 2002 do not exist. 
It is assumed that YY = 00 represents 2000 rather than 1900. This might be important since 1900 was no leap year while 2000 was one. ;-)

For a valid identifier and a valid birthdate, the check digit x is computed according the following algorithm:

1. Multiply each digit of the identifier and the birthday with an individual factor.  
    * LLL: The 1st digit is multiplied by 3, the 2nd digit by 7 and the 3rd digit by 9.
    * DDMMYY: Multiply the 1st digit by 5, the 2nd by 8, ... and so on by 4, 2, 1, and 6.

2. Sum up all the results of step 1.

3. Now the check digit x is the remainder obtained by dividing the sum by 11. If the result is 10, the identifier LLL is dismissed. 
    * The rejected LLL is increased by 1 and the social number is recalculated by starting at step 1.

Your task is to read strings from the input and to check each social insurance number's validity, to correct it or to write a specific error to the output.

# Input
* Line 1: An integer N for the number of social insurance numbers.
* Next N lines: One line for each social insurance number to be verified.

# Output
* N lines: For each string, write one of the four outputs:
  1. OK: If the input string is a valid social insurance number.
  2. The corrected social insurance number if the input string was not a valid social insurance number.
  3. INVALID SYNTAX: If the input string has an incorrect length or contains an invalid character.
  4. INVALID DATE: The input string contains an invalid birth date.

Note: The test cases do not address the issue of an identifier overflow at 999.

# Constraints
* 0 ≤ N ≤ 1000
