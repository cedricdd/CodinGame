# Puzzle
**Hotel** https://www.codingame.com/training/medium/hotel

# Goal
You are at the reception desk of a 4-floor hotel and a group of c customers arrive and ask for a room.

But what should have been a routine task becomes a nightmare when you realise they have very specific demands !

Your job is to assign a floor (from 0 to 3) for each of them while respecting their r rules.

There are 10 types of rules:  
* customer_name is at floor y
* customer_name is NOT at floor y
* There's nobody at floor y
* There are exactly two customers at floor y
* customer_name is alone at his/her floor
* customer_name is with two other customers at his/her floor
* customer_name is just above customer_name
* customer_name is higher than customer_name
* customer_name is at the same floor as customer_name
* customer_name is NOT at the same floor as customer_name

There is a unique solution for each test.

This puzzle is inspired by the boardgame Gamme Logic - Hôtel

# Input
* Line 1: An integer c for the number of customers.
* Next c lines: A string customer_name
* Next line: An integer r for the number of rules.
* Next r lines: A string rule

# Output
* c lines in input order A string with customer_name floor separated by a space

# Constraints
* 3 <= c <= 6
* 3 <= r <= 8
