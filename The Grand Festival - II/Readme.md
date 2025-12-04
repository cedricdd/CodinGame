# Puzzle
**The Grand Festival - II** https://www.codingame.com/training/medium/the-grand-festival---ii

Story:  
The Grand Festival has started! Merry and Pippin decide to participate in its competitions.   
There are a variety of competitions, like archery, swordifighting, hunting, riding, etc.  
However, they realize that after playing some tournaments consecutively, they need to rest a week.   
They gather information about the prize money of each competition. 1 competition is held every week.  
Merry and Pippin decide they will try to get the maximum prize money. For this, they ask Gandalf for help.   
Help Gandalf choose which tournaments They should play.  

Rules:  
There are N tournaments in all, held from week 1 to week N.  
Merry and Pippin can play at most R consecutive tournaments before they have to rest.  
The prize money for all the tournaments will be given to you.  
You need to display the tournaments they should play in order to get maximum prize money.  

Example:  
Let there be 10 tournaments  
Let Merry and Pippin be able to play 4 weeks consecutive  
Let the prize moneys be: 15, 32, 22, 29, 19, 39, 20, 30, 12, 47  
To get the maximum they must play in the following weeks:  
1>2>3>4>6>7>8>10  
Your program must display the above output  

# Input
* Line 1: An integer N
* Line 2: An integer R
* Next N Lines: An integer PRIZE, the prize for the tournament that week

# Output
* Line 1: The weeks in which Merry and Pippin should play, to get the maximum prize money, in the following format: "W1>W2>W3>...>Wk"
