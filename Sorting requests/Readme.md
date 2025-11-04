# Puzzle
**Sorting requests** https://www.codingame.com/contribute/view/90634bc6b3782045c772c9542dba6e3476542

# Goal
Pepito is using an API to import and read books. A book is divided in chapters in the format: number, dot and the actual title. For example: 3. A New Journey or 5. Crossing Paths.

When Pepito imports a chapter, the API adds it at the back of the book. This is troublesome because, over the years, Pepito did not add the chapters in order. He now wants to sort his book by their numbers (as an integer).

Unfortunately, the API only lets him send a patch request for individual chapters, where he sends the chapter and a (one-indexed) position and it will insert the chapter at that position (moving the remaining chapters below by one position). For example, if his (unsorted) book looks like this:  
* 1\. Into the Unknown  
* 10\. In Pursuit of Truth  
* 3\. A New Journey  

and he sends to the API the request 3. A New Journey 1, where the last number is the (one-indexed) position to insert it, the book will now look like this:
* 3\. A New Journey
* 1\. Into the Unknown
* 10\. In Pursuit of Truth

Now, Pepito could sort his book by first sorting the chapters by their numbers, and then sending a request per chapter in that sorted order, but the API is slow, and Pepito is a good citizen, so he tries to minimize the number of requests to lower the strain on the API.

If you consider the previous example, Pepito only had to send one request: 3. A New Journey 2 so that it becomes sorted:
* 1\. Into the Unknown
* 3\. A New Journey
* 10\. In Pursuit of Truth

Find the minimum number of requests that Pepito has to send in order to sort his book. Print that number, and then, for the next number lines, print the requests that Pepito has to send. The solution to the given example should be:
* 1
* 3\. A New Journey 2

NOTE: Since the solutions are almost never unique, return the lexicographically smallest (by chapter number as an integer) requests that Pepito could have done.

# Input
* Line 1 : An integer n_chapters for the number of chapters in Pepito's book.
* Next n_chapters lines: A chapter of Pepito's book in the format: number, dot and the actual title.

# Output
* Line 1 : An integer n_requests for the minimum number of requests that Pepito has to send in order to sort his book.
* Next n_requests lines: The lexicographically smallest, by chapter number as an integer, requests that Pepito has to send.

# Constraints
* 0 < n_requests < 50
