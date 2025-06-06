# Puzzle
**Murder in the village** https://www.codingame.com/training/easy/murder-in-the-village

# Goal
There has been a murder in the village!  
As the local detective, it’s up to you to find out who was the killer.  
You’ve asked everyone where they were at the time of the crime, and who they were with.  
 
All innocent people (aka "villagers") will tell you the truth, only the killer will lie.  
If everybody is telling the truth, then that must mean that you were the killer!  
Can you determine who the killer was?  

*Some clues:*  
- The killer can claim to have been anywhere, with anyone.
- The villagers (non-killers) haven’t seen the killer.
- The villagers (non-killers) were not in the same location as the killer.
- If someone claims to have been alone, that also gives you information.
- If everyone has a good alibi, you were the killer.
- If the killer claims to be alone, the claim can be proven to be false.


Example case #1:  
Input:
```
3  
Paul: I was in the school with Benjamin.  
Benjamin: I was in the workshop with Raul.  
Raul: I was in the workshop with Benjamin.  
```

Solution:
```
Paul did it!
```

Explanation:  
Benjamin and Raul gave each other alibi’s,  
So it must have been Paul who is lying.  

Example case #2:  
Input:
```
2
Patty: I was in the church with Bill.
Bill: I was in the church, alone.
```

Solution:
```
Patty did it!
```

Explanation:  
If neither were the killer, they would both say there were in the church together.  
If Patty was the killer, Bill would be truthful that he was alone in the church.  
If Bill was the killer, Patty would be lying that Bill was in the church, but villagers don't lie.  
So the only valid option is that Patty must have been the killer.  

# Input
* Line 1: An integer N for the number of suspects in the village.
* Next N lines:
* Name: I was in the Location with Name0 and Name1 ... and NameY.  
OR
* Name: I was in the Location, alone.

# Output
* Line 1: Name did it!  
OR
* Line 1: It was me!

# Constraints
* 2 ≤ N ≤ 10
* There are no ambiguous cases, there is only one solution to each test case.
