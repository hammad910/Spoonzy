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
}
