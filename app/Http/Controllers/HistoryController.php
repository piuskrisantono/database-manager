<?php

namespace App\Http\Controllers;

use App\History;
use Illuminate\Http\Request;


class HistoryController extends Controller
{

    public function index()
    {
        $histories = History::with(['user'])->orderBy('created_at', 'DESC')->paginate(10);

        return view('history')->with(['histories' => $histories]);
    }

    public static function store($actor, $activity, $object, $description)
    {
        $history = new History();
        $history->actor = $actor;
        $history->activity = $activity;
        $history->object = $object;
        $history->description = $description;
        $history->save();
    }
}
