# Puzzle 
**A Man with a Plan** https://www.codingame.com/training/hard/a-man-with-a-plan

# Goal
You're a peasant, but you've got enough of this life. You want to be famous, rich, and live in a castle… And you have a plan to reach this objective:  
You heard that the king would be extremely generous with the hero who would fulfill a certain act of bravery in his name.  
You must be this hero! You gonna leave your house, cross the realm, achieve the king's quest, and then go to the castle to get your due.  
So much to do to make your dream come true! So you want to plan your journey perfectly to avoid any waste of time.  

You procured a map of the realm and, looking at it, you notice there are four kinds of grounds you might be confronted with:  
Firstly, flat and peaceful grasslands, that you can cross in two days. Secondly, water points.  
You do not know how to swim, but there will always be a fisher to make you pass through in two days on his boat.  
Thirdly, mountains. You will have to climb to pass them, but you are a strong man and you think that will take just four days.  
And finally, swamps... A real hell, that will retain you six days!  
You also notice the existence of ravines, but you decide to consider them as impassable because you have vertigo. 

You continue your study of the map with the points of interest existing in the realm.

There is of course the king's castle, your final goal, which is pretty well guarded.  
Pass by there before you finish your quest will make you waste one day convincing the guards you are not a thief.

You note the presence of two shops that could potentially be helpful.  
A blacksmith, who can sell you an armor and a sword that will permit you to accomplish any act of bravery twice as fast.  
And a stable, where you can buy a horse to travel twice as fast, even on water since the horse can pull the boat.  
But you want to be sure those purchases will serve your quest, because you are aware that you will not be able to climb a mountain with your horse, or to cross a water point without your armor rusting.  
And it's absolutely out of question to abandon them once purchased. Moreover, you are very bad at negotiating, while the blacksmith and the breeder are certainly real sharks. 
You can be sure that if you enter in one of those stores, you will spend one day arguing, to finally surrender and buy something.  
You also know from their reputation that these two men really love their respective work, and would not hesitate to retain you one day to verify you are taking good care of your purchases, if you pass back by their workshops.

There's also the house of a crazy wizard, who teleports anyone he sees to the closest point of interest.  
That can be useful, or a total mess. You have to study carefully where the old man will send you and then use his "services" wisely, or not at all.  
All the more that you will need one day to recover after the sudden change of environment... 

You now observe three special places: The lair of an awful dragon, a cavern known to hide a fantastic treasure, and a dungeon where is imprisoned a princess member of the royal family. You know that the king's quest only concern one of those, but you do not exclude the possibility to cross the other two if that can save you some time.  
Since each of those spots is extremely dangerous and populated with enemies, it will take you four days to pass through one of them.  
But once the cleansing done, passing there again will only take one day. But not less, even with a horse, because of the tourists that will inevitably come to admire the places of your feats.

Finally, you add your house to the map. You know that your mother will not let you leave so easily, she can be a little clingy.  
You will have to devote a full day to convince her to let you go, and another day each time you return home... But, hey! She's your mom!

With the map of the realm in your possession, and knowing the objective of the king's quest, can you say how many days your quest will take you at least?

# Input
* First line: W, H and N, three integers, respectively the width and the height of the realm, and the number of points of interest existing in the realm.
* Second line: O, a string, the objective of the king's quest.
* Next H lines: A string of length W with each char representing a piece of land of the realm, among:
  - G for a grassland,
  - W for a water point,
  - M for a mountain,
  - S for a swamp,
  - R for a ravine,
  - I for a point of interest.

* Next N lines: k, x and y, a string and two integers, respectively the kind and the coordinates of a point of interest. With k among:
  - HOUSE,
  - CASTLE,
  - BLACKSMITH,
  - STABLE,
  - WIZARD,
  - PRINCESS,
  - DRAGON,
  - TREASURE.
  
# Output
* An integer D, the minimum number of days that your quest will take.
  
# Constraints
The (0, 0) coordinates correspond to the top-left corner of the realm.

Each piece of land is directly connected to its eight neighbors.

The wizard uses Manhattan distance.

* 3 <= W, H <= 20
* 3 <= N <= 8
* 0 <= x < W
* 0 <= y < H
* 0 < D < 100
