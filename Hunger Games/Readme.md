# Puzzle
**Hunger Games** https://www.codingame.com/training/easy/hunger-games

# Goal
You are a programmer for The Capitol of Panem in the Hunger Games.  
You are assigned with the task of displaying information on boards for each of the tributes.   
You are given information regarding the entire match and its results, your job is to display who killed who.  

If a tribute kills more than one person in a single turn, then it will be formatted like so.

TributeName killed VictimName1, VictimName2, VictimName3...

It is also possible that the same killer appears in multiple lines. Eg:
```
John killed Steve
John killed Marcus
```

Example (Tribute's name is John, they killed Sebastian and Denny, and Marcus won) :
```
Name: John
Killed: Denny, Sebastian
Killer: Marcus
```
```
Name: Marcus
Killed: John
Killer: Winner
```
```
Name: Sebastian
Killed: None
Killer: John
```

All information is expected to be in alphabetical order.

# Input
* Line 1: A number N for the amount of tributes.
* Next N lines: Each tribute's name.
* Next Line: A number T for the amount of turns in the game
* Next T lines: Information of who killed who. Player killed Victim

# Output
* Print each tribute's name, who they killed (if anyone), and who killed them.
* Separate each Tribute's information with a blank line
* If the player was not killed (is the winner), then print "Winner" in place for the killer.
* If the player did not kill anyone, then print "None" in place for who they've killed.

# Constraints
* 1 < N
* Tribute Names will always be unique, and will only contain alphabetical characters. (No accent marks or special characters).
* There will only be one tribute left alive.
