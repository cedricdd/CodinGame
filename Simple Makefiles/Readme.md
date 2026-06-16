# Puzzle
**Simple Makefiles** https://www.codingame.com/contribute/view/149373d871f27bdcdc97a723791d28b1fdfe5e

# Goal
A makefile is a build script read by the make utility. It describes how to produce files (called targets) from other files (called prerequisites), by running shell commands called actions. make figures out the correct order to run those actions so that every prerequisite exists before it is needed.

Your task is to implement a simplified makefile processor: read a makefile and a list of targets to build, then print the actions that would be executed, in order.

*Makefile syntax*  
A makefile is a sequence of rules, action lines, comments, and blank lines.

*Rule lines*  
A rule line declares one or more targets and their prerequisites: ```target1 [target2 ...]: [prereq1 prereq2 ...]```

Everything before the : is a whitespace-separated list of target names. Everything after is a whitespace-separated list of prerequisite names. Either list may be empty.

If multiple targets appear before the :, it is exactly equivalent to writing a separate identical rule for each target.

A target name may appear in more than one rule line. Its prerequisites are the **union** of all definitions, and its actions are the **concatenation** of all definition action lines, in order of appearance.

*Action lines*  
An action line immediately follows a rule line (or another action line) and begins with a single TAB character**. It contains the command to execute when building the rule's target(s). TAB appears **only** at the start of action lines.

*Comments and blank lines*  
A # character begins a comment that extends to the end of the line, on any line type. Blank lines are ignored.

*Built-in macros*  
Inside an action line, the following macros may appear as **complete, standalone tokens** (never embedded inside a longer word):

```
| Macro | Expands to
|-------|-----------
| $@    | The name of the target being built
| $<    | The first prerequisite of the rule
| $^    | All prerequisites of the rule, space-separated, in definition order
```

**Build semantics**

*Determining what to build.* If no targets are requested, the default target — the first target named on the first rule line of the makefile — is built.

*Prerequisite-first ordering.* Before a target is built, all of its prerequisites must be fully built. A target that has no rule at all is assumed to already exist (like a source file checked into version control); it requires no actions and has no prerequisites of its own.

*Lexicographic tie-breaking.* When the dependency graph leaves the order between two targets unconstrained, the one whose name is lexicographically smaller is built first. This applies both to prerequisites listed in a rule and to multiple targets requested on the command line.

*Built once.* Each target is built at most once, even if multiple targets depend on it.

*Actions only when defined.* A target that has no action lines produces no output, but its prerequisites are still built.

*Timestamps ignored.* Unlike real make, this processor does not check whether files are up to date. Every target that has action lines is unconditionally rebuilt.

*Cycle detection.* Before any build begins, the entire dependency graph is checked for circular dependencies. If a cycle exists anywhere in the graph — even among targets not being built — the build is aborted.

---

Example

The following makefile compiles two source files into object files, then links them into a program. No targets are explicitly requested, so the default target all is built.
```
all: main.o util.o
	gcc -o $@ $^
main.o: main.c
	gcc -c $< -o $@
util.o: util.c
	gcc -c $< -o $@
```

main.o and util.o are prerequisites of all and must be built first. main.c and util.c have no rules, so they are assumed to exist. Between main.o and util.o, neither depends on the other, so the lexicographically smaller name main.o is built first.

The actions output are:
```
gcc -c main.c -o main.o
gcc -c util.c -o util.o
gcc -o all main.o util.o
[Build complete]
```

Note that $^ in the all rule expands to main.o util.o — the prerequisites in their definition order, not the order they were built.

# Input
* Line 1: An integer N, the number of targets to build. If N is 0, the first target defined in the makefile (the default target) will be built.
* Line 2: N space-separated strings, each a target name to build. This line is blank when N is 0.
* Line 3: An integer L, the number of lines in the makefile.
* Next L lines: The makefile, one line at a time. Syntax rules are described above.

# Output
* If a circular dependency is detected: ```[Circular dependencies detected]```
* Otherwise:
	* One line per action executed:> The tokens of the action, separated by single spaces, with all built-in macros already expanded. Actions are emitted in build order: a target's prerequisites are fully built before the target itself, and lexicographically smaller names are built first when the dependency graph imposes no further constraint. Targets with no action lines produce no output.
	* [Build complete]

# Constraints
* L <= 1000
