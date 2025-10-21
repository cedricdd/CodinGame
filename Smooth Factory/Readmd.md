# Puzzle
**Smooth Factory** https://www.codingame.com/training/medium/smooth-factory

# Goal
Edsger is Ming and Ham's teacher. He's quite fond of them playing Smoothie Reduction, as their grades have kept improving since they started, for some reason.

Edsger is a man of influence. He's willing to pull some strings so that the next bulk shipments all result in victories for Ming and Ham.   
Edsger is also lean. He'll want the shipments to be as little as possible. Edsger strives to be a good teacher, so he'll also ensure no two shipments are the same size. For the learning experience.

How many pieces of fruit will he have to schedule over the following weeks to ensure Ming and Ham enjoy at least V victories?

This is a harder take on easy puzzle “Smooth!”. You may want to solve that one first. In any case, here's a reminder of the game.

Smoothie Reduction

Ming and Ham like smoothies. To make smoothies, you need a lot of fruit. Every now and then, they'll play a little game.   
They'll buy a lot of fruit in bulk, and then take turns at “reducing” it.

A turn of reducing works as follows:
* Ming will neatly arrange the fruit in a first line, with the pieces evenly spread
* Ham will pick a fruit type from stock, and arrange them in a second line, evenly spread, such that each one matches a bundle of exactly n pieces in the first line, with n depending on the fruit type (see table below)
* If any fruit in the first line is left unmatched with fruit from the second line, Ming eats it and the game finishes in defeat
* Else they scoop all fruit from the first line to the blender, swap roles and repeat

They have the following fruit types in stock:
* apples, that spread one for every bundle of n = two
* oranges, that spread one for every bundle of n = three
* bananas, that spread one for every bundle of n = five
* watermelons, that spread one for every bundle of n = one

The game ends in a victory if the second row ever gets reduced to a single watermelon at the end of a turn.

Example
```
If Edsger wants to ensure 5 victories, he'll need to schedule:
• a size-1 “bulk” fruit arrival on week 1
• a size-2 bulk fruit arrival on week 2
• a size-3 bulk fruit arrival on week 3
• a size-4 bulk fruit arrival on week 4
• a size-5 bulk fruit arrival on week 5
…for a total of 15 pieces of fruit.
```

# Input
* Line 1: V number of victories

# Output
* One line: F amount of fruit to schedule

# Constraints
* V ≤ 4500
