# Puzzle
**Chain Reaction** https://www.codingame.com/training/medium/chain-reaction

# Goal
You're in a maze.  
Again...  
But finding the exit is not the issue. It's just there, in front of you, behind this handleless door.  
On the door, there are r rows of b buttons.  

You quickly realise that you can rotate the buttons and that by doing so you might trigger a chain reaction among the others.  

You have to find which of the buttons will trigger the biggest chain reaction on the door in order to open it, and finally get out of this damn maze.  

A button is shaped like this:
```
|
+--
```

If you trigger it, it rotates 90° clockwise:
```
+--
|
```

If after its rotation one of its legs connects with a leg of another button, the latter is automatically triggered.

For example:
```
|
+--

|
--+
```

If you trigger the top button, you end up with:
```
+--
|
|
--+
```

The bottom leg of the top button connects with the top leg of the bottom button, which triggers the bottom button.
```
+--
|

--+
|
```

The triggered button will then possibly trigger up to 2 other buttons (one per leg) and so on.

Note that the direction of rotation changes at each step, alternating clockwise and anticlockwise.  
A clockwise rotation triggers an anticlockwise rotation and vice versa. Also, when several buttons are triggered, they rotate simultaneously.

# Input
* Line 1: An integer r for the number of rows
* Line 2: An integer b for the number of buttons per row
* Next r x 3 lines: A string for the b buttons of the row

Note: A row of buttons is made of 3 lines of b x 5 characters, empty spaces included.

# Output
* Line 1: Two space separated integers: the index of the row and index of the button that triggered the chain reaction.
* Line 2: An integer for the number of rotations triggered, including the first one.

# Constraints
* 1 <= r <= 25
* 3 <= b <= 25
