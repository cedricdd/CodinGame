# Puzzle
**Hooch Clash** https://www.codingame.com/training/easy/hooch-clash

# Goal
Wizarding is a full-time job when you're an elf. Collecting ingredients, refining spells, mixing potions, uncursing travellers…

At the end of a busy day's work, elven wizards like to gather together at the magic tavern and play hooch clash. A clash works as follows:  
* the current king of the hill picks two glowing orbs and places them side by side on the table
* the challenger picks two sparkling orbs and places them opposite
* the bartender empties the hooch from each contender's orbs into a cauldron

If the glowing and sparkling liquids are provided in the exact same volume, the clash is valid and the winner is determined by fair coin toss.  
A valid clash is deemed fun if the four orbs on the table have a different size.  
A fun clash is as interesting as the challenger's two orbs are heterogeneous (different-sized), as measured by their outside, sparkling, surface area.  

This tavern only has orbs of integral diameter from orbSizeMin to orbSizeMax. As many of each as you want, it's magic!  

Can you help the challenger make a valid clash? Can you make it fun and interesting too?

Examples  
A clash opposing {9,10} to {1,12} is fun: all orbs are different-sized.  
A clash opposing {5,7} to {5,7} is valid: the contenders brought up equal volumes of glowing and sparkling hooch.  
A clash opposing {1,2} to {2,2} is possible: at least three size-2 orbs are available.  

Assuming you could use them for a fun clash, challenging using {31,37} would be more interesting than using {25,32}.  

# Input
* Line 1: orbSizeMin and orbSizeMax, orb diameter bounds
* Line 2: glowingSize1 and glowingSize2, the king of the hill's glowing orb diameters

# Output
* If you can produce a fun clash, sparklingSize1 and sparklingSize2 orbs' diameters in increasing order. 
* If you can produce multiple fun clashes, stick to the most interesting one.
* If you can merely produce a valid clash, VALID
* Else just print any string you want.

# Constraints
* 0 < orbSizeMin ≤ glowingSize1 ≤ glowingSize2 ≤ orbSizeMax ≤ 10⁵
* orbSizeMax - orbSizeMin ≤ 3500
* Orbs are perfectly spherical.
