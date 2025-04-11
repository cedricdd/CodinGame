# Puzzle
**Lucky number** https://www.codingame.com/contribute/view/121422369f3efb70e9ff95469e2308044e5687

# Goal
You are asked to write a program to determine if a given positive integer is lucky, normal, or unlucky following the steps below:

1. Remove all 0s and 5s from the number, e.g. 14536 => 1436.

2. Create consecutive 2-digit pairs from the number created in Step 1, sliding by one digit at a time, e.g. 1436 => 14;43;36.

3. For each pair, calculate the sum of its digits and classify it:  
  * If the sum is greater than 9, it is lucky (POSITIVE).
  * If the sum is exactly 9, it is normal (NEUTRAL).
  * If the sum is less than 9, it is unlucky (NEGATIVE).
  * e.g. 14;43;36 => NEGATIVE;NEGATIVE;NEUTRAL.

4. Make the final conclusion:
  * If there are more lucky pairs than unlucky ones, the number is LUCKY.
  * If there are more unlucky pairs than lucky ones, the number is UNLUCKY.
  * Otherwise, the number is NEUTRAL.

Special case: If no pairs can be formed with the number from Step 1, output -1 and terminate.

# Input
* Line 1: A string N that contains the number.

# Output
* Line 1: The pairs that have been formed, separated with semi-colons.
* Line 2: The status of the pairs, separated with semi-colons.
* Line 3: If N is lucky or not.
* Or just output -1 in the special case.
