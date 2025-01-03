# Puzzle
**Interstellar** https://www.codingame.com/training/easy/interstellar

# Goal
Picture yourself as an intrepid intergalactic navigator, entrusted with the task of charting a course through a mesmerizing cosmic wormhole.  
Your advanced ship is equipped with cutting-edge sensors capable of detecting vectors representing the elusive location of this celestial phenomenon.  
You'll be provided with two vectors, denoted as ship and wormhole, the magnitude of each component (i,j,k) being integers.  

To guarantee a secure passage through this ethereal expanse, you must develop a program that can precisely calculate the direction and distances between your ship and the wormhole.   
However, there's a twist! The sensors have encountered an unexpected glitch, introducing superfluous white spaces between coordinates.   
Furthermore, they may not adhere to the conventional i, j, and k sequence. For instance, you might receive a vector like "2i-3k+4j", where the default i, j and k sequence is violated.  

Additionally, if no number is explicitly mentioned before a component, consider it to be 1. For instance, "k+i-j" equates to "1k+1i-1j".   
And if a component is entirely absent, its value is assumed to be 0, like "i-k", which is equivalent to "1i+0j-1k".  

Hint:  
1) The vector ai+bj+ck denotes the coordinates (a,b,c) in space
2) Distance between two points (say (a1,b1,c1) and (a2,b2,c2)) is calculated by √((a2 – a1)² + (b2 – b1)² + (c2-c1)²)
3) Directional vector of one vector(a1i+b1j+c1k) with respect to another vector(a2i+b2j+c2k) is given by (a1-a2)i+(b1-b2)j+(c1-c2)k
4) The sign before the first component of directional vector is omitted if it is positive. That is, +2i+3j-4k should be written as 2i+3j-4k, whereas -9i+8j+4k remains the same.
5) Return the directional vectors in their simplified form by dividing each component by the HCF of the components. That is, 2i-4j should be converted to i-2j

Prepare for a cosmic challenge, Captain! It's time to navigate through the wormhole with finesse and precision.

# Input
* Line 1: A string ship representing the location of the ship in space.
* Line 2: Distance between the ship and the wormhole rounded off to two decimal places.

# Output
* Line 1: The directional vector to the wormhole from the ship
* Line 2: Distance between the ship and the wormhole

# Constraints
* 1 ≤ length(ship) ≤ 20
* 1 ≤ length(wormhole) ≤ 20
