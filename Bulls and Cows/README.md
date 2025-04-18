# Puzzle

**Bulls and Cows** https://www.codingame.com/training/medium/bulls-and-cows/solution

# Goal
In the classic code-breaking game of Bulls and Cows, your opponent chooses a 4-digit secret number, and you need to guess it.   
After each guess, your opponent tells you how many "bulls" and how many "cows" are in your guess, interpreted as:  
- Each bull indicates a digit in your guess that exactly matches the value and position of a digit in your opponent's secret number.
- Each cow indicates a digit in your guess that matches the value of a digit in your opponent's secret number, but is in the wrong position.

So for example, if the secret number is 1234 and you guess 5678, your guess has 0 bulls and 0 cows.   
However, if you guess 2324 then your guess has 1 bull (the 4) and 2 cows (one of the 2s, and the 3.)

You will be given a series of guesses along with the number of bulls and cows in each guess.   
Your job is to determine the secret number based on the given information.

NOTE: This version of the game deviates from the classic Bulls and Cows rules in that digits may be repeated any number of times in the secret number.

# Input
* Line 1: The number N of guesses.
* Next N lines: A guess, consisting of 4 digits [0-9], followed by a space, then the number of bulls, another space, and then the number of cows.

# Output
* The 4-digit secret number.

# Constraints
* 1 ≤ N ≤ 20
