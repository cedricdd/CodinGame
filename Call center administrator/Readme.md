# Puzzle
**Call center administrator** https://www.codingame.com/contribute/view/13178460c61851636649808c180d57229857a9

# Goal
You are the IT administrator for a call center.  
To better optimize your old VoIP server, you want to make a script to calculate the call peak with the CDR (Call Detail Records) from yesterday!  

# Input
* First line: Integer N for total of calls of the last day.
* Next N lines: For each call, two date-times formatted as ISO8601 for start (answer) and end (hangup) of the call, separated by space.
* The old call-center software cannot proceed more than one event (answer or hangup) by second, so the same time will never appears twice.

Example of a date-time using the ISO8601 format: 2025-01-31T16:00:00
No time-zone or other variant of ISO8601 is used in this puzzle.
More details on this format: https://en.wikipedia.org/wiki/ISO_8601

# Output
* An integer representing the maximum number of simultaneous call.

# Constraints
* 1 ≤ N ≤ 1000
