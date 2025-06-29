# Puzzle
**Button Mash** https://www.codingame.com/training/easy/button-mash

# Goal
You are given a device with a display and three buttons: +1, -1, and ×2. The display starts at 0.

Calculate the minimum number of button presses required to display an integer n.

Rules:  
- The device cannot display negative numbers.
- Pressing -1 when the displayed number is 0 will cause the device to malfunction. Avoid this situation.

Example:  
To reach the number 59, the minimum sequence of button presses is:  
```+1, +1, ×2, ×2, ×2, -1, ×2, ×2, -1```
This requires 9 operations in total.

# Input
* Line 1: An integer n

# Output
* Line 1: The minimum number of button presses to display n

# Constraints
* 1 ≤ n ≤ 10^6
