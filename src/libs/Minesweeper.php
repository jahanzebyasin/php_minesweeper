<?php 
namespace Minesweeper;

use Exception;

trait Validator {
    public function validatePos(int $i, int $j, int $n, int $m) {
        if ($i < 0 || $j < 0 || $i > $n - 1 || $j > $m - 1) {
            return false;
        }
        return true;
    }
}

class Minesweeper {
    private Grid $_grid;
    private int $_minesCount;
    private int $_rows;
    private int $_cols;
    private bool $_gameOver = false;
    private bool $_winningCondition = false;
    private int $_remainingCells;
    private int $_remainingMines;

    use Validator;

    public function __construct(int $rows, int $cols, int $minesCount)
    {
        $this->_grid = new Grid($rows, $cols);
        $this->_rows = $rows;
        $this->_cols = $cols;
        $this->_minesCount = $minesCount;
        $this->_remainingCells = $rows * $cols;
        $this->_remainingMines = $minesCount;
    }

    public function getGrid() {
        return $this->_grid->getGrid();
    }

    public function getRows() {
        return $this->_rows;
    }

    public function getCols() {
        return $this->_cols;
    }

    public function getRemianingMines() {
        return $this->_remainingMines;
    }

    public function getRemianingCells() {
        return $this->_remainingCells;
    }

    public function isGameOver() {
        return $this->_gameOver;
    }

    public function isWinningCondition() {
        return $this->_winningCondition;
    }

    public function setMines() {
        $count = 1;
        while($count <= $this->_minesCount) {
            //generate a random number between 0 and max row
            //generate a random number between 0 and max c0lumns
             $rowPosRnd = rand(0,$this->_rows-1);
             $colPosRnd = rand(0,$this->_cols-1);
             if(!$this->_grid->_board[$rowPosRnd][$colPosRnd]->hasMine()) {
                $this->_grid->_board[$rowPosRnd][$colPosRnd]->setMine(true);
                $count++;
             }
        }
    }

    public function setAdjacents() {
        for($i = 0; $i < count($this->getGrid()); $i++) {
            for($j=0; $j< count($this->getGrid()[$i]); $j++ ) {
                //top left
                $adjacents = array();
                if($this->validatePos($i - 1, $j -1, count($this->getGrid()), count($this->getGrid()[$i]) )) {
                    array_push($adjacents, $this->_grid->_board[$i - 1][$j -1]);
                    if($this->_grid->_board[$i][$j]->hasMine()) {
                        //add mine count to adjacent
                        $this->_grid->_board[$i - 1][$j -1]->setAdjacentMineCount();
                    }
                }

                //top Middle
                if($this->validatePos($i - 1, $j, count($this->getGrid()), count($this->getGrid()[$i]) )) {
                    array_push($adjacents, $this->_grid->_board[$i - 1][$j]);
                    if($this->_grid->_board[$i][$j]->hasMine()) {
                        //add mine count to adjacent
                        $this->_grid->_board[$i - 1][$j]->setAdjacentMineCount();
                    }
                }

                //top right
                if($this->validatePos($i - 1, $j + 1, count($this->getGrid()), count($this->getGrid()[$i]) )) {
                    array_push($adjacents, $this->_grid->_board[$i - 1][$j + 1]);
                    if($this->_grid->_board[$i][$j]->hasMine()) {
                        //add mine count to adjacent
                        $this->_grid->_board[$i - 1][$j + 1]->setAdjacentMineCount();
                    }
                }

                 //left
                if($this->validatePos($i, $j - 1, count($this->getGrid()), count($this->getGrid()[$i]) )) {
                    array_push($adjacents, $this->_grid->_board[$i][$j - 1]);
                    if($this->_grid->_board[$i][$j]->hasMine()) {
                        //add mine count to adjacent
                        $this->_grid->_board[$i][$j - 1]->setAdjacentMineCount();
                    }
                }

                //right
                if($this->validatePos($i, $j + 1, count($this->getGrid()), count($this->getGrid()[$i]) )) {
                    array_push($adjacents, $this->_grid->_board[$i][$j + 1]);
                    if($this->_grid->_board[$i][$j]->hasMine()) {
                        //add mine count to adjacent
                        $this->_grid->_board[$i][$j + 1]->setAdjacentMineCount();
                    }
                }

                 //bottom left
                if($this->validatePos($i + 1, $j -1, count($this->getGrid()), count($this->getGrid()[$i]) )) {
                    array_push($adjacents, $this->_grid->_board[$i + 1][$j - 1]);
                    if($this->_grid->_board[$i][$j]->hasMine()) {
                        //add mine count to adjacent
                        $this->_grid->_board[$i + 1][$j - 1]->setAdjacentMineCount();
                    }
                }

                 //bottom middle
                if($this->validatePos($i + 1, $j, count($this->getGrid()), count($this->getGrid()[$i]) )) {
                    array_push($adjacents, $this->_grid->_board[$i + 1][$j]);
                    if($this->_grid->_board[$i][$j]->hasMine()) {
                        //add mine count to adjacent
                        $this->_grid->_board[$i + 1][$j]->setAdjacentMineCount();
                    }
                }

                //bottom right
                if($this->validatePos($i + 1, $j + 1, count($this->getGrid()), count($this->getGrid()[$i]) )) {
                    array_push($adjacents, $this->_grid->_board[$i + 1][$j + 1]);
                    if($this->_grid->_board[$i][$j]->hasMine()) {
                        //add mine count to adjacent
                        $this->_grid->_board[$i + 1][$j + 1]->setAdjacentMineCount();
                    }
                }

                $this->_grid->_board[$i][$j]->setAdjacentCells($adjacents);
            }
        }
    }

    public function evaluateMove(int $gridRowPos, int $gridColPos) {
        try {
            //check if grid cell exists
            if(!$this->validatePos($gridRowPos, $gridColPos, $this->_rows, $this->_cols)) {
                throw new Exception("Invalid Move");
            }
            //check if it is mine at this position
            if($this->_grid->_board[$gridRowPos][$gridColPos]->hasMine()) {
                //reveale complete grid
                //reveal all mines
                for($i = 0; $i < count($this->getGrid()); $i++) {
                    for($j=0; $j< count($this->getGrid()[$i]); $j++ ) {
                        if($this->_grid->_board[$i][$j]->hasMine()) {
                            $this->_grid->_board[$i][$j]->setLabel('X');
                        }
                        $this->_grid->_board[$i][$j]->setState(CellState::$Visible);
                    }
                }
                //set game over
                $this->_gameOver = true;
            } else {
                //clear some cells
                //for clearing, choosing to reveal adjacent cells based on random count
                $minesDiffused = 0;
                $this->_grid->_board[$gridRowPos][$gridColPos]->setState(CellState::$Visible);
                // if($this->_grid->_board[$gridRowPos][$gridColPos]->getAdjacentMineCount() == 0) {
                    $randCellsToReveal = rand(0,6);
                    while($randCellsToReveal != 0) {
                        $randValue = rand(0, count($this->_grid->_board[$gridRowPos][$gridColPos]->getAdjacentCells()) - 1);
                        $adjacentCell = $this->_grid->_board[$gridRowPos][$gridColPos]->getAdjacentCells()[$randValue];
                        if($this->_grid->_board[$adjacentCell->getRowPos()][$adjacentCell->getColPos()]->hasMine())
                            $minesDiffused++;
                        $this->_grid->_board[$adjacentCell->getRowPos()][$adjacentCell->getColPos()]->setState(CellState::$Visible);
                        $this->_grid->_board[$adjacentCell->getRowPos()][$adjacentCell->getColPos()]->setMine(false);
                        $this->_grid->_board[$adjacentCell->getRowPos()][$adjacentCell->getColPos()]->setLabel(
                            (
                                $this->_grid->_board[$adjacentCell->getRowPos()][$adjacentCell->getColPos()]->getAdjacentMineCount() == 0 ? 
                                ' ' : $this->_grid->_board[$adjacentCell->getRowPos()][$adjacentCell->getColPos()]->getAdjacentMineCount()
                            )
                        );
                        
                        --$randCellsToReveal;
                    // }
                }
                //check winning condition
                $visibleCellCount = 0;
                for($i = 0; $i < count($this->getGrid()); $i++) {
                    for($j=0; $j< count($this->getGrid()[$i]); $j++ ) {
                        if($this->_grid->_board[$i][$j]->getState() == CellState::$Visible) {
                            $visibleCellCount++;
                        }
                    }
                }

                if($visibleCellCount == ($this->_rows * $this->_cols)) {
                    $this->_winningCondition = true;
                }

                //setting remaining cell counts
                $this->_remainingCells = ($this->_rows * $this->_cols) - $visibleCellCount;

                //setting remiang mines
                $this->_remainingMines = $this->_remainingMines - $minesDiffused;
            }
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    public function getUserView() {
        $cells = array();
        for($i = 0; $i < count($this->getGrid()); $i++) {
            for($j=0; $j< count($this->getGrid()[$i]); $j++ ) {
                $tempCell = array();
                $tempCell["state"] = $this->_grid->_board[$i][$j]->getState();
                $tempCell["label"] = $this->_grid->_board[$i][$j]->getLabel();
            }
        }
    }


}

class Grid {
    public $_rows;
    public $_columns;
    public $_board = array();

    public function __construct(int $rows, int $cols)
    {
        $this->_rows = $rows;
        $this->_columns = $cols;
        $this->setGrid();
    }

    public function setGrid() {
        for($i = 0; $i < $this->_rows; $i++){
            $this->_board[$i] = array();
            for($j = 0; $j < $this->_columns; $j++) {
                $this->_board[$i][$j] = new Cell($i,$j);
            }
        }
    }

    public function getGrid() {
        return $this->_board;
    }

    public function resetGrid() {
        unset($this->_board);
        $this->setGrid();
    }
}

class CellState {
    public static $Hidden = 1;
    public static $Visible = 2;
}

class Cell {
    private $_rowPos;
    private $_colPos;
    private $_hasMine = false;
    private $_state;
    private $_label = ' ';
    private $_adjacentMine = 0;

    public $_adjacentCells = array();

    public function __construct(int $rowPos, int $colPos)
    {
        $this->_rowPos = $rowPos;
        $this->_colPos = $colPos;
        $this->_state = CellState::$Hidden; // Hidden by default
    }

    public function getPosition() {
        return array("rowPos" => $this->_rowPos, "colPos" => $this->_colPos);
    }

    public function getRowPos() {
        return $this->_rowPos;
    }

    public function getColPos() {
        return  $this->_colPos;
    }

    public function setMine(bool $hasMine) {
        $this->_hasMine = $hasMine;
    }

    public function setState($state) {
        $this->_state = $state;
    }

    public function setLabel($label) {
        $this->_label = $label;
    }

    public function setAdjacentCells($adjacentsArray) {
        $this->_adjacentCells = $adjacentsArray;
    }

    public function setAdjacentMineCount() {
        $this->_adjacentMine = $this->_adjacentMine + 1;
    }

    public function hasMine() {
        return $this->_hasMine;
    }

    public function getState() {
        return $this->_state;
    }

    public function getLabel() {
        return $this->_label;
    }

    public function getAdjacentMineCount() {
        return $this->_adjacentMine;
    }

    public function getAdjacentCells() {
        return $this->_adjacentCells;
    }

}
