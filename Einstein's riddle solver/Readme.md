# Puzzle
**Einstein's riddle solver** https://www.codingame.com/training/hard/einsteins-riddle-solver

# Goal
You must output the result of an Einstein's riddle.

An Einstein's riddle is a logical puzzle where nbPeople people are assumed to all have different names, different characteristics...  
It means if Georges eats Salad, then none of the others can eat Salad. And also, if Georges eats Salad, then he cannot eat anything other than Salad.  

Each line of input contains a list of characteristics that are all in the same category. For example, in the first test case, the first category is the individual's first name, the second is their means of transportation, the third is the type of plant they like, and finally the pet they own.

Each category of characteristic has nbPeople different possibilities. For example, the second line lists various means of transportation, and it has 4 possibilities (Autobus, Car, Bicycle or Roller) so that each person has one, and only one, associated means of transportation.

You are given a number of relational links that can be either in the format:

Georges & Salad which means Georges eats Salad  
or   
Georges ! Salad which means Georges doesn't eat Salad.  

The relational links can be on any two characteristics, and permit the riddle to be solved using logic. The relational links are guaranteed to be sufficient to solve the riddle, and are always non-contradictory. For example, we can't have Georges & Salad and Georges ! Salad.

The goal is to solve the riddle and print it as a grid, separated by space and newline, with each person in their own column and each characteristic category on its own line.

The characteristics in the first line will be ordered alphabetically, and each subsequent line will have the characteristics of that category ordered such that they match up correctly with the characteristics in the first line of output. In this way, each column of the output corresponds to the same person, with each person associated with one characteristic from each category.

# Input
* Line 1: Two space separated integers nbCharacteristics and nbPeople for the number of characteristics and the number of people
* Next nbCharacteristics lines: The list of all characteristics in each characteristic category (one category per line), space separated
* Next line: N the number of relational links
* Next N lines: One relational link per line, with each link formatted as either Georges & Salad or Georges ! Salad

# Output
* Line 1 to line nbCharacteristics: The grid of characteristics representing the solution to the riddle, line by line
* The order of the characteristic categories (the lines) is as given in the input, and the order of the people (the columns) is such that the first characteristic (which may or may not be first name) is presented in alphabetical order.

# Constraints
* 1 ≤ nbCharacteristics, nbPeople < 10
