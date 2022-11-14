<?php
use Minesweeper\CellState;

function displayLabel($cell) {
    if($cell->getState() == CellState::$Visible) {
      return $cell->getLabel();
    } else if($cell->getState() == CellState::$Hidden) {
      return ' ';
    }
  }
  
  function isDisabled($cell) {
    if($cell->getState() == CellState::$Visible) {
      return 'disabled="dsiabled"';
    } else if($cell->getState() == CellState::$Hidden) {
      return '';
    }
  }

  function displayMessage($mineSweeper) {
    if($mineSweeper->isGameOver()) {
      return '<span class="gameover">Game Over </span>';
    } else if($mineSweeper->isWinningCondition()) {
      return '<span class="winner">Win</span>';
    } else {
      return '<span class="stats"><b>Remaining:</b>'.$mineSweeper->getRemianingCells().'</span>';
    }
  }