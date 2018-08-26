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
        $this->strike_bonus_count = 0;
        $this->double_bonus_count = 0;
    }

    public function record_shot($pins)
    {
        $this->score += $pins;

        $this->calc_spare_bonus($pins);

        $this->calc_strike_bonus($pins);

        $this->last_pins = $pins;

        $this->proceed_next_shot();
    }

    /**
     * @param $pins
     */
    public function calc_spare_bonus($pins): void
    {
        if ($this->spare) {
            $this->score += $pins;
            $this->spare = false;
        }
        if ($this->shot_no == 2 && $this->last_pins + $pins == 10) {
            $this->spare = true;
        }
    }

    /**
     * @param $pins
     */
    public function calc_strike_bonus($pins): void
    {
        if ($this->strike_bonus_count > 0) {
            $this->score += $pins;
            $this->strike_bonus_count--;
        }
        if ($this->double_bonus_count > 0) {
            $this->score += $pins;
            $this->double_bonus_count--;
        }
        if ($pins == 10) {
            if ($this->strike_bonus_count == 0) {
                $this->strike_bonus_count = 2;
            } else {
                $this->double_bonus_count = 2;
            }
        }
    }

    public function proceed_next_shot(): void
    {
        if ($this->shot_no == 1) {
            $this->shot_no = 2;
        } else {
            $this->shot_no = 1;
        }
    }
}