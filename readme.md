# PHP Minesweeper

## Approach
I have tried to go for an Object Oriented approach for minesweeper.There are three main classes
Minsweeper
Grid
Cell
With this approach extension/addiding is much flexible and scope for new features is already in place.

## Minesweeper Class
This class encapsulates Grid and Cell. It also performs minesweeper operations . Minsweeper is composed of Gird and Cell. Class is also responsible for storing complete state of board.

## Grid Class
Grid encapsulates complete grid/board. It is composes of Cells objects which make up the board/grid.

## Cell Class
Smallest entity of Minesweeper is Cell. All attributes of a single cell are defined in this class.

## StateManager Class
This class performs statement managment. It uses serialization to store Minesweeper state object into session.

## Framework
Going with any of the existing framewrok was overkill for this task. So I ended up writing a custome micro framework approach, Which I can use for future enhancement as well.

## Frontend
Since there was no hard set requirement on for the UI, I decided to go with basic HTML with Jquery to perform basic UI operations. React can be a good UI for this application.

## Following requirements are complete
1) create an NxN grid and randomly populate it with M mines (denoted by "X"s)
2) Fill in the numbers on the grid - the numbers show how many mines are in adjacent cells (left, right, top, bottom, diagonal)
3) Create a web interface to display the grid to the user. To begin with, assume that N = M = 10 in all cases. Initially, all the cells in the grid should be blank - as the user clicks on them, they will be revealed.
4) If a mine is revealed, it's game over - announce this to the user, then start a new game.
If they reveal every square that isn't a mine, they win - same deal.

## Additional requirements completed
1) counter for number of non-mined squares remaining;
2) If a square is revealed to be blank (no mines or hint numbers), auto-reveal all
adjacent blank squares;

Scope for following is added into the code but It is not added into UI.
 for "The ability to choose board size and difficulty (number of mines)"

# Installation
PHP 7.4

Even though there is no 3rd party packge used
```bash
composer install
```
Start the server
```bash
php -S localhost:8000
```
from the browser.
http://localhost:8000


# Author
Jahanzeb
Senior Software Engineer
[LinkedIn](https://www.linkedin.com/in/jahanzeb-yasin/)


