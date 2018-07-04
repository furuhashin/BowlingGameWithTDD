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

    public function testスペアを取ると次の投球のピン数を加算()
    {
        $this->game->record_shot(3);
        $this->game->record_shot(7);
        $this->game->record_shot(4);
        $this->record_many_shots(17,0);
        $this->assertSame(18,$this->game->score);
    }

    public function test直前の投球との合計が10ピンでもフレーム違いはスペアではない()
    {
        $this->game->record_shot(2);
        $this->game->record_shot(5);
        $this->game->record_shot(5);
        $this->game->record_shot(1);
        $this->record_many_shots(16,0);
        $this->assertSame(13,$this->game->score);
    }

    public function record_many_shots($count,$pins): void
    {
        for ($i = 1; $i <= $count; $i++) {
            $this->game->record_shot($pins);
        }
    }
}
