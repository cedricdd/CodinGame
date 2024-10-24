# Puzzle
**Army Ants** https://www.codingame.com/training/medium/army-ants

# Goal
It is a well known fact that ants always move in a straight line.  
However, not many people know what happens when two groups of ants meet face to face in a passage which is too narrow for any two ants to evade laterally each other.  
One theory suggests that they start jumping over each other.  

From the moment the groups meet, every second, ants which are facing an ant moving in opposite direction jump (or gets jumped over, depending on the deal they made) over it.  

For example, given two groups, say ABC and DEF.  
When they meet it's like this: CBADEF  
Since they can't bypass each other, they start jumping:  
After 1 second, it becomes CBDAEF  
After 2 seconds, it becomes CDBEAF  
After 3 seconds, it becomes DCEBFA  
After 4 seconds, it becomes DECFBA  
And finally, it becomes DEFCBA  

From this point on, groups have jumped over each other and any seconds after this, the state remains the same.

Your job is to determine the order of ants in the passage after T seconds.

# Input
* Line 1: Two integers N1 and N2, lengths of two groups.
* Line 2: String S1, first group of ants.
* Line 3: String S2, second group of ants.
* line 4: An integer T, the number of seconds passed.

# Output
* Single line: Containing the state of groups after T seconds

# Constraints
* 0 < N1, N2 < 50
* 0 ≤ T < 50
