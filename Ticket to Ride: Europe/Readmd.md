# Puzzle
**Ticket to Ride: Europe** https://www.codingame.com/training/expert/ticket-to-ride-europe

# Goal
Ticket to Ride is a classic board game by Alan Moon and Days of Wonder in which you earn points by connecting cities via train routes. In this puzzle, you must calculate the maximum possible score in a Ticket to Ride scenario.

*EARNING POINTS*
- Each completed route provides a certain number of points.
- Each completed ticket card earns you a certain number of bonus points.
- Ticket cards that are not completed are worth negative points.

*COMPLETING ROUTES*  
Each route connects two cities, and requires you to expend two resources, both trainCars and cards, to complete it. The length of the route informs you how many of each resource are required. A route of length = 3 requires 3 trainCars AND 3 cards.

*STARTING GAME STATE*  
You will be provided with:
- Number of trainCars available for use. (Resource #1)
- Number and type of cards in your hand (Resource #2)
- Number and nature of tickets in your hand.
- A list of available routes on the board, and the resources required to complete each one.

*SCORING ROUTES*  
Points awarded for completing a route are based on the route length:
- length of 1: 1 pt
- length of 2: 2 pts
- length of 3: 4 pts
- length of 4: 7 pts
- length of 6: 15 pts

*SCORING TICKETS* 
Each ticket specifies two cities and a number of bonus points to be earned. If the two cities are connected via train routes (either directly or indirectly) then the points for the ticket are added to your score. If not, then the ticket’s points are deducted from your score.

*CARDS AND ROUTES*  
Each card in your hand is EITHER a colored card (8 colors available) OR an engine card (wild). Likewise, each route is EITHER one of the 8 colors, OR is Gray. To complete a colored route, you must expend length cards of the SAME color from your hand. So, to complete a Pink route of length = 3, you would need to expend 3 pink cards.

*ENGINE CARDS*  
Engines are wild, and can be used as a substitute for any colored card.

*GRAY ROUTES*  
Gray routes can be any color you want them to be. However, to complete a Gray route, the cards you expend MUST be all of the same color (potentially supplemented with engines).

*FERRIES* 
Some Gray routes (called “ferries”) require that a certain number of the cards you expend MUST be engine cards.

*FERRY EXAMPLE*  
A ferry of length = 3 and requiredEngines = 1 could be completed with:
- 2 red cards and 1 engine,
- 1 black and 2 engines,
- but NOT 3 blue cards,
- and NOT 1 green, 1 yellow, and 1 engine

*SCORING EXAMPLE*  
Given:
- A 5 point ticket for connecting Athina to Angora
- Two routes:
1) Athina to Smyrna (length = 2)
2) Smyrna to Angora (length = 3)

Total points received for completing both routes = 11 POINTS:
- 2 pts: complete route #1
- 4 pts: complete route #2
- 5 pts: complete ticket
  
# Input
* Line 1: Three space-separated integers: number of trainCars, number of tickets (numTickets) you have, and number of available routes (numRoutes) on the board.
* Line 2: Nine space-separated integers for the number of red, yellow, green, blue, white, black, orange, pink, and engine cards you have in your hand.
* Next numTickets lines: One line for each ticket in your hand. Each line has an integer for the points value of the ticket, followed by two space-separated city names.
* Next numRoutes lines: One line for each available route on the board. Each line has an integer for the length of the route (in number of train cars), an integer for the number of requiredEngines, a color (Red, Yellow, Green, Blue, White, Black, Orange, Pink, or Gray), and two space-separated city names.

# Output
* A single integer indicating the maximum possible score.

# Constraints
* 0 ≤ trainCars < 30
* 0 ≤ numTickets < 30
* 0 ≤ numRoutes < 30
