<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Relations;


use App\Matches;

class MatchController extends Controller {

    public function index() {
        return view('index');
    }

    /**
     * Returns a list of matches to the view
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function matches() {
        return response()->json($this->listAllMatches());
    }

    /**
     * Returns the list of all matches(intern/controller use)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function listAllMatches() {
        return Matches::all();
    }

    /**
     * Returns the state of a single match (return by id)
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function match($id) {
        $match = New Matches;
        $match = $match->getMatchById($id);

        return response()->json($match);
    }

    /**
     * Makes a move in a match
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function move($id_match) {
        $position = Input::get('position');
        $player = Input::get('player');

        $matchModel = new Matches();
        $match = $matchModel->makeMove($id_match, $position);

        return response()->json($match);
    }

    /**
     * Creates a new match and returns the new list of matches
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create() {
        $last_match = Matches::orderByDesc('id_match')->first();

        /*$data = new Matches();
        $data->name_match = 'Match '.($last_match)?$last_match->id + 1 : 1;
        $data->next = 0;
        $data->winner = 0;
        $data->board = '0,0,0,0,0,0,0,0,0'
        $data->save();*/

        Matches::create([
            'name_match' => 'Match '.($last_match)?$last_match->id + 1 : 1,
            'next' => 0,
            'winner' => 0,
            'board' => '0,0,0,0,0,0,0,0,0'
        ]);

        return response()->json($this->listAllMatches());
    }

    /**
     * Deletes the match and returns the new list of matches
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id) {
        Matches::destroy($id);

        return response()->json($this->listAllMatches());
    }

}