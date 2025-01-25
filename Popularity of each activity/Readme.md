# Puzzle
**Popularity of each activity** https://www.codingame.com/training/easy/popularity-of-each-activity

# Goal
Here is a rectangle (eventArea) divided (in a wonky "Tic-Tac-Toe-style") into 9 smaller rectangles (activityAreas).

It is an aerial-view snapshot of a kids-event, with 9 activities that attendees can do: face-painting, pony-rides, fort-building, magic show, corn-maze, giant bubbles, etc.

Each attendee is a *

The dividing lines are shown as : or -  
The points where dividing lines intersect are shown as +

*Your Task:*  

We want to know (for this moment in time):  
* the total number of attendees (totalAttendees) and
* what percentage of attendees were in each activityArea. These 9 percentages are called percentageAtThisActivity.

How to display each percentageAtThisActivity:  
* It is rounded to nearest integer
* It is followed by %
* It is exactly 4 characters long. If necessary, pad the left with one or more underscores (_) to force proper alignment

Note: The percentages may not add up to 100% after rounding.

*Your impact:*  
We'll use this output to help quantify how popular each activity was.  
Based on that, some activities may (or may not) be included at next year's event.  

# Input
* Line 1: An integer height of eventArea
* Next height Lines: A string representing a row of eventArea

# Output
* Line 1: An integer totalAttendees, followed by attendees
* Lines 2-4: percentageAtThisActivity in the same ordering/configuration as the input eventArea.

# Constraints
* There will be no attendees (*) on the dividing borders, i.e., it will be clear which activityArea each attendee belongs to.
* There are always at least 2 attendees
