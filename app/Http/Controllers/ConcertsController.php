<?php

namespace App\Http\Controllers;

use App\Concert;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConcertsController extends Controller
{
    public function show(int $id): View
    {
        $concert = Concert::published()->findOrFail($id);

        return view('concerts.show')->with('concert', $concert);
    }
}
