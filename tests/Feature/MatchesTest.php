<?php

namespace Tests\Feature;

use App\Matches;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class MatchesTest extends TestCase
{

    /**
     * Test delete a match
     */
    public function testDeleteMatch()
    {
        $answer = $this->delete('api/match/1');
        $answer->assertStatus(200);
    }

    /**
     * Test create a match
     */
    public function testCreateMatch()
    {
        $answer = $this->post('api/match');
        $answer->assertStatus(200);
    }

    /**
     * Test checkWinner.
     */
    public function testCheckWinnerMatches()
    {
        // X == 1
        // O == 2
        $boardWinner = [
            1, 2, 2,
            2, 2, 1,
            1, 1, 1
        ];
        $boardNoWinner = [
            1, 2, 2,
            2, 2, 1,
            1, 1, 2
        ];
        $matchModel = new Matches();
        $this->assertEquals(1, $matchModel->checkWinner($boardWinner));
        $this->assertEquals(0, $matchModel->checkWinner($boardNoWinner));
    }


}
