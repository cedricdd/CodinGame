# Puzzle
**The Cash Register** https://www.codingame.com/training/medium/the-cash-register

# Goal
One of your friends came yesterday to ask for your help. He has opened a shop and wants to give change to his customers using the fewest coins possible. Unfortunately, he isn't very good at math and, knowing you are a computer engineer, he thought you could create a program to tell him which coins to give based on what is left in his cash register, if possible.

To simplify, let's assume there are enough coins of each denomination in the cash register.

You’ll output the coins to return if there is a solution, 0 if there is nothing to give back, and IMPOSSIBLE if there is no solution.

If there are several solutions, select the one with the highest denominations : for instance, if you have to choose bewteen 100 25 25 and 100 26 24, you will choose the second one...

# Input
* Line 1 : A string containing integers separated by spaces called register, representing the values of the coins available in the cash register
* Line 2: An integer goalAmount representing the total amount to give back.

# Output
* Line 1 : A list of integers separated by spaces, representing the list of the coins to give back, sorted in decreasing order (print 0 if there is nothing to give back or IMPOSSIBLE if you can't give back the required amount). If there are several solutions, choose the one containing the coins with the biggest denominations.

# Constraints
* There can't be more than 10 different denominations in the cash register
* Values of register are sorted in increasing order.
* 0 <= goalAmount <= 15,000
