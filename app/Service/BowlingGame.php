<?php
namespace App\Service;

class BowlingGame
{
    public $score;

    /**
     * BowlingGame constructor.
     * @param int $score
     */
    public function __construct()
    {
        $this->score = 0;
    }


    public function record_shot($pins)
    {
        $this->score += $pins;
    }
}