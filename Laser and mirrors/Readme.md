# Puzzle
**Laser and mirrors** https://www.codingame.com/ide/puzzle/laser-and-mirrors

# Goal
You find yourself in a corner of a gigantic dark room. You don't see anything at a distance, only the cold surface of both corner walls. On the floor you see something shining.  
It's a strange small gold cylinder.  
You pick it, observe it, and discover a small button on the side. You press it, and ghosh! You had a blight red light flashing into your eyes.  

After some times, when the surprise is past, you understand that this small cylinder is a laser. You try it in your room, and discovers by pointing to different angles (0°, 90°, 180° and 270°) that the laser beam goes back at you.   
It probably means that this room is a rectangle, and that all sides are covered by a reflecting surface.

But at some angles you do not get back your beam. Maybe the corners are not reflexive? Maybe there are other people on each corner, and the laser beam stops at them?

If you knew the size UxV of the rectangle, could you guess at which corner the laser beam stopped and the length of the beam?

Note: for simplicity, the angle is 45°. If the angle was different (except for 0° and 90°), it would be the same problem as with an angle of 45° and a different shape (but probably not integers). And you can also forget the square root of 2 from the length.  

Examples: (S is the starting corner, where you are)
```
U=V=2 => corner=B length=2
A██B
█ /█
█/ █
S██C
```
```
U=2 V=3 => corner=A length=6
 A███B
U█\/\█
 █/\/█
 S███C
   V
```
```
U=2 V=4 => corner=C length=4
 A████B
U█ /\ █
 █/  \█
 S████C
   V
```

# Input
* One line: Two integers U and V for the size of the rectangle.

# Output
* One line: The corner (A or B or C) at which the laser beam stopped, and the length (divided by √2) of the beam.

# Constraints
* 1 ≤ U, V ≤ 100 000
* length ≤ UxV
