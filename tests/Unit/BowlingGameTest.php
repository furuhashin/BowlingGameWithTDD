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

    public function testストライクをとると次の２球分のピン数を加算()
    {
        $this->game->record_shot(10);
        $this->game->record_shot(3);
        $this->game->record_shot(3);
        $this->game->record_shot(1);
        $this->record_many_shots(15,0);
        $this->assertSame(23,$this->game->score);
    }

    public function test連続ストライクすなわちダブル()
    {
        $this->game->record_shot(10); //ここでのボーナスは10+3 2
        $this->game->record_shot(10); //ここでのボーナスは3+1  1 2
        $this->game->record_shot(3); // 0 1
        $this->game->record_shot(1); // 0 0
        $this->record_many_shots(15,0);
        $this->assertSame(41,$this->game->score); //ボーナス+実際に倒したピン数 = 17+24= 41
    }

    public function test3連続ストライクすなわちターキー()
    {
        $this->game->record_shot(10); //ここでのボーナスは10+10 2 strike_bonus_countに２が入る
        $this->game->record_shot(10); //ここでのボーナスは10+3  1 2 double_bonus_countに２が入る
        $this->game->record_shot(10); // ここでのボーナスは3+1  0 1 2 strike_bonus_countに２が入る
        $this->game->record_shot(3);
        $this->game->record_shot(1);
        $this->record_many_shots(12,0);
        $this->assertSame(71,$this->game->score); //ボーナス+実際に倒したピン数 = 37+34= 71
    }

//    public function test1投目は０で二球目で10ピン()
//    {
//        $this->game->record_shot(0);
//        $this->game->record_shot(10);
//        $this->game->record_shot(3);
//        $this->game->record_shot(1);
//        $this->record_many_shots(16,0);
//        $this->assertSame(17,$this->game->score);
//    }

    public function record_many_shots($count,$pins): void
    {
        for ($i = 1; $i <= $count; $i++) {
            $this->game->record_shot($pins);
        }
    }
}
