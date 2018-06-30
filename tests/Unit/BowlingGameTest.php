<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Service\BowlingGame;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BowlingGameTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAllGutterGame()
    {
        $game = new BowlingGame();
        for ($i = 1; $i <= 20; $i++) {
            $game->record_shot();
        }
        $this->assertSame(0,$game->score);
    }
}
