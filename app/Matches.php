<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Matches extends Model
{
    protected $table = "matches";


    /*
     * Gets a match by the id, in this return the board is ready to be used as an array
     */
    public function getMatchById($id)
    {
        $match = parent::find($id);
        if($match){

            $match->board = $this->changesBoardToArray($match->board);
            return $match;
        }
        return null;
    }

    /*
     * make the player move and return the updated match board
     */
    public function makeMove($id_match, $position)
    {

        $match = $this->getMatchById($id_match);

        if ($match) {
            // $board receive the match from db
            $board = $match->board;
            // $board receive the current player in the move position
            $board[$position] = $match->next;
            // return the updated board to db
            $match->board = implode(",",$board);
            //change the player
            $match->next = ($match->next == 1) ? 2 : 1;
            //check if there is a winner and changes it
            $match->winner = $this->checkWinner($match->board);
            $match->save();
            $match->board = $this->changesBoardToArray($match->board);

            return array("id" => $match->id_match,
                         "name" => $match->name_match,
                         "next" => $match->next,
                         "winner" => $match->winner,
                         "board" => $match->board);
        }

        return null;
    }

    /*
     * Prepare the board to be used as an array
     */
    private function changesBoardToArray($board)
    {
        return array_map('intval', explode(',', $board));
    }

    /*
     * Check if there's a winner
     */
    public function checkWinner($board)
    {
        $victoryPatterns =[
            [0, 1, 2],
            [0, 4, 8],
            [0, 3, 6],
            [1, 4, 7],
            [2, 5, 8],
            [2, 4, 6],
            [3, 4, 5],
            [6, 7, 8]
        ];

        foreach ($victoryPatterns as $victoryPattern) {
            $winner = $board[$victoryPattern[0]] != null
                && $board[$victoryPattern[0]]==($board[$victoryPattern[1]])
                && $board[$victoryPattern[0]]==($board[$victoryPattern[2]]);

            if ($winner) {
                return $board[$victoryPattern[0]];
            }
        }

        return 0;
    }

}
