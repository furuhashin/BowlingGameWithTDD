<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Service\BowlingGame;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BowlingGameTest extends TestCase
{
    /**
     * @var BowlingGame
     */
    private $game;

    public function setUp()
    {
        $this->game = new BowlingGame();
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test全ての投球でガター()
    {
        $this->record_many_shots(20,0);
        $this->assertSame(0, $this->game->score);
    }

    public function test全ての投球で１ピンだけ倒した()
    {
        $this->record_many_shots(20,1);
        $this->assertSame(20,$this->game->score);
    }

    public function record_many_shots($count,$pins): void
    {
        for ($i = 1; $i <= $count; $i++) {
            $this->game->record_shot($pins);
        }
    }
}
