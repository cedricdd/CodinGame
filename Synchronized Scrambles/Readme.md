# Puzzle
**Synchronized Scrambles** https://www.codingame.com/contribute/view/135711354e3dac3eee928fbc0fdf1fe0aa75c2

# Goal
In our interconnected world, people across different time zones often coordinate meetings and events. Sometimes, purely by coincidence, the time displayed on clocks in two different time zones uses exactly the same digits arranged differently - creating what we call "synchronized scrambles."

Given two time zones represented by their UTC offsets (in format ±HHMM), find all distinct time points where the clock readings in both zones are anagrams of each other when represented as 4-digit strings (in 24-hour HHMM format).

Two time readings are considered anagrams if they use exactly the same digits with the same frequency. For example, 2303 and 0332 are anagrams because both contain one 0, one 2, two 3s.

Example:  
Time zones: UTC+0200 and UTC+0530 (3.5 hours difference)

At UTC time 21:03, the readings are:  
UTC+0200: 23:03 → 2303  
UTC+0530: 02:33 → 0233  
These are anagrams.  

At UTC time 20:33, the readings are:  
UTC+0200: 22:33 → 2233  
UTC+0530: 02:03 → 0203  
These are NOT anagrams (different digit frequencies).  

Output all such anagram time pairs that occur within a 24-hour period, ensuring each represents the same moment in time across both zones.

Note: The possible values of timezone offsets come from this Wikipedia page: https://en.wikipedia.org/wiki/List_of_tz_database_time_zones#Further_reading and could include offsets not currently in use.  
Note: Ignore leap seconds, daylight savings and other timezone shenanigans and treat the timezone offset as is.  

# Input
* Two UTC offset strings separated by a space (offset1 offset2)

# Output
* Line 1: N Count of distinct anagram time pairs found
* Next N lines: time pairs in the format: (hhmm, hhmm) representing the time in the two timezones. The entries must be sorted in lexicographical order and separated by a comma and space.
  
# Constraints
* offset1 ≠ offset2
* Each case is guaranteed to have at least one anagram time pair.
