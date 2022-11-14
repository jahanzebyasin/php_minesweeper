<?php
namespace Minesweeper;

class StateHandler {
    static function setState($mineSweeper) {
        $_SESSION['minesweeper'] = serialize($mineSweeper);
    }

    static function getState() {
        return unserialize($_SESSION['minesweeper']);
    }
}