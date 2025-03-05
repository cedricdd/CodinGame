# Puzzle
**The Crime Scene** https://www.codingame.com/training/expert/the-crime-scene

# Goal
Detective Sharelock Codes has to inspect a lot of crime scenes. He finds clues scattered around the crime scene, and the location of these clues is diligently recorded by Dr. Watchdog.

The good doctor sends the coordinates of all clue locations (Xi Yi) to the detective by email. Sharelock then calculates how many rolls of yellow police line L he must purchase in order to protect all of the clues.

Obviously, all clues must be enclosed in a single "ribboned" area, but in addition, all clues must be at least 3 feet from the police line at all points.

A roll of ribbon is 5 feet long and is quite expensive, so Sharelock wants to buy only as many rolls as needed. Help him by writing a program to calculate the minimal number of rolls required to surround the crime scene.

# Input
* Line 1: Number of clues N.
* Next N lines : clue coordinates Xi and Yi in feet.

# Output
* How many rolls of yellow police line L Sharelock needs in order to surround the crime scene.

# Constraints
* 1 ≤ N ≤ 100000
* -100000 ≤ Xi ≤ 100000
* -100000 ≤ Yi ≤ 100000
