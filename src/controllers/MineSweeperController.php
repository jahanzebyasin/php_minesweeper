<?php
use Minesweeper\CellState;
use Minesweeper\Minesweeper;
use Minesweeper\StateHandler;

class MinesweeperController {
    public function record($request) {
        $mineSweeper = StateHandler::getState();
        $mineSweeper->evaluateMove(
            intval(intval($request['x'])),
            intval(intval($request['y']))
        );
        StateHandler::setState($mineSweeper);
        return $this->renderHtmlContent($mineSweeper);
    }

    public function reset($request) {
        //create new minesweeper and save sate
         $mineSweeper = new Minesweeper(
            intval($request['n']),
            intval($request['n']),
            intval($request['m'])
        );
        $mineSweeper->setMines();
        $mineSweeper->setAdjacents();
        StateHandler::setstate($mineSweeper);
        return $this->renderHtmlContent($mineSweeper);
    }

    public function create($request) {
        //create new minesweeper and save sate
        $mineSweeper = new Minesweeper(
            intval($request['n']),
            intval($request['n']),
            intval($request['m'])
        );
        $mineSweeper->setMines();
        $mineSweeper->setAdjacents();
        StateHandler::setstate($mineSweeper);
        return $this->renderHtmlContent($mineSweeper);
    }

    public function home($request) {
        return file_get_contents(__DIR__."/../views/index.html");
    }

    private function renderHtmlContent(Minesweeper $mineSweeper) {
        $html = '<div class="msg-box">'.displayMessage($mineSweeper).'</div>';
        $html .= '<div class="grid">';
        for($i = 0; $i<$mineSweeper->getRows(); $i++) {
            for($j=0; $j<$mineSweeper->getCols(); $j++) {
                $html .=  '<div class="cell">'.
                '<input type="button"'.
                 'x="'.$i.'"'.
                 'y="'.$j.'"'. 
                 'onclick="autoPost('.$i.','.$j.')"'.
                 'value="'.displayLabel($mineSweeper->getGrid()[$i][$j]).'"'.
                 isDisabled($mineSweeper->getGrid()[$i][$j]). ' />'.
                 '</div>';
            }
            $html .= '<br/>';
        }
        $html .= '<br/>';

        return  $html;

    }
}