<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExperimentController extends Controller
{
    public function index() {
        return view('users.experiments');
    }
}
