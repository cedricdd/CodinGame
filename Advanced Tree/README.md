# Puzzle
**Advanced Tree** https://www.codingame.com/training/medium/advanced-tree

# Goal
Your goal is to recreate the behaviour of the UNIX tree program with support for some flags.  
You'll be given a starting path S, a list of flags F, and a list of files.

The tree will be printed with characters pipe | backtick ` hyphen - and with spaces.  
Refer to the first example to understand how you need to print the tree.

You'll also need to handle three flags inspired by the original tree program:  
- -a : Display hidden directories and files.
- -d: Only display directories (modifies the report line, see below).
- -L depth: Limit the "depth" of the tree.

A hidden file or directory has a name starting with a dot: .

The input path S must be printed followed by the text [error opening dir] if:  
- the path is a file, or
- the path doesn't exist

Finally, you'll need to print a new line plus the number of directories and files found as follows:

x directories, y files

where x is the number of directories and y is the number of files. If the -d option is in effect, that last line reads like this instead:

x directories

If x or y are equal to 1, then you need to print directory and file respectively.

The tree needs to be sorted in ascending, alphabetical, case insensitive order and without considering the leading and first character '.' (dot) from hidden files or directories names.

Incorrect flags must be ignored.  
You're only given valid paths, which are only starting with one "current directory" (./) and without "parent directory" (../)  
There are no empty directories.  
There are no spaces in files or directory names.  
There are no duplicated directories or files with the same name as either a hidden or non-hidden file/directory on the same depth (i.e: you will never see both .Directory1 and Directory1 in the same folder)

# Input
* Line 1: A string S - a path to execute "tree" in
* Line 2: An string F - a list of flags, possibly null, for the tree program separated with commas ,
* Line 3: An integer N - the number of files
* Next N lines: A list of files; each line is a single file

# Output
* The tree output

# Constraints
* N >= 0
* When provided, depth > 0
