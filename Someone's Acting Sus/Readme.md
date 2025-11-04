# Puzzle
**Someone's Acting Sus** https://www.codingame.com/training/easy/someones-acting-sus----

# Goal
You are a professional Among Us gamer, however, you don't know who the impostor is!   
Luckily, you're hacking, so you know the exact path each crewmate took before the EMERGENCY MEETING.   
You notice that certain crewmates are acting SUSSY - they are moving much faster than they should!   
You know that there are vents connecting all of the rooms, so there is only 1 possible explanation.   
Your task is to figure out who is SUS, and vote them out immediately!  

The rooms are labelled arranged in cyclic fashion. For example, for a room layout ABCDEF, a crewmate in room D can go to either room C or E, and a crewmate in room A can move to either room B or room F. Changing rooms takes 1 minute.

For each crewmate, you will receive a string of length K.   
This string is ordered so that the first character represents the position of the crewmate at the first minute, and so on.  
Sometimes, the hacks you're using may freeze (because of the bloatware you installed with it), so you will be missing some data.   
In this case, the character you will be given will be #.  

For example (examples with room layout ABCDEF:  
For input ABAFEDEF, the path the crewmate took is <<A->B->A->F->E->D->E->F>>. This is not sus, since the crewmate never travels more than 1 room per minute.  
For input AFEBAFE, the path the crewmate took is <<A->F->E->B->A->F->E>>. This is sus because a normal crewmate cannot travel from room E to room B in 1 minute.  
For input B#DCB#F, the path the crewmate took is <<B->?->D->C->B->?->F>>. This is not sus because the crewmate can travel from B to D in 2 minutes, and B to F in 2 minutes.  

# Input
* An integer, L.
* A line F of length L, corresponding to the room layout. All characters in F will be uppercase and unique.
* 2 space separated integers, N and K, representing the number of crewmates and the length of time the crewmates were recorded (length of each string).
* This is followed by N strings, comprised of capital letters, or number signs (#), each of length K. 
* It is guaranteed that the letters will be present in line F.

# Output
* N lines corresponding to each of the N crewmates. Output "SUS" if the crewmate is suspicious, otherwise print "NOT SUS".

# Constraints
* 6 <= L <= 26
* 5 <= N <= 40
* 2 <= K <= 50
