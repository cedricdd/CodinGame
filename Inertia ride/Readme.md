# Puzzle
**Inertia ride** https://www.codingame.com/training/hard/inertia-ride

# Goal
You're riding a roller coaster track, starting on the left and stopping on the right… or somewhere in the middle, if you run out of inertia !

A roller coaster is composed of several tracks in an ASCII form : horizontal tracks (underscores _), descending slopes (backslashes \), and ascending slopes (slashes /). Every part that is not a track is represented by a dot .  
In this puzzle, every roller coaster is well formed :  
- It starts and ends with a horizontal track.
- It is not broken, i.e. every ascii column has one and only one track, and tracks are correctly aligned.
- It has no V-sink \/ : a descending track cannot be followed by an ascending one.

Your goal is to tell in which position your wagon will stop (counted from 0 for the leftmost track element), given the following rules:  
* Your wagon starts on the first track with a given starting inertia.
* At the beginning of each turn, your inertia will change depending on the track your wagon is on:
  - A horizontal track _ decreases your inertia by 1.
  - A descending track \ increases your inertia by 9.
  - An ascending track / decreases your inertia by 10.
* If your inertia goes negative, your wagon changes direction (switching back your inertia to its absolute value and reversing ascending and descending tracks).
* After the inertia update, your wagon will move to the next track in its current direction. Null inertia implies staying in place.
* If your wagon reaches the last track or comes back to the first one, it stops there immediately.
* A wagon on a horizontal track with an inertia of 0 will stop.

Keep in mind that if your wagon's inertia reaches 0 on a slope, it is not finally stopped.

Example 0:  
Your wagon enters a fully-horizontal track on position 0 with an inertia of 2. Its inertia decreases to 1, which is positive, so it moves right.   
Its inertia decreases to 0, so it doesn't move. Since it's stopped on flat tracks, it won't move again, so its final position is 1.  

Example 1:  
Your wagon is on an ascending track / with an inertia of 11. The inertia is decreased to 1 and then your wagon move to the next track, which is a horizontal track _. Your inertia then falls down to 0 and your wagon stops.

Example 2:  
Your wagon is on an ascending track / with an inertia of 8.  
The inertia is decreased to -2 so your wagon changes direction and move to the previous track with an inertia of 2.

Example 3:  
Your wagon is on an ascending track / with an inertia of 10. The inertia is decreased to 0 so your wagon doesn't move.  
It is not stopped however, since in the next turn, the inertia will be decreased again to -10.   
Your wagon will then change direction and move to the previous track with an inertia of 10.  

# Input
* inertia : the starting inertia of your wagon
* W H : the width and height of the roller coaster
* Next H lines : the ASCII roller coaster

# Output
* An integer i giving the 0-based track position where your wagon will stop.

# Constraints
* 0 < inertia < 100
* 0 < W, H < 100
