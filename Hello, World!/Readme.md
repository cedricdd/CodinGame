# Puzzle
**Hello, World!** https://www.codingame.com/training/easy/hello-world

# Goal
Write Hello, World! to the standard output.

... Wait, that would be too easy.

You are given geolocation coordinates of N capital cities (or other places of interest).  
You are also given N Hello World! messages in a language that corresponds to each of these places.  
You are given M geolocations of your travel, and for each of these points, you have to find the closest capital and print the corresponding Hello, World! message.   
If there are multiple capitals which are closest with the same distances rounded to integer kilometers using 'half up' rounding, (e.g. positive x.5 goes up), then print all eligible messages separated by a space in the order they were given in the input.

Distance shall be not Eucledian, but orthodromic , e.g. measured along the surface of the Earth.  
For this puzzle Earth is treated as a perfect sphere with a radius of 6371 km.  

A geocoordinate is given as a space separated latitude longitude pair.  
latitude is in the format "Nddmmss" where first letter is N (North) or S (South), next two digits are the degrees (00 to 90, padded with zeros to 2 digits), then arcminutes (00 to 59), then arcseconds (00 to 59).  
Similarly, longitude is in format "Edddmmss" where first letter is E (East) or W (West), followed by degrees, arcminutes and arcseconds, but here degrees are padded to 3 digits (000 to 180)  
This is the sexagesimal DMS system, not a decimal one, but with the ° ' '' symbols omitted.  
Example: geolocation of Rupelmonde, birthplace of 16th century cartographer Mercator is N510734 E0041727  

*Hints:*  
For distance formula, see https://en.wikipedia.org/wiki/Great-circle_distance  
Use the 1st (arccos) formula from the above wikipedia page.  
Use 64-bit precision float to avoid errors due to loss of precision.  
Don't forget to convert degrees, arcminutes, arcseconds to decimal degrees.  
Don't forget to handle North/South and East/West as the sign of decimal degrees.  
Don't forget to convert decimal degrees to radians (distance formula is in radian!)  

Disclaimer: Sorry, if the message is not linguistically correct in some of the languages used in the test cases.   
This is a simple coding puzzle, not a linguistic puzzle.

# Input
* Line 1: An integer N for the number of capitals.
* Line 2: An integer M for the number of geocoordinates of your travel, for which to print a message.
* Next N lines: Space separated name and geocoordinates (latitude and longitude) for the capitals. 
* Note: name is not really used in the puzzle, but you still have to read them.
* Next N lines: The Hello, World! message for each of the capitals (might contain spaces).
* Next M lines: Geocoordinates latitude and longitude of your travel locations, for which you need to find the closest capitals.

# Output
* M lines: The string "Hello World!" message(s) corresponding to the closest capital(s) to the given travel geolocation (in order of input).
* In case multiple capitals have the same distance (rounded to kilometers), than all corresponding messages shall be printed on the same line, separated by a space (in the order the input was given)

# Constraints
* 1 ≤ N ≤ 250
* 1 ≤ M ≤ 20
* S900000 ≤ latitude ≤ N900000
* W1800000 ≤ longitude ≤ E1800000
* You can assume that all provided geocoordinates are valid.
* As Unicode support might be limited in some languages, in this puzzle all messages contain only characters with ASCII codes 32 to 126 (E.g. English uppercase and lowercase letters, most punctuations, space).
