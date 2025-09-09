# Puzzle
**The flight of birds** https://www.codingame.com/training/hard/the-flight-of-birds

# Goal
This puzzle is inspired by the Fall Challenge 2023 and the banner was generated with Microsoft Bing AI.

You're a wealthy ornithologist with sumptuous aviaries containing many birds, and you're in the process of carrying out a very serious study into how they interact in captivity and a calm environment.

To carry out your study, every day, with your notebook in hand, you start by going to your aviaries and recording the position of each bird.

Early in the morning, you leave your house to join them, when suddenly... BAM! a huge rifle shot rang out. You quickly check to see if any of your birds have been hit, and are relieved to discover that they haven't. However, they are completely panicked and you are unable to carry out your study. Fortunately, your intruder surveillance system was automatically triggered some time after the gunshot and began filming the scene. With the help of a deep learning AI, you were able to determine the precise position and speed of each bird at the moment the system started filming. Now you need to determine the position of each bird at the moment of the shot to complete your study.

To do this, you assume:
- The size of the aviary is defined by a height (h) and a width (w) whose origin is located at [0,0]. The height positions are therefore between 0 and h inclusive and the width positions are between 0 and w inclusive.
- The x and y position of all birds could be determined a time t after the shot, thanks to the surveillance system.
- Between the shot and the start of the surveillance system, each bird moved in a straight line at a constant instantaneous speed corresponding to that deduced from the monitoring system (vx, vy).
- Each time a bird approached the edge of the aviary or another bird at a specific distance from d, it changed direction while maintaining its speed and respecting the law of reflection.

"Law of reflection"
- The reflected vector is in the same plane as the incident vector.
- The angle of reflection is equal to the angle of incidence.

Link: https://en.wikipedia.org/wiki/Reflection_(physics)#Laws_of_reflection

# Input
* Line 1: 2 integers: h w space-separated where h is the height of the aviary and w its width.
* Line 2: 1 float t indicating the time elapsed in arbitrary units between the shot and the bird data readout.
* Line 3: 1 float d which represents the distance between the bird and an edge of the aviary or another bird at which it will change direction.
* Line 4: 1 integer n which represents the number of birds in the aviary.
* Next n lines: (5 space-separated integer or float)
  * id: the id of the bird.
  * x and y: the position of the bird at time t.
  * vx and vy: the speed of the bird at time t.

# Output
* If no movement is possible, print No movement possible!.
* Else n lines: bird id and position in format id [x,y] at the moment of the shot sorted by id where x and y are rounded to the unit.

# Constraints
* 9 ≤ w ≤ 100
* 9 ≤ h ≤ 100
* 1 ≤ t ≤ 14500
* 1 ≤ d ≤ 5
* 2 ≤ n ≤ 80
* d ≤ x ≤ w - d
* d ≤ y ≤ h - d
* -5 ≤ vx ≤ 5
* -5 ≤ vy ≤ 5
