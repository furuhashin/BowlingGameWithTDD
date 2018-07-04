<?php
namespace App\Service;

class BowlingGame
{
    public $score;
    public $round;

    /**
     * BowlingGame constructor.
     * @param int $score
     */
    public function __construct()
    {
        $this->score = 0;
        $this->spare = false;
        $this->last_pins = 0;
        $this->shot_no = 1;
    }

    public function record_shot($pins)
    {
        $this->score += $pins;
        if ($this->spare) {
            $this->score += $pins;
            $this->spare = false;
        }
        if ($this->shot_no == 2 && $this->last_pins + $pins == 10) {
            $this->spare = true;
        }
        $this->last_pins = $pins;
        if ($this->shot_no == 1) {
            $this->shot_no = 2;
        } else {
            $this->shot_no = 1;
        }
    }
}