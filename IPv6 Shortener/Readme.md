# Puzzle
**IPv6 Shortener** https://www.codingame.com/training/easy/ipv6-shortener

# Goal
An IPv6-Address is the next-generation network address for electronic devices.  
Compared to an IPv4 address, it is made up of 8 blocks that are 4 hexadecimal digits long, split by colons.  
An example of an IPv6 address is 2001:0000:3c4d:0015:0000:0000:0db8:1a2b  

To avoid needing to write so many digits, you can short an IPv6 address very easily by removing unneeded zeros.  
The goal of this puzzle is to compress the IPv6 address, that it gets shortened.  
The shortened version would look like this: 2001:0:3c4d:15::db8:1a2b  

You can see that the leading zeros of all the blocks were removed, and a double colon replaced the longest chains of blocks that contained zeros only.

To find out where the double colon needs to be placed, you simply take a look where the longest streak of zero-only blocks is:
```
2001:0000:3c4d:0015:0000:0000:0db8:1a2b
    |----|
```

This is a zero-only block, but not the longest - it can be shortened to simply a 0
```
2001:0:3c4d:0015:0000:0000:0db8:1a2b
                |---------|
```

When you find the longest streak, as in the example above, simply replace it with a ::  
If there are two or more streaks, separate from each other, with the same length, replace the first one starting from the left.  
The number of zero-only blocks does not matter how many colons you need to use - it is always two colons.  

The last step is to remove the leading zeros of every block.

If everything was successful, then you have your shortened IPv6, in this case: 2001:0:3c4d:15::db8:1a2b

Notes: The double colon may only be used once in the whole address at the longest streak of zero blocks, and only if there are two or more zero blocks next to each other.  
The rest of the single blocks that contain zeros only must be represented as only one zero in the whole block, no matter if they are next to each other.  

# Input
* A string ip that is the uncompressed IPv6 address.

# Output
* A string output that is the compressed IPv6 address.

# Constraints
* Length of IP: 39 symbols, 8 blocks to 4 hexadecimal symbols split by 7 colons
