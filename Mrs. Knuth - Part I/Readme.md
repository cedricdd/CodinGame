# Puzzle
**Mrs. Knuth - Part I** https://www.codingame.com/contribute/view/94231c8a12567007bde24553f6a9e3de55981

# Goal
This puzzle is part 1 of a multi-part Algorithm X tutorial and is meant to be done per the guidance in the following playground: https://www.codingame.com/playgrounds/156252

Although you may use any language you wish to complete this puzzle, the playground is written for the Python programmer. Most importantly, the reusable Algorithm X Solver provided in the playground is written in Python. If you follow the directions in the playground and use Python, this puzzle should be significantly easier than if you choose another language or algorithm.

*Task Overview:*  
Mrs. Knuth, the school band teacher, has asked you to write an algorithm to generate her weekly private lesson schedule for the summer. Her availability is different from week to week, but she will always teach between 1 and 5 days per week. On each day that she teaches, she will teach between 2 and 8 hours. Because she likes consistency, she will teach the same number of hours on each day she teaches, but the actual time slots during which she is available might be different from day to day.  
Mrs. Knuth is a creature of habit. Her workday starts at 8am every day and ends at 5pm with an hour break for lunch each day from noon to 1pm. Although she is at school 9 total hours every day, she might not be available to teach on some days, she might have partial teaching availability on other days or she might have a day where she teaches every free minute other than during lunch.  
Mrs. Knuth is also a bit odd when it comes to music. To keep her mind fresh, she refuses to teach more than a single hour per day for any particular instrument. If she teaches 3 hours in one day, those lessons must be for 3 different instruments. If she teaches 8 hours in one day, all 8 instruments that day must be different.  
Given Mrs. Knuth’s open availability and each student’s instrument and lesson availability, generate a schedule for Mrs. Knuth that allows her to work with each student one time per week and meets her quirky demands.  

*Note About INPUT Formatting:*  

Availability for Mrs. Knuth, or for any one student, is formatted as a character string using the following abbreviations for the days of the week: M, Tu, W, Th and F. An availabilityString will contain all 5 abbreviations in this same order. After each abbreviation will be between 0 and 8 integers representing the times the person is available on that day. Lessons can be taught in the morning at 8, 9, 10 and 11 and in the afternoon at 1, 2, 3 and 4. Consider the following availabilityString:
```
M 1 2 3 Tu W Th 8 9 F 11
```

This indicates the person is available on Monday at 1pm, 2pm and 3pm, on Thursday at 8am and 9am and on Friday at 11am. This person has no availability on Tuesday or Wednesday.

The only valid elements in an availabilityString are M, Tu, W, Th, F, 8, 9, 10, 11, 1, 2, 3 and 4. All elements of an availabilityString are space separated.

*Note About OUTPUT Formatting:*  
Mrs. Knuth requires a very specific format for her calendar. Her calendar has 10 rows and 6 columns with one space between each of the 6 columns.  
Column 1 is 2 characters wide. In it, rows 2 – 5 and 7 – 10 contain the hours of the days, right justified. See the example below.  
Columns 2 – 6 are each 14 characters wide. The contents of each row in each column is always center justified, with the extra space being on the right when it is not possible to perfectly center justify the text. At the top of each column is the day, fully written out as Monday, Tuesday, Wednesday, Thursday or Friday. In the 6th row of columns 2 - 6 is the word LUNCH.  
The remainder of columns 2 – 6 contain Mrs. Knuth’s teaching schedule. If no student is scheduled on a particular day at a particular hour, the schedule should contain 14 dashes (--------------). Wherever a student has been scheduled, the location should contain the student’s name and the student’s instrument separated by a /.  

All lines of the schedule must have trailing spaces removed.

# Input
* Line 1: Mrs. Knuth’s teacherAvailability
* Line 2: An integer numStudents
* Next numStudents lines: name instrument studentAvailability

# Output
* 10 lines: schedule per the rules above. Trailing spaces must be removed from each line.

# Constraints
* 2 <= length of name <= 4.
* 4 <= length of instrument <= 9.
* numStudents = Mrs. Knuth's available hours per week.
* count of each type of instrument = count of days with hours in teacherAvailability, meaning the student roster will always contain the appropriate number of instruments to make sure no duplication of instruments on any one day is possible.
* All students have unique names.
* name and instrument do not contain any spaces.
* teacherAvailability and studentAvailability are in the availabilityString format as explained in Goal section and always valid (e.g. no duplicate hours on the same day).
* All lessons consist of 1 student with 1 instrument for 1 hour.
* Mrs. Knuth will be available to teach on at least 1 day and at most 5 days.
* Mrs. Knuth will teach the same number of hours per day on each day she teaches.
* All test cases have a unique solution.
