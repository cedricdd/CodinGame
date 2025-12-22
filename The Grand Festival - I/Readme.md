# Puzzle
**The Grand Festival - I** https://www.codingame.com/training/medium/the-grand-festival---i

*Story:*  
The Grand Festival has arrived at the Shire! Merry and Pippin decide to participate in its competitions.   
There are a variety of competitions, like archery, sword fighting, hunting, riding, etc.  
However, they realize that after playing some tournaments consecutively, they need to rest a day.   
They gather information about the prize money of each competition. 1 competition is held every day.  
Merry and Pippin decide they will try to get the maximum prize money. For this, they ask Gandalf for help.   
Help Gandalf choose which tournaments They should play.  

*The Problem:*  
Given the prize-money for each tournament, and the maximum consecutive days Merry and Pippin can play without break, output the maximum prize money they can win.

*Rules:*  
There are N tournaments in all, held from day 1 to day N.  
Merry and Pippin can play at most R consecutive tournaments before they have to rest.  
The prize money for all the tournaments will be given to you.  
You need to display the maximum total prize money.  

*Example:*  
Let there be 10 tournaments  
Let Merry and Pippin be able to play 4 days consecutive  
Let the prize moneys be 13, 2, 15, 17, 19, 33, 2, 2, 2, 2.  
So, Merry and Pippin will play on days 1 > 3 > 4 > 5 >6 > 8 > 9 > 10  
Thus, the maximum prize money will be 103  

# Input
* Line 1: An integer N
* Line 2: An integer R
* Next N Lines: Integers PRIZE, the prize money for the tournaments respectively

# Output
* Line 1: An integer MAX_MONEY, the maximum prize money possible
