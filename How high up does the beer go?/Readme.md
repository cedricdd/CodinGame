# Puzzle
**How high up does the beer go?** https://www.codingame.com/training/easy/how-high-up-does-the-beer-go

# Goal

You will be given 3 measurements (in centimeters) of a drinking-glass, sitting on a bar:  
* its bottomRadius
* its topRadius = the radius of the lip (this is always larger than bottomRadius)
* its height, glassHeight

And you will be given a volume of beer beerVol in cubic-centimeters (also known as milliliters) that's been poured into the drinking-glass.

How high up (beerHeight) in the drinking-glass does the beer go ?

The above-described drinking-glass (upside down) in geometry is called a frustum.

Wikipedia describes it thus:  
"A cone with a region including its apex cut off by a plane is called a truncated cone; if the truncation plane is parallel to the cone's base, it is called a frustum."

The volume of conical frustum is:  
V = (1/3) * π * h * (r² + r * R + R²)  
...where r and R are the radiuses and h is the height.  
But remember the radius of the top of the drinking-glass isn't the radius of the top of the beer.  

To better understand frustum geometry, you can experiment with:  
https://www.omnicalculator.com/math/truncated-cone-volume  
https://rechneronline.de/pi/truncated-cone.php  

Tips:  
Your first instinct might be to try an Analytic solution, by simply plugging numbers into a formula.  
But there are 4 elements, and you'd need to know 3 of them; but you only know 2 ☹️  

These elements are:  
* volume of the beer beerVol
* bottom radius of the drinking-glass bottomRadius
* height of the beer (unknown)
* radius of the drinking-glass at the spot where the top of the beer is (unknown)

So Analytic solution might be a bit tricky.  
Perhaps try an Iterative method instead.  

* Beer foam doesn't matter. Think of it as water instead if you prefer
* https://en.wikipedia.org/wiki/Cone#
* https://en.wikipedia.org/wiki/Iterative_method

# Input
* Line 1: 4 floats separated by a space: bottomRadius topRadius glassHeight beerVol

# Output
* Line 1: A float, beerHeight rounded and displayed to the nearest tenth
* Height is measured perpendicular to the bar

# Constraints
* 0 < beerHeight < glassHeight < 50
* 0 < bottomRadius < topRadius < 50
* 0 < beerVol < 5000
