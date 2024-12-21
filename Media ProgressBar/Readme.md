# Puzzle
**Media ProgressBar** https://www.codingame.com/contribute/view/1035367a29eefaa0e84cc24b23dabd8cc76e7b

# Goal
To construct the progress bar, you will receive the full time ft and elapsed time et, as well as the specified length ln of the progress bar, which could be, for instance, 10 characters. The progress bar should be displayed in a designated format. For example:
```
ft: 21:12
et: 12:21
ln: 12
```

Output:
```
12:21  ||||||------  -08:51
--a--  ------b-----  ---c--
```

Part a: the elapsed time  
Part b: the progress bar (12 characters in length) (Full Characters with | and the empty ones with -)  
Part c: the remaining time (with a "-" on the left)  
Don't forget to include two spaces between parts a and b, and another two between parts b and c.  

Please note that both the elapsed time and the full time are provided as strings in formats of either minutes (e.g., 12:34 or 0:59) or hours (e.g., 12:34:56), and rounding is performed using 'floor'.

# Input
* Line1: (String) Full Time ft
* Line2: (String) Elapsed Time et
* Line3: (Integer) Length ln

# Output
* (String) The ProgressBar
