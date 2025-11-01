<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExperimentController extends Controller
{
    public function index() {
        return view('users.experiments');
    }
    public function creatorExperiment($id) {
        return view('users.experiment-creator', compact('id'));
    }
    public function fetchCreatorExperiement($id)
{
    $experiment = Content::with('creator')->findOrFail($id);

    return response()->json([
        'title' => $experiment->title,
        'category' => $experiment->category ?? 'Healthcare',
        'image_url' => asset('storage/' . $experiment->image),
        'user' => [
            'name' => $experiment->creator->name,
            'avatar' =>  $experiment->creator->avatar
        ],
        'completed' => 30,
        'total' => 40
    ]);
}

}
