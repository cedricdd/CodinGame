# Puzzle
**Orbital Logistics: Exact Load** https://www.codingame.com/contribute/view/1460737ecdfdbf3e1faa74bc9d340d6ec822c4

# Goal
A cargo captain is preparing a shipment for a space journey.

The spaceship has a weight capacity of capacity.

There are itemCount available cargo items. Each item has a weight weight and a resale value value.

The captain wants to find the maximum total value of a subset of items such that:
* the total weight is exactly equal to capacity
* each item is used at most once

If it is not possible for the spaceship to carry items weighing exactly capacity, output -1 instead.

# Input
* Line 1: Two integers capacity and itemCount representing the capacity and the number of cargo items.
* Next itemCount lines: Two integers weight and value representing the weight and resale value of each cargo item.

# Output
* Line 1: An integer representing the maximum total value of a subset of items whose total weight is exactly equal to capacity, or -1 if no such subset exists.

# Constraints
* 1 ≤ capacity ≤ 10^6
* 1 ≤ itemCount ≤ 40
* 1 ≤ weight ≤ 10^6
* 1 ≤ value ≤ 10^6
