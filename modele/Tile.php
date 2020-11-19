<?php
session_start();


class Tile {

    private $number;

    public function __construct(int $number) {
        if(($number & ($number - 1)) == 0) {
            $this->number = $number;
        }else throw new InvalidArgumentException("Le nombre ($number) doit être une puissance de 2");
    }

    public function toString() : string {
        return "<div class='tile tile$this->number'>$this->number</div>";
    }

}