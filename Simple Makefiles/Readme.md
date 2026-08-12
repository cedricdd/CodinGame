# Puzzle
**Simple Makefiles** https://www.codingame.com/training/medium/simple-makefiles

# Goal
A Makefile is a build script that describes dependencies between dated files, and the actions required to build a target file from its prerequisite files; actions are executed in an order such that every prerequisite is up to date before it is needed.

Your task is to implement a simplified make utility: read a list of preexistingFiles with associated fileTimes, a list of goalTargets to build, and a Makefile, then print the actions that would be executed.

*Makefile syntax*  
A Makefile is a sequence of rules and actions, with optional comments.

*Comments*  
A # character begins a comment that extends to the end of the line. Comments are removed before applying other parsing rules.

*Whitespace*  
After using TAB to identify actions (see below), TAB and other leading and trailing whitespace are ignored, as are blank lines and extra spaces not needed to separate tokens.

*Rules*  
A rule associates a target with zero or more prerequisites. Each of these is generally a file, but can be any valid token string: ```target : [prereq1 ...]```

To the left of the : is a target. To the right is a whitespace-separated list of zero or more prerequisites. Whitespace adjacent to the : is optional.

A target may appear in more than one rule. Its prerequisites are the union of prerequisites in all its rules, and its actions are the concatenation of all associated rule actions, in order of appearance.

*Actions*  
An action is any line that begins with a TAB. It is associated with the preceding rule. Applying the whitespace rules above yields a sequence of tokens. Any token that matches a built-in macro (see below) is replaced by its expansion. When the action is executed, the resulting tokens are printed as a single line of output with single-space delimiters.

*Built-in macros*  
Within an action, built-in macros may appear as whole tokens. They are replaced by their expansions before the line is printed:

```
| Macro | Expands to
|-------|-----------
| $@    | The target being built
| $<    |The first prerequisite of the associated rule
| $^    | All distinct prerequisites of the rule, space-separated, preserving their order in the rule
```

*File times*  
A fileTime is an integer timestamp associated with a file. The higher the fileTime, the more recently the file was last updated. A file that does not exist has no fileTime.

*Circular dependencies*  
A circular dependency exists if any target is a prerequisite of itself, either directly or indirectly (even if the cycle involves targets not being built). The build is aborted prior
to executing any action, and the output is a single line: ```[Circular dependencies detected].```

*Minimal Build*  
- Only requested goalTargets and their direct or indirect prerequisites are built.
- A target is only built if it does not exist or it has a fileTime <= the fileTime of any of its prerequisites.
- When a target is built, its fileTime is updated to a value greater than any preexisting file's fileTime.

*Build Order*  
- goalTargets are built in the order they are given in the input.
- A target is built only after all of its prerequisites are built.
- A target is built at most once, even if it is a prerequisite of multiple other targets.
- Each target is built to completion, starting with its prerequisites, before proceeding to other targets.
- A target's prerequisites are built in lexicographic order.

*Build Output*  
- When a target is built, each of its actions from all rules is printed, in the order they appear in the Makefile.
- An action is printed as a single line of single-space-separated tokens, with all built-in macros expanded.
- A target that has no actions produces no output, but its prerequisites are still built, and its fileTime is still updated.
- After all goalTargets are built, print [Build complete] on a single line.

---

Example

The following Makefile compiles two source files into object files, then links them into a program.
```
all: util.o main.o
	gcc -o $@ $^
util.o: util.c
	gcc -c $< -o $@
main.o: main.c
	gcc -c $< -o $@
```

Assume the sole goalTarget is all. Assuming main.c and util.c are the only preexisting files, the build proceeds as follows: util.o and main.o are prerequisites of all and must be built first. Between util.o and main.o, neither depends on the other, so the lexicographically smaller name main.o is built first.

The actions output are:
```
gcc -c main.c -o main.o
gcc -c util.c -o util.o
gcc -o all util.o main.o
[Build complete]
```

Note that $^ in the all rule expands to util.o main.o—-the prerequisites in their given rule order, not the order they were built.

# Input
* Line 1: An integer nFiles, the number of preexisting files.
* Next nFiles lines: A preexistingFile and its integer timestamp fileTime, one file per line.
* Next Line: An integer nGoalTargets, the number of goal targets to build.
* Next Line: Space-delimited goalTargets, the nGoalTargets goal targets to build.
* Next Line: An integer nLines, the number of lines in the Makefile.
* Next nLines lines: The contents of the Makefile, one makefileLine at a time.

# Output
* If a circular dependency is detected: ```[Circular dependencies detected]```
* Otherwise:
	* One line per action executed: The tokens of the action, separated by single spaces, with all built-in macros already expanded. Actions are printed in the order they are executed.
	* [Build complete]

# Constraints
* 0 <= nFiles <= 20
* 1 <= length(preexistingFile) <= 100
* 1 <= length(goalTarget) <= 100
* 0 <= fileTime <= 1000
* 1 <= nGoalTargets <= 20
* 1 <= nLines <= 100
* 0 <= length(makefileLine) <= 100

preexistingFile consists of printable ASCII characters and does not contain whitespace, $, :, or #.
All fileTime values may be assumed to be in the past.

Within the Makefile:
- All Makefiles are syntactically valid.
- At least one rule is defined.
- Every file consists of 1-100 printable ASCII characters and does not contain whitespace, $, :, or #.
- Every prerequisite and every goalTarget is either a preexistingFile or is the target of at least one rule.
- $< is only used in actions with a rule having at least one prerequisite.
- Every action is preceded by at least one rule.
- Every action has at least one token.
- TAB characters appear only as the first character of an action.
