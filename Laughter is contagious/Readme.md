# Puzzle
**Laughter is contagious** https://www.codingame.com/contribute/view/631447076a57c28eae909a735c20c25ed363a

# Goal
In a theatre, some people are laughing. Because laughter is contagious, their neighbours might start laughing too. You are given a string representing the row, your goal is to output the row, after laughter spreading.  
Each pair of letters represents a person: if both letters are uppercase, the person is laughing out loud. If only the first one is uppercase, the person might start laughing, and if both are lowercase, the person is sullen and unlikely to laugh.  
A person laughing out loud will remain so.  

Step 1: For every person, if anyone laughing out loud in the row has the same laugh (i.e. same pair of letters, case insensitive), they'll start laughing out loud.  
Step 2: Then, simultaneously, everybody else (if they're not laughing or sullen) will start laughing as the closest laughing person, if there are any within 3 seats and their neighbours are not both sullen (if they have two).  

Detailed example:  
```HA no Ye Ss no HO Ma Yy Be Us no tl ol HA or Me no ha Hi``` (spaces were added to help understanding)

Step 1: Ha will start laughing, because "HA people" are in the row, even if he is sullen.  
```HA no Ye Ss no HO Ma Yy Be Us no tl ol HA or Me no HA Hi```

Step 2:  
Ye will start laughing as HA (closest laughing person, distance 2 seats).  
Ss will start laughing as HO (closest laughing person, distance 2 seats).  
Ma, Yy and Be will start laughing as HO (closest laughing person, respectively distance 1, 2 and 3 seats).  
Us will not laugh, since nobody is laughing within 3 seats.  
Me will not laugh, because both of his neighbours are sullen.  
Hi will start laughing as HA (closest laughing person, distance 1 seat).  
Nobody else will start laughing, because they're sullen.  

The output would be:  
```HA no HA HO no HO HO HO HO Us no tl ol HA or Me no HA HA``` (spaces were added to help understanding).

If a person starts laughing and is exactly at the same distance from two people laughing out loud, like ```Ef``` in the following example, he will take one letter from each of them ("closest letter" from each of them).

```AB Cd Ef gh IJ``` will become ```AB AB BI gh IJ```

# Input
* 1 Line : a string row describing a row of seats (1 seat = 2 letters)

# Output
* 1 Line : a string describing the row after the laughter contagion.

# Constraints
* 2 ≤ length of row ≤ 100
* length of row is even.
* Each pair of letters follows one of the following case patterns: AB, Ab, ab.
