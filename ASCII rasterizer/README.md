# Puzzle
**ASCII rasterizer** https://www.codingame.com/contribute/view/50802d17713d39b082bc6b196375d95dfc084

# Goal
Ever wondered how computer graphics actually work and how stuff are actually painted on your screen? In this puzzle, your goal is to implement a very basic 2D ASCII rasterizer i.e., 
to convert the description of objects into an actual ASCII image!

Rasterization is an algorithm/technique that is used in the real world, for real computer graphics. So, in our scenario and for the sake of simplicity, we will make the following assumptions:
1. Our screen is the terminal and our "pixels" are characters. The screen has fixed width and height.
2. The origin of the coordinates is the bottom-left corner of the screen. The x coordinate gets larger as we go to the right, y as we go up and z as we go "deeper" (straight into the screen).
3. We will only render totally opaque sphere objects. Each one will be described by the 3 coordinates of its center, its radius, and its texture (5 elements: 4 numbers and 1 character). 
The texture will be a single ASCII character (e.g. o) which is what we need to render at a "pixel" where this object is visible. Think of it as the color of the sphere.
4. Our rasterizer will be orthographic. This means that there is no perspective - everything is rendered where it is. For example, if a sphere is centered at x = 10 and another sphere at x = 20, 
their centers will be 10 units away on the x-axis, regardless of where they stand on the z-axis.
5. In order to spice things up, we will use the z coordinate of the spheres to introduce a notion of depth in our orthographic 2D scene.

Inspired by the parallaxing technique, we will use a number between 0 and 1 called factor.  
This factor will describe how much the length of the radius of a sphere is reduced in respect to its distance from the camera plane (i.e., its z coordinate).  
Let us call the effective radius of a sphere r' (effective meaning that this will be its length in "pixels" when we render it on screen).  
Then r' is given by the following formula (the parenthesis is raised to the power of z): 
```
                     z
r' = r * (1 - factor)
```

So, small values of factor mean that the radius isn't reduced very much, while larger values mean that the radius is getting smaller quicker while the z coordinate gets larger.  
Using this trick, we can control the effective size of a sphere not only by its radius, but by its distance from the camera as well, making our rasterizer a little bit fancier!

Notes
1. In case 2 spheres have the exact same z coordinate for a given pixel, the one that appeared first in the input list is prioritized.
2. Empty "pixels" are filled with space ( ) characters.
3. You must draw spaces to reach the end of the width of the screen for every line.
   
Leaving a line empty because it has no objects or leaving the "tail" of an output line without the appropriate number of spaces will result in failure.

# Input
* Line 1: Two integers N and M: the width and height of the screen, respectively.
* Line 2: A float factor: the parallaxing factor.
* Line 3: An integer K: the number of spheres to render.
* Next K lines: Four floating point numbers, x, y, z and r, and an ASCII character texture, separated by spaces. The numbers are the coordinates of the center of the sphere x, y, z and its radius r. 

The ASCII character texture is the "texture" of the sphere.

# Output
* An ASCII image of size M * N as described in the statement above (i.e., M lines of exactly N ASCII characters each).

# Constraints
* 10 ≤ N, M ≤ 50
* N * M < 1000
* 0 < factor < 1
* 1 ≤ K ≤ 100
* x, y, z ≥ 0
* r > 0
* Texture will always be a single ASCII character.
* No sphere will ever intersect the camera plane (z = 0).
