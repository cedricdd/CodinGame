# Puzzle
**Mrs. Knuth - Part III** https://www.codingame.com/training/hard/mrs--knuth---part-iii

Goal
This puzzle is part 3 of a multi-part Algorithm X tutorial and is meant to be done per the guidance in the following playground: https://www.codingame.com/playgrounds/156252

Although you may use any language you wish to complete this puzzle, the playground is written for the Python programmer. Most importantly, the reusable Algorithm X Solver provided in the playground is written in Python. If you follow the directions in the playground and use Python, this puzzle should be significantly easier than if you choose another language or algorithm.

*Task Overview:*  
Mrs. Knuth has received some wonderful news! This summer, she will only be working with a handful of honor students. Although she'll have fewer students, each student is now allowed to request multiple hours of instruction per week. This creates a situation where many potential schedules exist. Based on her preferences, Mrs. Knuth needs you to find the best schedule possible.

*Schedule Score Calculation:*  
The school math teacher, Mrs. Ruth, worked with Mrs. Knuth to develop the following scoring system to compare one schedule option to another. (High scores are better than low scores.)

Free Time: Continuous free time is more valuable than broken up chunks of free time. Any single hour of free time, including LUNCH, gets 2 points. However, 2 or more continuous hours of free time gets points calculated as 2 ^ (numberContinuousFreeHours). e.g. 5 continuous free hours gets 2 ^ 5 = 32 points. On the other hand, if Mrs. Knuth had lessons on some particular day at 9, 11, 1 and 3, she would still have 5 free hours during the day, but since each of those free hours would be standalone hours, the continuousFreeTimeScore for that day would be only 10 (2 + 2 + 2 + 2 + 2).

Loud Instruments: Mrs. Knuth prefers to teach loudInstruments during the morning hours whenever possible. Loud instruments taught during morning hours (8, 9, 10 or 11) get 50 points. Loud instruments taught in the afternoon get zero points.

Scheduling: Mrs. Knuth's energy wanes as the week progresses. She prefers having lesson early in the week as compared to late in the week. She also prefers teaching in the morning whenever possible.

Every student must be put on the schedule a number of times equal to that student's numHoursRequested. Each student placement on the schedule gets points determined by the day of the week and whether the placement was in the morning or the afternoon. Points for morning lessons (in order from Monday to Friday) are 15, 12, 9, 6 and 3. Lessons scheduled in the afternoon receive 10, 8, 6, 4 or 2 points depending on the day of the week.

Alphabetical Order: Mrs. Knuth's oddities are well known, so it should not be a shock that she prefers her daily students to be in alphabetical order. Consider each day of the week independently. Create a list of students from the beginning of the day to the end of the day, ignoring all free time. For each pair of contiguous students, if those students are in ascending alphabetical order, 15 points are awarded. A day that has only one lesson receives 0 points since there are no two student names to compare. A full day, with 8 students, could have up to 7 * 15 = 105 points.

Mrs. Ruth has been a tremendous help to Mrs. Knuth, but creating a scoring system to determine a best score might be an evolving process. Because of that, Mrs. Knuth has made one last request. After you display the best schedule, she would like you to "show your work" in regards to your calculations. This will help her see how her scoring system works which might help her make future improvements.

After displaying the best schedule, you must display 4 calculationDetailStrings (one for each category above) and, finally, the bestScheduleScore. A calculationDetailString must be in the following format:
```
mondayScore + tuesdayScore + wednesdayScore + thursdayScore + fridayScore = weeklyScore
```

The bestScheduleScore is the sum of its four weeklyScores.

All of Mrs. Knuth's previous requests must still be honored:  
* No single instrument shall be taught more than one hour per day.
* No two loudInstruments shall be scheduled in back-to-back hours.
* troublesomePairs shall not be scheduled back-to-back.

All notes about INPUT and OUTPUT formatting still apply to Part III. For details, see Part I or Part II located here:  
https://www.codingame.com/training/medium/mrs--knuth---part-i  
https://www.codingame.com/training/medium/mrs--knuth---part-ii  

# Input
* Line 1: Mrs. Knuth’s teacherAvailability
* Line 2: An integer numStudents
* Next numStudents lines: name instrument numHoursRequested studentAvailability
* Next Line: An integer numTroublesomePairs
* Next numTroublesomePairs lines: name1 name2

# Output
* 10 lines: schedule per the rules detailed in Part I and Part II. Trailing spaces must be removed from each line.
* Line 11: Blank line.
* Line 12: continuousFreeTimeCalculationDetails per the calculationDetailString specification above.
* Line 13: loudInstrumentCalculationDetails per the calculationDetailString specification above.
* Line 14: schedulingCalculationDetails per the calculationDetailString specification above.
* Line 15: alphabeticalOrderCalculationDetails per calculationDetailString specification rules above.
* Line 16: bestScheduleScore

# Constraints
* 2 <= length of name <= 4.
* 4 <= length of instrument <= 9.
* The only loudInstruments are Trumpet, Drums and Trombone.
* numStudents <= Mrs. Knuth's available hours per week.
* 0 <= numTroublesomePairs <= 2.
* The two names in a troublesomePair are always different.
* All students have unique names.
* name and instrument do not contain any spaces.
* teacherAvailability and studentAvailability are in the availabilityString format as explained in Goal section and always valid (e.g. no duplicate hours on the same day).
* All lessons consist of 1 student with 1 instrument for 1 hour.
* Mrs. Knuth will be available to teach on at least 1 day and at most 5 days.
* All test cases have a unique solution.
