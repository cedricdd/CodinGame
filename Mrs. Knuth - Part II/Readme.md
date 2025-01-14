# Puzzle 
**Mrs. Knuth - Part II** https://www.codingame.com/contribute/view/950238e7e8f40105ccd0fd6237bf60c4d25b3

# Goal
This puzzle is part 2 of a multi-part Algorithm X tutorial and is meant to be done per the guidance in the following playground: https://www.codingame.com/playgrounds/156252

Although you may use any language you wish to complete this puzzle, the playground is written for the Python programmer. Most importantly, the reusable Algorithm X Solver provided in the playground is written in Python. If you follow the directions in the playground and use Python, this puzzle should be significantly easier than if you choose another language or algorithm.

*Task Overview:*  

Mrs. Knuth was thrilled with the work you did for her in Part I and her scheduling has been a breeze! She did run into a couple of issues though, and she'd like you to integrate the following changes into your scheduling algorithm.  
Mrs. Knuth's schedule needs to be more flexible than she first thought. She isn't able to always teach the same number of hours on her teaching days. She also doesn't always have enough students to completely fill her teacherAvailability. You'll need to adjust your algorithm to handle her teacherAvailability possibly containing different numbers of hours for each day she teaches and you'll need to be able to handle hours in her teacherAvailability for which there ends up being no student scheduled.  
You might be impressed with Mrs. Knuth's newfound flexibility, but don't get too relaxed. She still requires that no instrument be taught more than one hour on any one day. On top of that, she has struggled with loudInstruments, specifically the Trumpet, the Drums and the Trombone. In the interest of her long-term hearing, she has asked that you make sure no two loudInstruments are ever scheduled back-to-back. (A lesson at 11am and a lesson at 1pm are not considered back-to-back since there is an hour lunch break between the two.)  
For the most part, the kids in school are good kids, but some kids get a bit rowdy when they are with certain friends. To avoid disruptions to her schedule, Mrs. Knuth has given you a list of troublesomePairs. It's important the individuals in these pairs never be scheduled back-to-back. There must be at least an hour of time between the two individuals to ensure they don't get each other wound up and start causing trouble.  

Despite Mrs. Knuth's wacky requests, all students must get a spot on her schedule.

All notes about INPUT and OUTPUT formatting still apply to Part II. For your reference, those notes have been copied here:

Note About INPUT Formatting:

Availability for Mrs. Knuth, or for any one student, is formatted as a character string using the following abbreviations for the days of the week: M, Tu, W, Th and F. An availabilityString will contain all 5 abbreviations in this same order. After each abbreviation will be between 0 and 8 integers representing the times the person is available on that day. Lessons can be taught in the morning at 8, 9, 10 and 11 and in the afternoon at 1, 2, 3 and 4. Consider the following availabilityString:

```
M 1 2 3 Tu W Th 8 9 F 11
```

This indicates the person is available on Monday at 1pm, 2pm and 3pm, on Thursday at 8am and 9am and on Friday at 11am. This person has no availability on Tuesday or Wednesday.

The only valid elements in an availabilityString are M, Tu, W, Th, F, 8, 9, 10, 11, 1, 2, 3 and 4. All elements of an availabilityString are space separated.

Note About OUTPUT Formatting:

Mrs. Knuth requires a very specific format for her calendar. Her calendar has 10 rows and 6 columns with one space between each of the 6 columns.

Column 1 is 2 characters wide. In it, rows 2 – 5 and 7 – 10 contain the hours of the days, right justified. See the example below.

Columns 2 – 6 are each 14 characters wide. The contents of each row in each column is always center justified, with the extra space being on the right when it is not possible to perfectly center justify the text. At the top of each column is the day, fully written out as Monday, Tuesday, Wednesday, Thursday or Friday. In the 6th row of columns 2 - 6 is the word LUNCH.

The remainder of columns 2 – 6 contain Mrs. Knuth’s teaching schedule. If no student is scheduled on a particular day at a particular hour, the schedule should contain 14 dashes (--------------). Wherever a student has been scheduled, the location should contain the student’s name and the student’s instrument separated by a /.

All lines of the schedule must have trailing spaces removed.

# Input
* Line 1: Mrs. Knuth’s teacherAvailability
* Line 2: An integer numStudents
* Next numStudents lines: name instrument studentAvailability
* Next Line: An integer numTroublesomePairs
* Next numTroublesomePairs lines: name1 name2

# Output
* 10 lines: schedule per the rules above. Trailing spaces must be removed from each line.

# Constraints
* 2 <= length of name <= 4.
* 4 <= length of instrument <= 9.
* The only loudInstruments are Trumpet, Drums and Trombone.
* numStudents <= Mrs. Knuth's available hours per week.
* 1 <= numTroublesomePairs <= 12.
* The two names in a troublesomePair are always different.
* All students have unique names.
* name and instrument do not contain any spaces.
* teacherAvailability and studentAvailability are in the availabilityString format as explained in Goal section and always valid (e.g. no duplicate hours on the same day).
* All lessons consist of 1 student with 1 instrument for 1 hour.
* Mrs. Knuth will be available to teach on at least 1 day and at most 5 days.
* All test cases have a unique solution.
